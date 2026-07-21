@extends('layouts.admin')

@section('title', 'Tambah Pembayaran')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl shadow-lg">

        <div class="border-b border-zinc-800 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">
                Tambah Pembayaran
            </h2>
        </div>

        <div class="p-6">

            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-500/10 border border-red-500 text-red-400 p-4">
                    <strong>Terjadi Kesalahan!</strong>
                    <ul class="list-disc ml-5 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.pembayaran.store') }}" method="POST">
                @csrf

                <div class="space-y-6">

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">Penyewaan</label>
                        <select name="penyewaan_id" class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3 focus:ring-amber-500 focus:border-amber-500" required>
                            <option value="">-- Pilih Penyewaan --</option>
                            @foreach($penyewaans as $p)
                                <option value="{{ $p->id }}" {{ old('penyewaan_id') == $p->id ? 'selected' : '' }}>
                                    #{{ $p->id }} - {{ $p->kendaraan->nama ?? 'Kendaraan' }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-zinc-500 mt-2">User akan mengikuti pemilik penyewaan yang dipilih.</p>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">Jumlah (Amount)</label>
                        <input type="number" step="0.01" name="amount" value="{{ old('amount') }}"
                            class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="500000" required>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">Metode Pembayaran</label>
                        <input type="text" name="payment_method" value="{{ old('payment_method') }}"
                            class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="Transfer / Saldo / Admin">
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">Status</label>
                        <select name="status" class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3 focus:ring-amber-500 focus:border-amber-500">
                            <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Paid" {{ old('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                            <option value="Failed" {{ old('status') == 'Failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>

                </div>

                <div class="flex justify-between mt-8">
                    <a href="{{ route('admin.pembayaran.index') }}"
                       class="px-5 py-3 rounded-lg bg-zinc-700 hover:bg-zinc-600 text-white">
                        ← Kembali
                    </a>

                    <button type="submit"
                        class="px-6 py-3 rounded-lg bg-amber-500 hover:bg-amber-400 text-black font-semibold">
                        Simpan Pembayaran
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection