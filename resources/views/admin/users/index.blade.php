<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">{{ __('Data Pengguna') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h3 class="text-xl font-bold">Daftar Pengguna</h3>
                        <p class="text-sm text-zinc-500">Kelola akun admin dan user di sistem.</p>
                    </div>
                    <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-black rounded-xl hover:bg-amber-400 transition">
                        + Tambah Pengguna
                    </a>
                </div>

                <table class="w-full border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border p-2">No</th>
                            <th class="border p-2">Nama</th>
                            <th class="border p-2">Email</th>
                            <th class="border p-2">Role</th>
                            <th class="border p-2">Terdaftar</th>
                            <th class="border p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td class="border p-2 text-center">{{ $loop->iteration }}</td>
                                <td class="border p-2">{{ $user->name }}</td>
                                <td class="border p-2">{{ $user->email }}</td>
                                <td class="border p-2">{{ $user->role ?? '-' }}</td>
                                <td class="border p-2">{{ $user->created_at->format('Y-m-d') }}</td>
                                <td class="border p-2 text-center">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex px-3 py-1 rounded-xl bg-amber-500 text-black text-sm font-semibold hover:bg-amber-400">Edit</a>

                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus pengguna ini?')" class="inline-flex px-3 py-1 rounded-xl bg-red-600 text-white text-sm font-semibold hover:bg-red-500">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border p-4 text-center">Belum ada pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
