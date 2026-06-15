@extends('layouts.app')

@section('content')
<div class="relative w-full">

    <div class="absolute -top-10 left-0 w-72 h-72 bg-zinc-700/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute top-40 right-0 w-80 h-80 bg-zinc-600/10 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="relative z-10 w-full">

        <div class="w-full relative bg-gradient-to-br from-zinc-950 via-zinc-900 to-zinc-950 rounded-3xl p-8 md:p-12 mb-10 overflow-hidden shadow-2xl border border-zinc-800">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-zinc-700/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-indigo-600/5 rounded-full blur-3xl"></div>

            <div class="relative z-10 max-w-2xl">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-[10px] font-black bg-zinc-800 text-zinc-300 rounded-lg border border-zinc-700 mb-4 uppercase tracking-widest">
                    🎲 Твій ігровий простір
                </span>
                <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-4 leading-tight">
                    Відкрий світ <span class="text-transparent bg-clip-text bg-gradient-to-r from-zinc-100 to-zinc-400">найкращих настілок</span>
                </h1>
                <p class="text-zinc-400 text-sm md:text-base leading-relaxed">
                    Обери свій наступний хіт для вечірки, затишного сімейного вечора або хардкорної стратегічної битви.
                </p>

                <form action="{{ route('games.index') }}" method="GET" class="mt-6 max-w-md flex gap-2">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-zinc-500 text-sm">🔍</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Пошук настільних ігор..." 
                               class="w-full bg-zinc-950/80 border border-zinc-700 text-white placeholder-zinc-400 pl-10 pr-4 py-2.5 rounded-xl focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm transition">
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-600/20 transition">
                        Знайти
                    </button>
                    @if(request('search'))
                        <a href="{{ route('games.index', request()->except('search')) }}" class="bg-zinc-800 hover:bg-zinc-700 text-zinc-300 border border-zinc-700 font-bold text-xs px-3 py-2.5 rounded-xl flex items-center transition">
                            ✖
                        </a>
                    @endif
                </form>
            </div>
        </div>

        <div class="w-full flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 pb-5 border-b border-zinc-800">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('games.index', request()->only('search')) }}"
                   class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 {{ !request('category') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'bg-zinc-900 text-zinc-300 border border-zinc-800 hover:bg-zinc-700' }}">
                    Всі ігри
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('games.index', array_merge(request()->only('search'), ['category' => $cat->id])) }}"
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-200 {{ request('category') == $cat->id ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'bg-zinc-900 text-zinc-300 border border-zinc-800 hover:bg-zinc-700' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('games.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white text-zinc-900 font-bold text-xs hover:bg-indigo-500 hover:text-white transition shadow-sm">
                        <span>+</span> Додати нову гру
                    </a>
                @endif
            @endauth
        </div>

        @if($games->isEmpty())
            <div class="bg-zinc-900/40 backdrop-blur-xl border border-zinc-800 rounded-3xl p-12 text-center max-w-xl mx-auto shadow-xl">
                <span class="text-4xl">📦</span>
                <h3 class="text-sm font-bold text-zinc-400 mt-4">Нічого не знайдено за вашим запитом</h3>
                <a href="{{ route('games.index') }}" class="text-xs text-indigo-400 hover:underline mt-2 inline-block">Скинути всі фільтри та пошук</a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($games as $game)
                    <div class="group rounded-2xl overflow-hidden border border-zinc-800 bg-zinc-900/40 backdrop-blur-sm shadow-xl hover:border-zinc-700 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="relative overflow-hidden aspect-[4/3] bg-zinc-950">
                                @if($game->image)
                                    <img src="{{ asset('storage/' . $game->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-zinc-700 text-4xl">🎲</div>
                                @endif
                                <span class="absolute top-3 left-3 bg-zinc-950/90 backdrop-blur-md text-zinc-300 text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded-md border border-zinc-800">
                                    {{ $game->category->name ?? 'Загальна' }}
                                </span>
                            </div>

                            <div class="p-5">
                                @auth
                                    @if(auth()->user()->role === 'admin')
                                        <div class="flex gap-2 mb-3">
                                            <a href="{{ route('games.edit', $game->id) }}" class="text-[9px] font-bold px-2 py-1 rounded bg-zinc-800 text-zinc-300 hover:bg-zinc-700 border border-zinc-700/50">✏️ Редагувати</a>
                                            <form action="{{ route('games.destroy', $game->id) }}" method="POST" class="m-0" onsubmit="return confirm('Видалити гру?')">
                                                @csrf @method('DELETE')
                                                <button class="text-[9px] font-bold px-2 py-1 rounded bg-rose-950/40 text-rose-400 hover:bg-rose-900/60 border border-rose-900/30">🗑️</button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth

                                <h3 class="font-black text-white text-base mb-1.5 group-hover:text-indigo-400 transition line-clamp-1">
                                    {{ $game->title }}
                                </h3>
                                <p class="text-zinc-400 text-xs line-clamp-2 leading-relaxed">
                                    {{ $game->description }}
                                </p>
                            </div>
                        </div>

                        <div class="p-5 pt-0">
                            <div class="flex justify-between items-center border-t border-zinc-800/80 pt-4">
                                <div>
                                    <div class="text-[9px] font-bold uppercase tracking-wider text-zinc-500">Ціна</div>
                                    <div class="text-xl font-black text-white tracking-tight">{{ number_format($game->price, 0, '.', ' ') }} ₴</div>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('cart.add', $game->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="p-2 rounded-xl bg-zinc-800 hover:bg-indigo-600 border border-zinc-700 hover:text-white text-zinc-300 transition text-sm cursor-pointer">🛒</button>
                                    </form>
                                    <a href="{{ route('games.show', $game->id) }}" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-[10px] font-black uppercase tracking-wider flex items-center">Детальніше</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection