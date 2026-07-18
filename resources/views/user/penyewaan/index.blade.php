<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Penyewaan Kendaraan Saya') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded bg-green-500 text-white p-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex justify-between items-center mb-5">

                    <h3 class="text-xl font-bold">
                        Data Penyewaan
                    </h3>

                    <a href="{{ route('user.penyewaan.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">

                        + Tambah Penyewaan

                    </a>

                </div>

                <table class="w-full border border-gray-300">

                    <thead class="bg-gray-200">

                        <tr>

                            <th class="border p-2">No</th>
                            <th class="border p-2">Kendaraan</th>
                            <th class="border p-2">Tanggal</th>
                            <th class="border p-2">Lama</th>
                            <th class="border p-2">Total</th>
                            <th class="border p-2">Status</th>
                            <th class="border p-2">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($penyewaans as $penyewaan)

                        <tr>

                            <td class="border p-2 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border p-2">
                                {{ $penyewaan->kendaraan->nama }}
                            </td>

                            <td class="border p-2">
                                {{ $penyewaan->tanggal_sewa }}
                            </td>

                            <td class="border p-2">
                                {{ $penyewaan->lama_sewa }} Hari
                            </td>

                            <td class="border p-2">
                                Rp {{ number_format($penyewaan->total_harga,0,',','.') }}
                            </td>

                            <td class="border p-2">
                                {{ $penyewaan->status }}
                            </td>

                            <td class="border p-2 text-center">

                                <a href="{{ route('user.penyewaan.show',$penyewaan->id) }}"
                                   class="bg-green-600 text-white px-2 py-1 rounded">

                                    Detail

                                </a>

                                <a href="{{ route('user.penyewaan.edit',$penyewaan->id) }}"
                                   class="bg-yellow-500 text-white px-2 py-1 rounded">

                                    Edit

                                </a>

                                <form
                                    action="{{ route('user.penyewaan.destroy',$penyewaan->id) }}"
                                    method="POST"
                                    class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Yakin ingin menghapus?')"
                                        class="bg-red-600 text-white px-2 py-1 rounded">

                                        Hapus

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="border p-4 text-center">

                                Belum ada penyewaan.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</x-app-layout>