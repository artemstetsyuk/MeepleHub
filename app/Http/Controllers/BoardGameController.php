<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class BoardGameController extends Controller
{
    // Головна сторінка: каталог + фільтр + пошук
    public function index(Request $request)
    {
        $query = Game::query();

        // Фільтрація за категорією
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Функціонал пошуку (за назвою або описом)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $games = $query->with('category')->get();
        $categories = Category::all();

        return view('games.index', compact('games', 'categories'));
    }

public function create()
{
    // Перевірка на адміна
    if (!auth()->check() || auth()->user()->role !== 'admin') {
        abort(403, 'Доступ заборонено.');
    }

    // 1. ОТРИМУЄМО КАТЕГОРІЇ (Переконайтеся, що модель Category імпортована!)
    $categories = \App\Models\Category::all();

    // 2. ПЕРЕДАЄМО КАТЕГОРІЇ У В'ЮШКУ (через compact)
    // Я використовую 'games.form', оскільки це найбільш поширений підхід для спільних форм.
    return view('games.form', compact('categories')); 
}

    // Збереження нової гри
    public function store(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Доступ заборонено.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'min_players' => 'required|integer|min:1',
            'max_players' => 'required|integer|gte:min_players',
            'duration' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', 
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('games', 'public');
            $validated['image'] = $path;
        }

        Game::create($validated);

        return redirect()->route('games.index')->with('success', 'Нову гру успішно додано до каталогу!');
    }

    // Сторінка редагування
    public function edit($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Доступ заборонено. Ви не адміністратор.');
        }

        $game = Game::findOrFail($id);
        $categories = Category::all();
        
        // ВАЖЛИВО: Переконайся, що твій шаблон називається edit.blade.php (або form.blade.php, якщо він спільний)
        return view('games.edit', compact('game', 'categories'));
    }

    // Оновлення інформації про гру
    public function update(Request $request, $id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Доступ заборонено.');
        }

        $game = Game::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'min_players' => 'required|integer|min:1',
            'max_players' => 'required|integer|gte:min_players',
            'duration' => 'required|integer|min:1',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($game->image && Storage::disk('public')->exists($game->image)) {
                Storage::disk('public')->delete($game->image);
            }
            
            $path = $request->file('image')->store('games', 'public');
            $validated['image'] = $path;
        }

        $game->update($validated);

        return redirect()->route('games.index')->with('success', 'Дані про гру успішно оновлено!');
    }

    // Видалення гри
    public function destroy($id)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Доступ заборонено.');
        }

        $game = Game::findOrFail($id);

        if ($game->image && Storage::disk('public')->exists($game->image)) {
            Storage::disk('public')->delete($game->image);
        }

        $game->delete();

        return redirect()->route('games.index')->with('success', 'Гру успішно видалено з каталогу.');
    }

    // Детальна сторінка однієї гри
    public function show($id)
    {
        $game = Game::with('category')->findOrFail($id);
        return view('games.show', compact('game'));
    }
}