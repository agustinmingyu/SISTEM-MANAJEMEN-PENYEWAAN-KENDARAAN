@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-zinc-900 border border-zinc-800 rounded-2xl shadow-lg">

        <div class="border-b border-zinc-800 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">
                Edit Pengguna
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

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3 focus:ring-amber-500 focus:border-amber-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3 focus:ring-amber-500 focus:border-amber-500"
                            required>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm mb-2 text-zinc-300">Password Baru</label>
                            <input type="password" name="password"
                                class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3 focus:ring-amber-500 focus:border-amber-500"
                                placeholder="Kosongkan jika tidak diubah">
                        </div>

                        <div>
                            <label class="block text-sm mb-2 text-zinc-300">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3 focus:ring-amber-500 focus:border-amber-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-zinc-300">Role</label>
                        <select name="role" class="w-full rounded-lg bg-zinc-800 border border-zinc-700 text-white px-4 py-3 focus:ring-amber-500 focus:border-amber-500" required>
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                </div>

                <div class="flex justify-between mt-8">
                    <a href="{{ route('admin.users.index') }}"
                       class="px-5 py-3 rounded-lg bg-zinc-700 hover:bg-zinc-600 text-white">
                        ← Kembali
                    </a>

                    <button type="submit"
                        class="px-6 py-3 rounded-lg bg-amber-500 hover:bg-amber-400 text-black font-semibold">
                        Perbarui Pengguna
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection