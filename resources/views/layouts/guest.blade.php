<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-zinc-100 antialiased bg-zinc-950 min-h-screen relative overflow-x-hidden selection:bg-amber-500 selection:text-black">
        <!-- Ambient Background Glows -->
        <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full bg-amber-500/10 blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] rounded-full bg-zinc-800/20 blur-[150px] pointer-events-none"></div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            <div class="transition-transform duration-300 hover:scale-105">
                <a href="/" class="flex flex-col items-center gap-2">
                    <!-- Dynamic Car SVG Icon in logo -->
                    <div class="p-3 bg-amber-500/10 border border-amber-500/30 rounded-2xl text-amber-500 shadow-[0_0_15px_rgba(245,158,11,0.2)]">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.317-5.072a3.375 3.375 0 0 0-3.355-3.167H7.525a3.375 3.375 0 0 0-3.355 3.167l-.317 5.072c-.039.62.469 1.124 1.09 1.124H5.25M16.5 13.5H7.5M16.5 13.5v-3.75m0 3.75h-.375a1.125 1.125 0 0 1-1.125-1.125v-1.5a1.125 1.125 0 0 1 1.125-1.125h.375M7.5 13.5H7.125A1.125 1.125 0 0 0 6 14.625v1.5c0 .621.504 1.125 1.125 1.125H7.5M7.5 13.5V9.75m0 0h.375c.621 0 1.129.504 1.09 1.124v1.5c-.039.62-.469 1.124-1.09 1.124H7.5m0-3.75h8.25m0 0H16.5m-9 0V7.5A2.25 2.25 0 0 1 9.75 5.25h4.5A2.25 2.25 0 0 1 16.5 7.5v2.25"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-amber-500">RentApp</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-zinc-900/80 border border-zinc-800 backdrop-blur-md shadow-2xl overflow-hidden sm:rounded-2xl relative">
                <!-- Top Accent Line -->
                <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-amber-500/20 via-amber-500 to-amber-500/20"></div>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
