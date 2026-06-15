@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl border border-slate-300 shadow-sm overflow-hidden mt-8">
    <div class="p-6 sm:p-8 space-y-6">
        
        <div class="text-center">
            <h1 class="text-2xl font-bold text-zinc-950">Реєстрація акаунту</h1>
            <p class="text-zinc-950 text-sm mt-1 font-medium">Створіть профіль для замовлення ігор.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="space-y-1">
                <label class="text-sm font-bold text-zinc-950 block">Ваше ім'я</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                       class="w-full px-3.5 py-2 border border-slate-400 rounded-lg text-sm text-zinc-950 font-medium focus:outline-none focus:border-indigo-500 transition bg-white">
                @error('name') <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label class="text-sm font-bold text-zinc-950 block">Email адреса</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                       class="w-full px-3.5 py-2 border border-slate-400 rounded-lg text-sm text-zinc-950 font-medium focus:outline-none focus:border-indigo-500 transition bg-white">
                @error('email') <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label for="password" class="block text-sm font-bold text-zinc-950">Пароль</label>
                <input type="password" id="password" name="password" required 
                       class="w-full px-3.5 py-2 border border-slate-400 rounded-lg text-sm text-zinc-950 font-medium focus:outline-none focus:border-indigo-500 transition bg-white">
                @error('password') <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label for="password_confirmation" class="block text-sm font-bold text-zinc-950">Підтвердження пароля</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required 
                       class="w-full px-3.5 py-2 border border-slate-400 rounded-lg text-sm text-zinc-950 font-medium focus:outline-none focus:border-indigo-500 transition bg-white">
            </div>

            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-sm font-bold shadow-sm transition mt-4">Зареєструватися</button>
        </form>

        <p class="text-center text-sm text-zinc-950 font-medium">Вже маєте профіль? <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Увійти</a></p>

    </div>
</div>
@endsection