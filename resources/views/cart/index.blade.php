@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-black text-slate-900 mb-8 tracking-tight">Ваш кошик</h1>

    @if(empty($cart))
        <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center shadow-sm max-w-xl mx-auto">
            <span class="text-4xl">🛒</span>
            <h3 class="text-lg font-bold text-slate-800 mt-3">Кошик порожній</h3>
            <p class="text-slate-500 text-sm mt-1">Перейдіть до каталогу, щоб вибрати найкращі настільні ігри.</p>
            <a href="{{ route('games.index') }}" class="mt-6 inline-block px-5 py-2.5 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-500 transition">До каталогу</a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Список товарів -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $id => $item)
                    <div class="bg-white border border-slate-100 rounded-2xl p-4 flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-20 h-20 bg-slate-50 rounded-xl overflow-hidden flex-shrink-0 border border-slate-100">
                                @if($item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-xl">🎲</div>
                                @endif
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-lg leading-snug">{{ $item['title'] }}</h3>
                                <p class="text-slate-400 text-sm mt-0.5">{{ number_format($item['price'], 0, '.', ' ') }} ₴ × {{ $item['quantity'] }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-6">
                            <span class="font-black text-slate-900 text-lg">{{ number_format($item['price'] * $item['quantity'], 0, '.', ' ') }} ₴</span>
                            
                            <!-- Кнопка видалення -->
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-slate-300 hover:text-rose-600 transition p-1 text-sm">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Лаконічна форма оформлення замовлення -->
            <div class="bg-white border border-slate-100 rounded-3xl p-6 shadow-sm h-fit">
                <h2 class="text-xl font-black text-slate-800 mb-4">Оформлення</h2>
                
                <div class="flex justify-between items-center pb-4 mb-6 border-b border-slate-100">
                    <span class="text-slate-500 font-medium">Разом до сплати:</span>
                    <span class="text-2xl font-black text-indigo-600 tracking-tight">{{ number_format($total, 0, '.', ' ') }} ₴</span>
                </div>

                <form action="{{ route('checkout.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-950 uppercase tracking-wider mb-1">Ім'я</label>
                        <input type="text" name='first_name' value="{{ old('first_name') }}" required
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                        @error('first_name') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-950 uppercase tracking-wider mb-1">Прізвище</label>
                        <input type="text" name='last_name' value="{{ old('last_name') }}" required
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                        @error('last_name') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-950 uppercase tracking-wider mb-1">Номер телефону</label>
                        <input type="text" name='phone' value="{{ old('phone') }}" placeholder="+380" required
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl font-medium text-slate-800 text-sm focus:outline-none focus:border-indigo-500 focus:bg-white transition">
                        @error('phone') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full mt-2 py-3.5 bg-slate-900 text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-indigo-600 shadow-md hover:shadow-indigo-600/10 transition-all duration-300">
                        Підтвердити замовлення
                    </button>
                </form>
            </div>

        </div>
    @endif
</div>
@endsection