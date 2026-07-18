@extends('layouts.admin')

@section('title', 'Tambah Kendaraan')

@section('content')

<div class="max-w-5xl mx-auto">

    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl shadow-lg">

        <div class="border-b border-zinc-800 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">
                Tambah Data Kendaraan
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

            <form action="{{ route('admin.kendaraan.store') }}" method="POST">

                @csrf

                <div class="grid grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">
                            Nama Kendaraan
                        </label>

                        <input
                            type="text"
                            name="nama"
                            value="{{ old('nama') }}"
                            class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="Contoh : Avanza"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">
                            Merk
                        </label>

                        <input
                            type="text"
                            name="merk"
                            value="{{ old('merk') }}"
                            class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3"
                            placeholder="Toyota"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">
                            Plat Nomor
                        </label>

                        <input
                            type="text"
                            name="plat_nomor"
                            value="{{ old('plat_nomor') }}"
                            class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3"
                            placeholder="DT 1234 AB"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">
                            Tahun
                        </label>

                        <input
                            type="number"
                            name="tahun"
                            value="{{ old('tahun') }}"
                            class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3"
                            placeholder="2025"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">
                            Harga Sewa / Hari
                        </label>

                        <input
                            type="number"
                            name="harga_sewa"
                            value="{{ old('harga_sewa') }}"
                            class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3"
                            placeholder="250000"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">
                            Status
                        </label>

                        <select
                            name="status"
                            class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3"
                            required>

                            <option value="">-- Pilih Status --</option>

                            <option value="tersedia"
                                {{ old('status')=='tersedia'?'selected':'' }}>
                                Tersedia
                            </option>

                            <option value="disewa"
                                {{ old('status')=='disewa'?'selected':'' }}>
                                Disewa
                            </option>

                        </select>

                    </div>

                </div>

                <div class="flex justify-between mt-8">

                    <a href="{{ route('admin.kendaraan.index') }}"
                       class="px-5 py-3 rounded-lg bg-zinc-700 hover:bg-zinc-600 text-white">
                        ← Kembali
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-lg bg-amber-500 hover:bg-amber-400 text-black font-semibold">
                        Simpan Kendaraan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection