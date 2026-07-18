<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pembayaran;
use App\Models\Penyewaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyewaanController extends Controller
{
	/**
	 * Tampilkan daftar penyewaan untuk admin.
	 */
	public function index(Request $request)
	{
		$query = Penyewaan::with(['user', 'kendaraan', 'pembayaran']);

		if ($request->filled('status')) {
			$query->where('status', $request->status);
		}

		if ($request->filled('q')) {
			$q = $request->q;
			$query->where(function ($qbuilder) use ($q) {
				$qbuilder->whereHas('user', function ($u) use ($q) {
					$u->where('name', 'like', "%{$q}%");
				})->orWhereHas('kendaraan', function ($k) use ($q) {
					$k->where('nama', 'like', "%{$q}%");
				})->orWhere('id', $q);
			});
		}

		if ($request->filled('export') && $request->export === 'csv') {
			$rows = $query->latest()->get();

			$filename = 'penyewaan_' . now()->format('Ymd_His') . '.csv';
			$headers = [
				'Content-Type' => 'text/csv',
				'Content-Disposition' => "attachment; filename=\"{$filename}\"",
			];

			$columns = ['id', 'user', 'kendaraan', 'tanggal_sewa', 'lama_sewa', 'total_harga', 'status'];

			$callback = function () use ($rows, $columns) {
				$FH = fopen('php://output', 'w');
				fputcsv($FH, $columns);
				foreach ($rows as $r) {
					fputcsv($FH, [
						$r->id,
						$r->user->name ?? '-',
						$r->kendaraan->nama ?? '-',
						$r->tanggal_sewa,
						$r->lama_sewa,
						$r->total_harga,
						$r->status,
					]);
				}
				fclose($FH);
			};

			return response()->stream($callback, 200, $headers);
		}

		$penyewaans = $query->latest()->paginate(20)->withQueryString();

		return view('admin.penyewaan.index', compact('penyewaans'));
	}

	/**
	 * Tampilkan detail penyewaan.
	 */
	public function show(Penyewaan $penyewaan)
	{
		$penyewaan->load(['user', 'kendaraan', 'pembayaran']);

		return view('admin.penyewaan.show', compact('penyewaan'));
	}

	/**
	 * Update status penyewaan (mis. Disetujui, Dibatalkan, Selesai).
	 */
	public function update(Request $request, Penyewaan $penyewaan)
	{
		$request->validate([
			'status' => 'required|string|in:Pending,Disetujui,Dibatalkan,Selesai',
		]);

		DB::transaction(function () use ($request, $penyewaan) {
			$old = $penyewaan->toArray();

			$penyewaan->status = $request->status;
			$penyewaan->save();

			$kendaraan = Kendaraan::find($penyewaan->kendaraan_id);

			if ($kendaraan) {
				if (in_array($request->status, ['Dibatalkan', 'Selesai'])) {
					$kendaraan->update(['status' => 'tersedia']);
				} elseif ($request->status === 'Disetujui') {
					$kendaraan->update(['status' => 'disewa']);
				}
			}

			\App\Models\ActivityLog::create([
				'user_id' => auth()->id(),
				'action' => 'update_penyewaan_status',
				'subject_type' => Penyewaan::class,
				'subject_id' => $penyewaan->id,
				'before' => json_encode($old),
				'after' => json_encode($penyewaan->toArray()),
				'ip' => request()->ip(),
			]);
		});

		return redirect()
			->back()
			->with('success', 'Status penyewaan berhasil diperbarui.');
	}

	/**
	 * Hapus penyewaan.
	 */
	public function destroy(Penyewaan $penyewaan)
	{
		DB::transaction(function () use ($penyewaan) {
			$old = $penyewaan->toArray();

			// Kembalikan status kendaraan
			$kendaraan = Kendaraan::find($penyewaan->kendaraan_id);
			if ($kendaraan) {
				$kendaraan->update(['status' => 'tersedia']);
			}

			// Hapus pembayaran terkait
			Pembayaran::where('penyewaan_id', $penyewaan->id)->delete();

			$penyewaan->delete();

			\App\Models\ActivityLog::create([
				'user_id' => auth()->id(),
				'action' => 'delete_penyewaan',
				'subject_type' => Penyewaan::class,
				'subject_id' => $penyewaan->id,
				'before' => json_encode($old),
				'after' => null,
				'ip' => request()->ip(),
			]);
		});

		return redirect()
			->route('admin.penyewaan.index')
			->with('success', 'Penyewaan berhasil dihapus.');
	}
}

