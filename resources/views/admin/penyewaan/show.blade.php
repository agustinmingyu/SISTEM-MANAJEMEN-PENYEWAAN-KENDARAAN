@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Detail Penyewaan #{{ $penyewaan->id }}</h1>

    <div class="bg-white shadow rounded p-4 mb-4">
        <p><strong>User:</strong> {{ $penyewaan->user->name ?? '-' }} ({{ $penyewaan->user->email ?? '-' }})</p>
        <p><strong>Kendaraan:</strong> {{ $penyewaan->kendaraan->nama ?? '-' }}</p>
        <p><strong>Tanggal sewa:</strong> {{ $penyewaan->tanggal_sewa }}</p>
        <p><strong>Lama sewa:</strong> {{ $penyewaan->lama_sewa }} hari</p>
        <p><strong>Total:</strong> Rp {{ number_format($penyewaan->total_harga,0,',','.') }}</p>
        <p><strong>Status:</strong> {{ $penyewaan->status }}</p>
    </div>

    <div class="bg-white shadow rounded p-4 mb-4">
        <h2 class="font-semibold mb-2">Pembayaran</h2>
        @if($penyewaan->pembayaran)
            <p><strong>Jumlah:</strong> Rp {{ number_format($penyewaan->pembayaran->amount,0,',','.') }}</p>
            <p><strong>Status:</strong> {{ $penyewaan->pembayaran->status }}</p>
            <p><strong>Metode:</strong> {{ $penyewaan->pembayaran->payment_method }}</p>
            <p><strong>Waktu bayar:</strong> {{ $penyewaan->pembayaran->paid_at }}</p>
        @else
            <p>Tidak ada pembayaran tercatat.</p>
        @endif
    </div>

    <div class="flex gap-3">
        <form action="{{ route('admin.penyewaan.update', $penyewaan) }}" method="POST" class="inline">
            @csrf
            @method('PUT')
            <select name="status" class="border rounded p-2 mr-2">
                <option value="Pending" {{ $penyewaan->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Disetujui" {{ $penyewaan->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Dibatalkan" {{ $penyewaan->status == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                <option value="Selesai" {{ $penyewaan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Update Status</button>
        </form>

        <form action="{{ route('admin.penyewaan.destroy', $penyewaan) }}" method="POST" onsubmit="return confirm('Hapus penyewaan ini?')">
            @csrf
            @method('DELETE')
            <button class="bg-red-600 text-white px-4 py-2 rounded">Hapus</button>
        </form>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.penyewaan.index') }}" class="text-gray-600">Kembali</a>
    </div>
</div>
@endsection
