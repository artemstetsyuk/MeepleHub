@extends('layouts.app')

@section('content')
<div class="relative w-full min-h-screen">

    <div class="absolute -top-10 left-0 w-72 h-72 bg-zinc-700/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute top-40 right-0 w-80 h-80 bg-zinc-600/10 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="relative z-10 w-full max-w-2xl mx-auto py-10 px-4">
        
        <div class="bg-zinc-900/40 backdrop-blur-xl p-8 rounded-3xl border border-zinc-800 shadow-2xl">
            
            <h1 class="text-2xl font-black text-white mb-8 pb-3 border-b border-zinc-800">
                Додавання нової гри
            </h1>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-950/40 border border-rose-900/50 text-rose-400 rounded-xl font-medium text-xs">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('games.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1.5">Назва гри</label>
                    <input type="text" name="title" value="{{ old('title') }}" required 
                           class="w-full bg-zinc-950/50 border border-zinc-800 text-white placeholder-zinc-500 px-4 py-3 rounded-xl focus:outline-none focus:border-indigo-500 text-sm transition-all shadow-inner">
                </div>

                <div class="p-4 bg-zinc-950/30 border border-zinc-800 rounded-xl shadow-inner">
                    <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1.5">Обкладинка гри (зображення)</label>
                    <input type="file" name="image" accept="image/*" class="block w-full text-xs text-zinc-400 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-zinc-800 file:text-zinc-200 hover:file:bg-zinc-700 file:cursor-pointer transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1.5">Категорія</label>
                    <select name="category_id" required 
                            class="w-full bg-zinc-950/50 border border-zinc-800 text-zinc-300 px-4 py-3 rounded-xl focus:outline-none focus:border-indigo-500 text-sm transition-all shadow-inner cursor-pointer appearance-none">
                        <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Оберіть категорію...</option>
                        
                        @forelse($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @empty
                            <option value="" disabled class="text-rose-400">Категорії не знайдені в базі даних</option>
                        @endforelse
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1.5">Опис гри</label>
                    <textarea name="description" rows="5" required 
                              class="w-full bg-zinc-950/50 border border-zinc-800 text-white placeholder-zinc-500 px-4 py-3 rounded-xl focus:outline-none focus:border-indigo-500 text-sm transition-all leading-relaxed shadow-inner">{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1.5">Ціна (грн)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price') }}" required 
                               class="w-full bg-zinc-950/50 border border-zinc-800 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-indigo-500 text-sm transition-all shadow-inner">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1.5">На складі (шт)</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" required 
                               class="w-full bg-zinc-950/50 border border-zinc-800 text-white px-4 py-3 rounded-xl focus:outline-none focus:border-indigo-500 text-sm transition-all shadow-inner">
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-3 p-4 bg-zinc-950/20 border border-zinc-800 rounded-xl shadow-inner">
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Мін. гравців</label>
                        <input type="number" name="min_players" value="{{ old('min_players') }}" required 
                               class="w-full bg-zinc-950/50 border border-zinc-800 text-white px-3 py-2 rounded-lg text-xs focus:outline-none focus:border-indigo-500 text-center transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Макс. гравців</label>
                        <input type="number" name="max_players" value="{{ old('max_players') }}" required 
                               class="w-full bg-zinc-950/50 border border-zinc-800 text-white px-3 py-2 rounded-lg text-xs focus:outline-none focus:border-indigo-500 text-center transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Час гри (хв)</label>
                        <input type="number" name="duration" value="{{ old('duration') }}" required 
                               class="w-full bg-zinc-950/50 border border-zinc-800 text-white px-3 py-2 rounded-lg text-xs focus:outline-none focus:border-indigo-500 text-center transition">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-5 border-t border-zinc-800/80 mt-8 text-xs">
                    <a href="{{ route('games.index') }}" class="px-5 py-3 border border-zinc-700 text-zinc-400 rounded-xl font-bold hover:bg-zinc-800 hover:text-white transition">
                        Скасувати
                    </a>
                    <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-xl shadow-lg shadow-indigo-600/10 transition-all">
                        Додати гру
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection