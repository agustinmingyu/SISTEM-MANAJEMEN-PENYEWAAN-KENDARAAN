<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Notifikasi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded bg-green-500 text-white p-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">

                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-xl font-bold">Semua Notifikasi</h3>

                    @if($notifications->where('read_at', null)->count() > 0)
                        <form method="POST" action="{{ route('notifications.readAll') }}">
                            @csrf
                            <button class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded text-sm">
                                Tandai semua dibaca
                            </button>
                        </form>
                    @endif
                </div>

                <div class="divide-y divide-gray-200">
                    @forelse($notifications as $notification)
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}"
                              class="w-full">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-2 py-4 flex items-start justify-between gap-4 hover:bg-gray-50 {{ $notification->read_at ? 'opacity-60' : '' }}">
                                <div>
                                    <p class="text-sm text-gray-800">
                                        {{ $notification->data['message'] ?? 'Notifikasi' }}
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ $notification->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>

                                @if(!$notification->read_at)
                                    <span class="shrink-0 bg-amber-500 text-white text-xs px-2 py-1 rounded-full">Baru</span>
                                @endif
                            </button>
                        </form>
                    @empty
                        <p class="text-center text-gray-500 py-8">Belum ada notifikasi.</p>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $notifications->links() }}
                </div>

            </div>
        </div>
    </div>

</x-app-layout>