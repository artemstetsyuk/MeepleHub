@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-6">
    
    <a href="{{ route('games.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-zinc-400 hover:text-indigo-400 transition mb-6 group">
        <span>←</span> Повернутися до каталогу
    </a>

    <div class="bg-zinc-900/40 backdrop-blur-xl border border-zinc-800 rounded-3xl p-6 md:p-8 shadow-2xl grid grid-cols-1 md:grid-cols-2 gap-8 relative overflow-hidden">
        
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-zinc-700/10 rounded-full blur-3xl pointer-events-none"></div>

        <!-- Зображення -->
        <div class="relative rounded-2xl overflow-hidden bg-zinc-950 border border-zinc-800 aspect-square flex items-center justify-center z-10">
            @if($game->image)
                <img src="{{ asset('storage/' . $game->image) }}" class="w-full h-full object-cover">
            @else
                <span class="text-6xl">🎲</span>
            @endif
            
            <span class="absolute top-4 left-4 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-xl shadow-md">
                {{ $game->category->name ?? 'Загальна' }}
            </span>
        </div>

        <!-- Інформація -->
        <div class="flex flex-col justify-between py-2 z-10">
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight mb-4 leading-tight">
                    {{ $game->title }}
                </h1>

                <div class="flex gap-3 mb-6">
                    <div class="bg-zinc-800/40 border border-zinc-700/50 px-4 py-2 rounded-xl text-center min-w-[90px]">
                        <span class="block text-[9px] uppercase font-bold text-zinc-500 tracking-wider">Гравці</span>
                        <span class="font-black text-zinc-200 text-sm">{{ $game->min_players ?? 2 }}–{{ $game->max_players ?? 4 }}</span>
                    </div>
                    <div class="bg-zinc-800/40 border border-zinc-700/50 px-4 py-2 rounded-xl text-center min-w-[90px]">
                        <span class="block text-[9px] uppercase font-bold text-zinc-500 tracking-wider">Час партії</span>
                        <span class="font-black text-zinc-200 text-sm">{{ $game->duration ?? 60 }} хв</span>
                    </div>
                </div>

                <div class="text-zinc-300 text-sm leading-relaxed mb-6">
                    <h3 class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Про гру</h3>
                    <p class="whitespace-pre-line text-zinc-400">{{ $game->description }}</p>
                </div>
            </div>

            <div class="pt-5 border-t border-zinc-800/80 flex items-center justify-between gap-4">
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Вартість</span>
                    <span class="text-2xl font-black text-white tracking-tight">{{ number_format($game->price, 0, '.', ' ') }} ₴</span>
                </div>

                <form action="{{ route('cart.add', $game->id) }}" method="POST" class="m-0 flex-1 max-w-[200px]">
                    @csrf
                    <button type="submit" class="w-full py-3.5 bg-indigo-600 hover:bg-indigo-500 text-white font-black text-xs uppercase tracking-widest rounded-xl shadow-lg shadow-indigo-600/10 transition-all flex items-center justify-center gap-2">
                        <span>🛒</span> В кошик
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>  
@endsection