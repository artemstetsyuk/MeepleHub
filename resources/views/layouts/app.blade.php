<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MeepleHub — Магазин настільних ігор</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-zinc-900 via-zinc-800 to-zinc-950 text-zinc-300 min-h-screen flex flex-col selection:bg-indigo-500 selection:text-white bg-fixed bg-no-repeat">

    <nav class="bg-zinc-950/80 backdrop-blur-md text-white shadow-lg sticky top-0 z-50 border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                
                <div class="flex items-center gap-8">
                    <a href="{{ route('games.index') }}" class="text-xl font-black tracking-tight text-indigo-400 flex items-center gap-2 hover:text-indigo-300 transition">
                        <span>🎲</span> <span>MeepleHub</span>
                    </a>
                    <div class="hidden md:flex items-center gap-6 text-sm font-semibold text-zinc-400">
                        <a href="{{ route('games.index') }}" class="hover:text-white transition">Каталог ігор</a>
                        @auth
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ route('games.create') }}" class="text-indigo-400 hover:text-indigo-300 transition font-bold">+ Додати гру</a>
                            @endif
                        @endauth
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('cart.index') }}" class="relative flex items-center gap-2 px-3.5 py-2 bg-zinc-900 border border-zinc-800 hover:bg-zinc-800 text-zinc-200 rounded-xl transition font-bold text-xs group shadow-inner">
                        <span class="text-sm group-hover:scale-110 transition">🛒</span>
                        <span class="hidden sm:inline">Кошик</span>

                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-rose-600 text-white text-[10px] font-black px-1.5 py-0.5 rounded-full min-w-[18px] text-center shadow-md animate-pulse">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>

                    @auth
                        <div class="flex items-center gap-4 text-sm">
                            <span class="text-zinc-400 hidden lg:inline">Вітаємо, <strong class="text-zinc-200">{{ auth()->user()->name }}</strong> <span class="text-[10px] bg-zinc-800 text-indigo-400 px-2 py-0.5 rounded-md uppercase font-black border border-zinc-700/50 ml-1">{{ auth()->user()->role }}</span></span>
                            <form action="{{ route('logout') }}" method="POST" class="inline m-0">
                                @csrf
                                <button type="submit" class="text-xs bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white px-3 py-2 rounded-xl font-bold transition">Вийти</button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-3 text-sm font-bold">
                            <a href="{{ route('login') }}" class="text-zinc-400 hover:text-white transition px-2 py-2">Вхід</a>
                            <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-xl transition shadow-lg shadow-indigo-600/20">Реєстрація</a>
                        </div>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 w-full">
            <div class="bg-zinc-950/60 backdrop-blur-xl border border-emerald-500/30 text-emerald-400 p-4 rounded-2xl shadow-xl flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="text-xl">✨</span>
                    <p class="font-bold text-sm">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-10 max-w-7xl flex-grow">
        @yield('content')
    </main>

    <footer class="bg-zinc-950/60 backdrop-blur-md text-zinc-500 border-t border-zinc-800/60 mt-auto">
        <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-3 gap-8 text-sm">
            <div>
                <h4 class="text-white font-black text-base mb-3 flex items-center gap-2">🎲 MeepleHub</h4>
                <p class="text-zinc-400 leading-relaxed text-xs">Твій простір найкращих настільних ігор. Знаходимо світові хіти та затишну класику для незабутніх вечорів.</p>
            </div>
            <div>
                <h4 class="text-zinc-200 font-bold mb-3 text-xs uppercase tracking-wider">Навігація</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('games.index') }}" class="hover:text-indigo-400 transition">Каталог товарів</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition">Правила доставки</a></li>
                    <li><a href="#" class="hover:text-indigo-400 transition">Про нас</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-zinc-200 font-bold mb-3 text-xs uppercase tracking-wider">Контакти</h4>
                <p class="text-xs text-zinc-400 leading-relaxed">📍 м. Київ, вул. Настільна, 12<br>📞 +38 (099) 123-45-67</p>
            </div>
        </div>
        <div class="border-t border-zinc-800/40 text-center py-4 text-[11px] bg-zinc-950/40">
            <p>&copy; {{ date('Y') }} MeepleHub. Усі права захищені. Powered by Laravel 12.</p>
        </div>
    </footer>

</body>
</html>