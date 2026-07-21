<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Penyewaan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <form action="{{ route('user.penyewaan.update', $penyewaan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block font-medium">Pilih Kendaraan</label>

                        <select name="kendaraan_id" class="w-full border rounded p-2" required>
                            @foreach($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}" {{ $kendaraan->id == $penyewaan->kendaraan_id ? 'selected' : '' }}>
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
                            value="{{ old('tanggal_sewa', $penyewaan->tanggal_sewa) }}"
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
                            value="{{ old('lama_sewa', $penyewaan->lama_sewa) }}"
                            required>

                        @error('lama_sewa')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex gap-3">

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Simpan Perubahan
                        </button>

                        <a href="{{ route('user.penyewaan.index') }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            Kembali
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>