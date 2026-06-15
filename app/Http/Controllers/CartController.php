<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class CartController extends Controller
{
    // Перегляд кошика
public function index()
{
    // Отримуємо кошик із сесії (якщо порожній — повертаємо порожній масив)
    $cart = session()->get('cart', []);
    
    // Рахуємо загальну вартість товарів у кошику
    $total = 0;
    foreach ($cart as $id => $item) {
        // Беремо ціну та кількість (захищаємо себе від помилок дефолтними значеннями 0 та 1)
        $price = $item['price'] ?? 0;
        $quantity = $item['quantity'] ?? $item['qty'] ?? 1;
        
        $total += $price * $quantity;
    }

    // ВАЖЛИВО: Передаємо і кошик, і пораховану суму $total у шаблон
    return view('cart.index', compact('cart', 'total'));
}

    // Додавання товару в кошик
    public function add($id)
    {
        $game = Game::findOrFail($id);
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "title" => $game->title,
                "quantity" => 1,
                "price" => $game->price,
                "image" => $game->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Гру успішно додано до кошика!');
    }

    // Видалення товару з кошика
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Товар видалено з кошика!');
    }

    // Оформлення замовлення
    public function checkout(Request $request)
    {
        // Очищення кошика після успіху
        session()->forget('cart');
        return redirect()->route('games.index')->with('success', 'Замовлення успішно оформлено!');
    }
}