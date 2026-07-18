@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Daftar Penyewaan</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <form method="GET" class="mb-4 flex gap-2 items-center">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari user atau kendaraan" class="border rounded p-2" />
        <select name="status" class="border rounded p-2">
            <option value="">-- Semua status --</option>
            <option value="Pending" {{ request('status')=='Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Disetujui" {{ request('status')=='Disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="Dibatalkan" {{ request('status')=='Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            <option value="Selesai" {{ request('status')=='Selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        <button class="bg-amber-500 text-black px-3 py-2 rounded">Filter</button>
        <a href="?{{ http_build_query(array_merge(request()->all(), ['export'=>'csv'])) }}" class="ml-2 text-sm text-blue-600">Export CSV</a>
    </form>

    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">User</th>
                <th class="px-4 py-2">Kendaraan</th>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Lama</th>
                <th class="px-4 py-2">Total</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penyewaans as $p)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $p->id }}</td>
                    <td class="px-4 py-2">{{ $p->user->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $p->kendaraan->nama ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $p->tanggal_sewa }}</td>
                    <td class="px-4 py-2">{{ $p->lama_sewa }} hari</td>
                    <td class="px-4 py-2">Rp {{ number_format($p->total_harga,0,',','.') }}</td>
                    <td class="px-4 py-2">{{ $p->status }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.penyewaan.show', $p) }}" class="text-blue-600 mr-2">Lihat</a>
                        <form action="{{ route('admin.penyewaan.destroy', $p) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus penyewaan?')" class="text-red-600">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-4 text-center">Belum ada penyewaan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $penyewaans->links() }}
    </div>
</div>
@endsection
<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Data Penyewaan') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">

                <h3 class="text-xl font-bold mb-4">Daftar Penyewaan</h3>

                <table class="w-full border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border p-2">No</th>
                            <th class="border p-2">Pengguna</th>
                            <th class="border p-2">Kendaraan</th>
                            <th class="border p-2">Tanggal</th>
                            <th class="border p-2">Lama</th>
                            <th class="border p-2">Total</th>
                            <th class="border p-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penyewaans as $penyewaan)
                            <tr>
                                <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                                <td class="border p-2">{{ $penyewaan->user->name ?? '-' }}</td>
                                <td class="border p-2">{{ $penyewaan->kendaraan->nama ?? '-' }}</td>
                                <td class="border p-2">{{ $penyewaan->tanggal_sewa }}</td>
                                <td class="border p-2">{{ $penyewaan->lama_sewa }} Hari</td>
                                <td class="border p-2">Rp {{ number_format($penyewaan->total_harga,0,',','.') }}</td>
                                <td class="border p-2">{{ $penyewaan->status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="border p-4 text-center">Belum ada penyewaan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </div>
    </div>

</x-app-layout>
