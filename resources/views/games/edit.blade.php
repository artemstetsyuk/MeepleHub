@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-zinc-900/40 backdrop-blur-xl p-6 md:p-8 rounded-3xl border border-zinc-800 shadow-xl">
    <h1 class="text-xl font-black text-white mb-6 pb-3 border-b border-zinc-800">
        {{ isset($game) ? 'Редагування гри: ' . $game->title : 'Додавання нової гри' }}
    </h1>

    @if ($errors->any())
        <div class="mb-5 p-4 bg-rose-950/40 border border-rose-900/50 text-rose-400 rounded-xl font-medium text-xs">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ isset($game) ? route('games.update', $game->id) : route('games.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @if(isset($game))
            @method('PUT')
        @endif

        <div>
            <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1.5">Назва гри</label>
            <input type="text" name="title" value="{{ old('title', $game->title ?? '') }}" required 
                   class="w-full bg-zinc-950/50 border border-zinc-800 text-white px-3 py-2.5 rounded-xl focus:outline-none focus:border-indigo-500 text-sm transition">
        </div>

        <div class="p-4 bg-zinc-950/30 border border-zinc-800 rounded-xl">
            <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1.5">Обкладинка гри (зображення)</label>
            <input type="file" name="image" accept="image/*" class="block w-full text-xs text-zinc-400 file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-zinc-800 file:text-zinc-200 hover:file:bg-zinc-700 file:cursor-pointer">
            
            @if(isset($game) && $game->image)
                <div class="mt-3 flex items-center gap-3">
                    <span class="text-xs text-zinc-500">Поточна:</span>
                    <img src="{{ asset('storage/' . $game->image) }}" class="w-12 h-12 object-cover rounded-lg border border-zinc-800">
                </div>
            @endif
        </div>

        <div>
            <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1.5">Категорія</label>
            <select name="category_id" required class="w-full bg-zinc-950/50 border border-zinc-800 text-zinc-300 px-3 py-2.5 rounded-xl focus:outline-none focus:border-indigo-500 text-sm transition">
                <option value="" disabled {{ !old('category_id', $game->category_id ?? '') ? 'selected' : '' }}>Оберіть категорію...</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $game->category_id ?? '') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1.5">Опис гри</label>
            <textarea name="description" rows="4" required 
                      class="w-full bg-zinc-950/50 border border-zinc-800 text-white px-3 py-2.5 rounded-xl focus:outline-none focus:border-indigo-500 text-sm transition leading-relaxed">{{ old('description', $game->description ?? '') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1.5">Ціна (грн)</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $game->price ?? '') }}" required 
                       class="w-full bg-zinc-950/50 border border-zinc-800 text-white px-3 py-2.5 rounded-xl focus:outline-none focus:border-indigo-500 text-sm transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-zinc-400 uppercase tracking-wider mb-1.5">На складі (шт)</label>
                <input type="number" name="stock" value="{{ old('stock', $game->stock ?? '') }}" required 
                       class="w-full bg-zinc-950/50 border border-zinc-800 text-white px-3 py-2.5 rounded-xl focus:outline-none focus:border-indigo-500 text-sm transition">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-3 p-3 bg-zinc-950/20 border border-zinc-800 rounded-xl">
            <div>
                <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Мін. гравців</label>
                <input type="number" name="min_players" value="{{ old('min_players', $game->min_players ?? '') }}" required 
                       class="w-full bg-zinc-950/50 border border-zinc-800 text-white px-2 py-1.5 rounded-lg text-xs focus:outline-none focus:border-indigo-500 text-center">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Макс. гравців</label>
                <input type="number" name="max_players" value="{{ old('max_players', $game->max_players ?? '') }}" required 
                       class="w-full bg-zinc-950/50 border border-zinc-800 text-white px-2 py-1.5 rounded-lg text-xs focus:outline-none focus:border-indigo-500 text-center">
            </div>
            <div>
                <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Час гри (хв)</label>
                <input type="number" name="duration" value="{{ old('duration', $game->duration ?? '') }}" required 
                       class="w-full bg-zinc-950/50 border border-zinc-800 text-white px-2 py-1.5 rounded-lg text-xs focus:outline-none focus:border-indigo-500 text-center">
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-zinc-800 mt-6 text-xs">
            <a href="{{ route('games.index') }}" class="px-4 py-2.5 border border-zinc-700 text-zinc-400 rounded-xl font-bold hover:bg-zinc-800 hover:text-white transition">Скасувати</a>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-xl shadow-lg shadow-indigo-600/10 transition">
                {{ isset($game) ? 'Зберегти зміни' : 'Додати гру' }}
            </button>
        </div>
    </form>
</div>
@endsection