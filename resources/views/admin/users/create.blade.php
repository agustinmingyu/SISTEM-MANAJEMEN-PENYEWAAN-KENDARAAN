<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">{{ __('Tambah Pengguna') }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-zinc-700">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-xl border border-zinc-300 px-4 py-2" required>
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-zinc-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-xl border border-zinc-300 px-4 py-2" required>
                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-zinc-700">Password</label>
                        <input type="password" name="password" class="mt-1 block w-full rounded-xl border border-zinc-300 px-4 py-2" required>
                        @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-zinc-700">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-xl border border-zinc-300 px-4 py-2" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-zinc-700">Role</label>
                        <select name="role" class="mt-1 block w-full rounded-xl border border-zinc-300 px-4 py-2" required>
                            <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-between items-center gap-4">
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-zinc-900 text-white rounded-xl hover:bg-zinc-800">Batal</a>
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-amber-500 text-black rounded-xl hover:bg-amber-400">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
