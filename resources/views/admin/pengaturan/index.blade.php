@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-3xl font-bold text-white">Pengaturan</h1>
        <p class="text-zinc-400">Konfigurasi umum sistem penyewaan kendaraan.</p>
    </div>

    <div class="bg-zinc-900 rounded-2xl border border-zinc-800 p-6">
        <div class="flex flex-col items-center justify-center py-12 text-zinc-500">
            <svg class="w-12 h-12 mb-3 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            </svg>
            <p class="text-sm">Halaman pengaturan belum tersedia. Gunakan menu sidebar untuk berpindah halaman.</p>
        </div>
    </div>

</div>

@endsection