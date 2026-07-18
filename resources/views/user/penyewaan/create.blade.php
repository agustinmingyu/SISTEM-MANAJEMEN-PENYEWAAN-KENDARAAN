<?php
Route::get('/penyewaan', fn() => view('admin.penyewaan.index'))->name('penyewaan.index');
?>

<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Tambah Penyewaan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('user.penyewaan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idempotency_key" value="{{ $idempotencyKey ?? session('idempotency_key') }}" />

                    <div class="mb-4">
                        <label class="block font-medium">Pilih Kendaraan</label>

                        <select name="kendaraan_id" class="w-full border rounded p-2" required>
                            <option value="">-- Pilih Kendaraan --</option>

                            @foreach($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}">
                                    {{ $kendaraan->nama }}
                                    - {{ $kendaraan->merk }}
                                    (Rp {{ number_format($kendaraan->harga_sewa,0,',','.') }}/hari)
                                </option>
                            @endforeach
                        </select>

                        @error('kendaraan_id')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Tanggal Sewa</label>

                        <input
                            type="date"
                            name="tanggal_sewa"
                            class="w-full border rounded p-2"
                            value="{{ old('tanggal_sewa') }}"
                            required>

                        @error('tanggal_sewa')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Lama Sewa (Hari)</label>

                        <input
                            type="number"
                            name="lama_sewa"
                            min="1"
                            class="w-full border rounded p-2"
                            value="{{ old('lama_sewa') }}"
                            required>

                        @error('lama_sewa')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex gap-3">

                        <button
                            id="submitBtn"
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

                            Simpan

                        </button>

                        <a href="{{ route('user.penyewaan.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">

                            Kembali

                        </a>

                    </div>

                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const form = document.querySelector('form');
                        const btn = document.getElementById('submitBtn');
                        form.addEventListener('submit', function() {
                            btn.disabled = true;
                            btn.innerText = 'Memproses...';
                        });
                    });
                </script>

            </div>

        </div>
    </div>

</x-app-layout>