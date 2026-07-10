@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-zinc-800 bg-zinc-950/80 text-zinc-100 placeholder-zinc-600 focus:border-amber-500 focus:ring-amber-500 rounded-xl shadow-sm transition-all duration-200']) }}>
