@extends('layouts.admin')

@section('title', 'Data Pengguna')

@section('content')

<div class="space-y-6">

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-white">
                Data Pengguna
            </h1>
            <p class="text-zinc-400">
                Kelola akun admin dan user di sistem.
            </p>
        </div>

        <a href="{{ route('admin.users.create') }}"
            class="bg-amber-500 hover:bg-amber-600 text-black font-semibold px-5 py-3 rounded-xl transition">
            + Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500 text-green-300 p-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500/20 border border-red-500 text-red-300 p-4 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-zinc-900 rounded-2xl border border-zinc-800 overflow-hidden">

        <table class="w-full">

            <thead class="bg-zinc-800 text-zinc-300">
                <tr>
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">Role</th>
                    <th class="p-4 text-left">Terdaftar</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-zinc-800">
                @forelse($users as $user)
                    <tr class="hover:bg-zinc-800 transition">
                        <td class="p-4 text-zinc-300">{{ $loop->iteration }}</td>
                        <td class="p-4 font-semibold text-white">{{ $user->name }}</td>
                        <td class="p-4 text-zinc-300">{{ $user->email }}</td>
                        <td class="p-4">
                            @if($user->role === 'admin')
                                <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-400 text-sm">Admin</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-blue-500/20 text-blue-400 text-sm">User</span>
                            @endif
                        </td>
                        <td class="p-4 text-zinc-300">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="p-4 text-center">
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg">
                                Edit
                            </a>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus pengguna ini?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-12 text-zinc-500">
                            Belum ada pengguna.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection