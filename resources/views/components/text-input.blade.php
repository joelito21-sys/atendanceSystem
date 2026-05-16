@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white/50 border-slate-200 focus:border-sky-500 focus:ring-sky-500 rounded-xl shadow-sm transition-all duration-300']) }}>

