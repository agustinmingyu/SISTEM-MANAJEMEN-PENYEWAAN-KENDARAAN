@extends('layouts.admin')

@section('title', 'Edit Penyewaan')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="border-b border-zinc-800 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Edit Penyewaan</h2>
            <p class="text-sm text-zinc-400">Perbarui data penyewaan dan status kendaraan.</p>
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

            @if(session('error'))
                <div class="mb-6 rounded-lg bg-red-500/10 border border-red-500 text-red-400 p-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.penyewaan.update', $penyewaan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">User</label>
                        <select name="user_id" class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3">
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $penyewaan->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">Kendaraan</label>
                        <select name="kendaraan_id" class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3">
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}" {{ old('kendaraan_id', $penyewaan->kendaraan_id) == $kendaraan->id ? 'selected' : '' }}>
                                    {{ $kendaraan->nama }} - {{ $kendaraan->plat_nomor }} (Rp {{ number_format($kendaraan->harga_sewa,0,',','.') }}/hari)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">Tanggal Sewa</label>
                        <input type="date" name="tanggal_sewa" value="{{ old('tanggal_sewa', $penyewaan->tanggal_sewa) }}" class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3" required>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">Lama Sewa (hari)</label>
                        <input type="number" name="lama_sewa" min="1" value="{{ old('lama_sewa', $penyewaan->lama_sewa) }}" class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3" required>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm mb-2 text-zinc-300">Status</label>
                        <select name="status" class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Pending" {{ old('status', $penyewaan->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Disetujui" {{ old('status', $penyewaan->status) == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ old('status', $penyewaan->status) == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="Selesai" {{ old('status', $penyewaan->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row sm:justify-between mt-8">
                    <a href="{{ route('admin.penyewaan.index') }}" class="px-5 py-3 rounded-lg bg-zinc-700 hover:bg-zinc-600 text-white text-center">
                        ← Kembali
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-lg bg-amber-500 hover:bg-amber-400 text-black font-semibold">
                        Perbarui Penyewaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
