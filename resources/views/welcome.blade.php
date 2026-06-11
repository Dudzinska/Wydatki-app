<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>BillsBuddy</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @include('layouts.theme-script')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 dark:text-gray-100">
        <div class="min-h-screen">
            <header class="glamour-card border-b border-fuchsia-100/70 dark:border-fuchsia-950/50">
                <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                    <a href="{{ route('home') }}" class="text-xl font-black tracking-tight text-fuchsia-700 dark:text-fuchsia-300">
                        BillsBuddy
                    </a>

                    <div class="flex flex-wrap items-center gap-3">
                        <x-theme-toggle />
                        @auth
                            <a href="{{ route('public.groups.index') }}" class="rounded-lg border border-fuchsia-200 px-4 py-2 text-sm font-bold text-fuchsia-700 hover:bg-fuchsia-50 dark:border-fuchsia-900 dark:text-fuchsia-300 dark:hover:bg-fuchsia-950/40">
                                Katalog grup
                            </a>
                            <a href="{{ route('groups.index') }}" class="rounded-lg bg-fuchsia-600 px-4 py-2 text-sm font-bold text-white hover:bg-fuchsia-700">
                                Moje grupy
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-fuchsia-700 dark:text-gray-200 dark:hover:text-fuchsia-300">
                                Logowanie
                            </a>
                            @if(Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-lg bg-fuchsia-600 px-4 py-2 text-sm font-bold text-white hover:bg-fuchsia-700">
                                    Rejestracja
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </header>

            <main class="mx-auto max-w-6xl space-y-8 px-4 py-10 sm:px-6 lg:px-8">
                <section class="glamour-hero rounded-3xl p-8 text-white shadow-2xl sm:p-10">
                    <p class="text-sm font-black uppercase tracking-[0.22em] text-fuchsia-100">Aplikacja do wspolnych rozliczen</p>
                    <h1 class="mt-4 text-4xl font-black leading-tight sm:text-5xl">
                        Rozliczaj wydatki w grupie prosto i przejrzyście.
                    </h1>
                    <p class="mt-5 max-w-2xl text-base leading-7 text-fuchsia-50/95">
                        Tworz grupy, dodawaj uczestnikow, zapisuj rachunki i sprawdzaj salda po zalogowaniu.
                    </p>
                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        @auth
                            <a href="{{ route('groups.index') }}" class="inline-flex justify-center rounded-xl bg-white px-5 py-3 text-sm font-black text-fuchsia-700 hover:bg-fuchsia-50">
                                Przejdz do grup
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex justify-center rounded-xl bg-white px-5 py-3 text-sm font-black text-fuchsia-700 hover:bg-fuchsia-50">
                                Zaloguj sie
                            </a>
                            @if(Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex justify-center rounded-xl border border-white/80 px-5 py-3 text-sm font-black text-white hover:bg-white/10">
                                    Utworz konto
                                </a>
                            @endif
                        @endauth
                    </div>
                </section>

                <section class="grid gap-5 md:grid-cols-3">
                    <article class="glamour-card rounded-2xl border p-6">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Grupy</p>
                        <p class="mt-2 text-4xl font-black text-slate-900 dark:text-slate-100">{{ $groupsCount ?? 0 }}</p>
                    </article>
                    <article class="glamour-card rounded-2xl border p-6">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Uzytkownicy</p>
                        <p class="mt-2 text-4xl font-black text-slate-900 dark:text-slate-100">{{ $usersCount ?? 0 }}</p>
                    </article>
                    <article class="glamour-card rounded-2xl border p-6">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Wydatki</p>
                        <p class="mt-2 text-4xl font-black text-slate-900 dark:text-slate-100">{{ $billsCount ?? 0 }}</p>
                    </article>
                </section>

            </main>
        </div>
    </body>
</html>
