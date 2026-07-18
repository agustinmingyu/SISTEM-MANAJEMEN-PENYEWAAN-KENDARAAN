<nav x-data="{ open: false }" class="bg-zinc-950 border-b border-zinc-900 sticky top-0 z-50 backdrop-blur-md bg-opacity-95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="flex items-center gap-2 group">
                        <div class="p-1.5 bg-amber-500/10 border border-amber-500/30 rounded-lg text-amber-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124l-.317-5.072a3.375 3.375 0 0 0-3.355-3.167H7.525a3.375 3.375 0 0 0-3.355 3.167l-.317 5.072c-.039.62.469 1.124 1.09 1.124H5.25M16.5 13.5H7.5M16.5 13.5v-3.75m0 3.75h-.375a1.125 1.125 0 0 1-1.125-1.125v-1.5a1.125 1.125 0 0 1 1.125-1.125h.375M7.5 13.5H7.125A1.125 1.125 0 0 0 6 14.625v1.5c0 .621.504 1.125 1.125 1.125H7.5M7.5 13.5V9.75m0 0h.375c.621 0 1.129.504 1.09 1.124v1.5c-.039.62-.469 1.124-1.09 1.124H7.5m0-3.75h8.25m0 0H16.5m-9 0V7.5A2.25 2.25 0 0 1 9.75 5.25h4.5A2.25 2.25 0 0 1 16.5 7.5v2.25"></path>
                            </svg>
                        </div>
                        <span class="text-base font-bold tracking-tight text-white group-hover:text-amber-500 transition-colors">RentApp</span>
                    </a>
                </div>

                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->role === 'admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('Data Pengguna') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.kendaraan.index')" :active="request()->routeIs('admin.kendaraan.*')">
                            {{ __('Kendaraan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.penyewaan.index')" :active="request()->routeIs('admin.penyewaan.*')">
                            {{ __('Penyewaan') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.pembayaran.index')" :active="request()->routeIs('admin.pembayaran.*')">
                            {{ __('Pembayaran') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.riwayat-pembayaran.index')" :active="request()->routeIs('admin.riwayat-pembayaran.*')">
                            {{ __('Riwayat Pembayaran') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.*')">
                            {{ __('Laporan') }}
                        </x-nav-link>

                    @else
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>

    <x-nav-link :href="route('user.penyewaan.index')" :active="request()->routeIs('user.penyewaan.*')">
        {{ __('Penyewaan Kendaraan') }}
    </x-nav-link>
@endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-zinc-800 text-sm leading-4 font-medium rounded-xl text-zinc-300 bg-zinc-900 hover:text-white hover:bg-zinc-800/80 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-zinc-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-zinc-900 border border-zinc-800 rounded-lg shadow-xl overflow-hidden">
                            <x-dropdown-link :href="route('profile.edit')" class="text-zinc-300 hover:bg-zinc-800 hover:text-white">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        class="text-red-400 hover:bg-zinc-800 hover:text-red-300"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-zinc-400 hover:text-white hover:bg-zinc-900 focus:outline-none focus:bg-zinc-900 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-zinc-950 border-t border-zinc-900">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    {{ __('Data Pengguna') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.kendaraan.index')" :active="request()->routeIs('admin.kendaraan.*')">
                    {{ __('Kendaraan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.penyewaan.index')" :active="request()->routeIs('admin.penyewaan.*')">
                    {{ __('Penyewaan') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.pembayaran.index')" :active="request()->routeIs('admin.pembayaran.*')">
                    {{ __('Pembayaran') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.riwayat-pembayaran.index')" :active="request()->routeIs('admin.riwayat-pembayaran.*')">
                    {{ __('Riwayat Pembayaran') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.*')">
                    {{ __('Laporan') }}
                </x-responsive-nav-link>
            
            @else
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
    </x-nav-link>

    <x-nav-link :href="route('user.penyewaan.index')" :active="request()->routeIs('user.penyewaan.*')">
        {{ __('Penyewaan Kendaraan') }}
    </x-nav-link>
@endif
        </div>

        <div class="pt-4 pb-1 border-t border-zinc-900">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-zinc-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-zinc-400 hover:text-white">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            class="text-red-400 hover:text-red-300"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>