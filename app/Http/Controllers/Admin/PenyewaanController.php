<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kendaraan;
use App\Models\Pembayaran;
use App\Models\Penyewaan;
use App\Models\User;
use Carbon\Carbon;
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
     * Tampilkan form tambah penyewaan untuk admin.
     */
    public function create()
    {
        $users = User::all();
        $kendaraans = Kendaraan::where('status', 'tersedia')->get();

        return view('admin.penyewaan.create', compact('users', 'kendaraans'));
    }

    /**
     * Simpan penyewaan baru dari admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal_sewa' => 'required|date',
            'lama_sewa'    => 'required|integer|min:1',
            'status'       => 'required|string|in:Pending,Disetujui,Dibatalkan,Selesai',
        ]);

        $kendaraan = Kendaraan::findOrFail($request->kendaraan_id);
        $start = Carbon::parse($request->tanggal_sewa);
        $end = (clone $start)->addDays($request->lama_sewa - 1);

        $existing = Penyewaan::where('kendaraan_id', $kendaraan->id)
            ->whereIn('status', ['Pending', 'Disetujui'])
            ->get();

        foreach ($existing as $e) {
            $es = Carbon::parse($e->tanggal_sewa);
            $ee = (clone $es)->addDays($e->lama_sewa - 1);

            if (! ($ee->lt($start) || $es->gt($end))) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Kendaraan sudah dibooking pada rentang tanggal yang dipilih.');
            }
        }

        $total = $kendaraan->harga_sewa * $request->lama_sewa;

        DB::transaction(function () use ($request, $kendaraan, $total) {
            $penyewaan = Penyewaan::create([
                'user_id'      => $request->user_id,
                'kendaraan_id' => $request->kendaraan_id,
                'tanggal_sewa' => $request->tanggal_sewa,
                'lama_sewa'    => $request->lama_sewa,
                'total_harga'  => $total,
                'status'       => $request->status,
            ]);

            if ($request->status === 'Disetujui') {
                $kendaraan->update(['status' => 'disewa']);
            }

            Pembayaran::create([
                'penyewaan_id'   => $penyewaan->id,
                'user_id'        => $request->user_id,
                'amount'         => $total,
                'status'         => 'Pending',
                'payment_method' => 'Admin',
                'paid_at'        => null,
            ]);

            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'create_penyewaan',
                'subject_type' => Penyewaan::class,
                'subject_id' => $penyewaan->id,
                'before' => null,
                'after' => json_encode($penyewaan->toArray()),
                'ip' => request()->ip(),
            ]);
        });

        return redirect()
            ->route('admin.penyewaan.index')
            ->with('success', 'Penyewaan berhasil ditambahkan.');
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
     * Tampilkan form edit penyewaan untuk admin.
     */
    public function edit(Penyewaan $penyewaan)
    {
        $users = User::all();
        $kendaraans = Kendaraan::where('status', 'tersedia')
            ->orWhere('id', $penyewaan->kendaraan_id)
            ->get();

        return view('admin.penyewaan.edit', compact('penyewaan', 'users', 'kendaraans'));
    }

    /**
     * Update penyewaan.
     */
    public function update(Request $request, Penyewaan $penyewaan)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal_sewa' => 'required|date',
            'lama_sewa'    => 'required|integer|min:1',
            'status'       => 'required|string|in:Pending,Disetujui,Dibatalkan,Selesai',
        ]);

        $start = Carbon::parse($request->tanggal_sewa);
        $end = (clone $start)->addDays($request->lama_sewa - 1);

        $existing = Penyewaan::where('kendaraan_id', $request->kendaraan_id)
            ->whereIn('status', ['Pending', 'Disetujui'])
            ->where('id', '!=', $penyewaan->id)
            ->get();

        foreach ($existing as $e) {
            $es = Carbon::parse($e->tanggal_sewa);
            $ee = (clone $es)->addDays($e->lama_sewa - 1);

            if (! ($ee->lt($start) || $es->gt($end))) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Kendaraan sudah dibooking pada rentang tanggal yang dipilih.');
            }
        }

        $kendaraanBaru = Kendaraan::findOrFail($request->kendaraan_id);
        $kendaraanLama = Kendaraan::find($penyewaan->kendaraan_id);

        DB::transaction(function () use ($request, $penyewaan, $kendaraanBaru, $kendaraanLama) {
            if ($penyewaan->kendaraan_id !== $request->kendaraan_id && $kendaraanLama) {
                $kendaraanLama->update(['status' => 'tersedia']);
            }

            if ($request->status === 'Disetujui') {
                $kendaraanBaru->update(['status' => 'disewa']);
            } elseif (in_array($request->status, ['Dibatalkan', 'Selesai'])) {
                $kendaraanBaru->update(['status' => 'tersedia']);
            }

            $penyewaan->update([
                'user_id'      => $request->user_id,
                'kendaraan_id' => $request->kendaraan_id,
                'tanggal_sewa' => $request->tanggal_sewa,
                'lama_sewa'    => $request->lama_sewa,
                'total_harga'  => $kendaraanBaru->harga_sewa * $request->lama_sewa,
                'status'       => $request->status,
            ]);

            if ($penyewaan->pembayaran) {
                $penyewaan->pembayaran->update([
                    'amount' => $kendaraanBaru->harga_sewa * $request->lama_sewa,
                ]);
            }

            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'update_penyewaan',
                'subject_type' => Penyewaan::class,
                'subject_id' => $penyewaan->id,
                'before' => null,
                'after' => json_encode($penyewaan->toArray()),
                'ip' => request()->ip(),
            ]);
        });

        return redirect()
            ->route('admin.penyewaan.index')
            ->with('success', 'Penyewaan berhasil diperbarui.');
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

