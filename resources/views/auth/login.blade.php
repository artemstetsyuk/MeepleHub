@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white rounded-2xl border border-slate-300 shadow-sm overflow-hidden mt-8">
    <div class="p-6 sm:p-8 space-y-6">
        
        <div class="text-center">
            <h1 class="text-2xl font-bold text-zinc-950">Вхід у кабінет</h1>
            <p class="text-zinc-950 text-sm mt-1 font-medium">Авторизуйтесь для роботи з магазином.</p>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="space-y-1">
                <label class="text-sm font-bold text-zinc-950 block">Email адреса</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                       class="w-full px-3.5 py-2 border border-slate-400 rounded-lg text-sm text-zinc-950 font-medium focus:outline-none focus:border-indigo-500 transition bg-white">
                @error('email') <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1">
                <label class="text-sm font-bold text-zinc-950 block">Пароль</label>
                <input type="password" name="password" required 
                       class="w-full px-3.5 py-2 border border-slate-400 rounded-lg text-sm text-zinc-950 font-medium focus:outline-none focus:border-indigo-500 transition bg-white">
                @error('password') <p class="text-xs font-semibold text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-sm font-bold shadow-sm transition mt-4">Увійти</button>
        </form>

        <p class="text-center text-sm text-zinc-950 font-medium">Немає акаунту? <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline">Створити зараз</a></p>

    </div>
</div>
@endsection