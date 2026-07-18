@extends('layouts.admin')

@section('title', 'Detail Pembayaran')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-zinc-900 rounded-3xl border border-zinc-800 p-6 shadow">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-semibold">Detail Pembayaran</h1>
                <p class="text-zinc-400">Lihat detail transaksi dan perbarui status pembayaran.</p>
            </div>
            <a href="{{ route('admin.pembayaran.index') }}" class="bg-zinc-700 px-4 py-2 rounded-lg text-white hover:bg-zinc-600">
                ← Kembali
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-200 p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="bg-zinc-950 rounded-3xl border border-zinc-800 p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Informasi Pembayaran</h2>
                <div class="space-y-3 text-zinc-300">
                    <p><strong>ID Pembayaran:</strong> {{ $pembayaran->id }}</p>
                    <p><strong>Penyewa:</strong> {{ $pembayaran->user?->name ?? '-' }}</p>
                    <p><strong>Kendaraan:</strong> {{ $pembayaran->penyewaan?->kendaraan?->nama ?? '-' }}</p>
                    <p><strong>Jumlah:</strong> Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</p>
                    <p><strong>Metode:</strong> {{ $pembayaran->payment_method ?? '-' }}</p>
                    <p><strong>Status:</strong> {{ $pembayaran->status }}</p>
                    <p><strong>Tanggal Bayar:</strong> {{ $pembayaran->paid_at?->format('Y-m-d H:i') ?? '-' }}</p>
                </div>
            </div>

            <div class="bg-zinc-950 rounded-3xl border border-zinc-800 p-6">
                <h2 class="text-lg font-semibold text-white mb-4">Perbarui Status</h2>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-500/10 border border-red-500 text-red-300 p-4">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.pembayaran.update', $pembayaran) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm mb-2 text-zinc-300">Status</label>
                        <select name="status" class="w-full rounded-lg bg-zinc-900 border border-zinc-700 text-white px-4 py-3">
                            <option value="Pending" {{ old('status', $pembayaran->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Paid" {{ old('status', $pembayaran->status) == 'Paid' ? 'selected' : '' }}>Paid</option>
                            <option value="Failed" {{ old('status', $pembayaran->status) == 'Failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm mb-2 text-zinc-300">Tanggal Bayar</label>
                        <input type="datetime-local" name="paid_at" value="{{ old('paid_at', optional($pembayaran->paid_at)->format('Y-m-d\TH:i')) }}" class="w-full rounded-lg bg-zinc-900 border border-zinc-700 text-white px-4 py-3">
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-amber-500 py-3 text-black font-semibold hover:bg-amber-400">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
