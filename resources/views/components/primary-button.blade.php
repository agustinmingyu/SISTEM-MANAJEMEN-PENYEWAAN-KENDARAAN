<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 border border-transparent rounded-xl font-bold text-sm text-black uppercase tracking-wider hover:from-amber-400 hover:to-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 focus:ring-offset-zinc-900 active:scale-[0.98] transition-all duration-150 shadow-[0_4px_20px_rgba(245,158,11,0.2)] cursor-pointer']) }}>
    {{ $slot }}
</button>
