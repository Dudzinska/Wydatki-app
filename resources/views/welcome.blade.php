<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Rozliczanie wydatków') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @include('layouts.theme-script')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-950 dark:text-gray-100">
        <div class="min-h-screen">
            <header class="border-b border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
                <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                    <a href="{{ route('home') }}" class="text-xl font-black tracking-tight text-indigo-700 dark:text-indigo-300">
                        Rozliczanie wydatków
                    </a>

                    <div class="flex flex-wrap items-center gap-3">
                        <x-theme-toggle />
                        @auth
                            <a href="{{ route('groups.index') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-bold text-white hover:bg-indigo-700 dark:bg-indigo-500 dark:text-gray-950 dark:hover:bg-indigo-400">
                                Moje grupy
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-700 hover:text-indigo-700 dark:text-gray-200 dark:hover:text-indigo-300">
                                Logowanie
                            </a>
                            @if(Route::has('register'))
                                <a href="{{ route('register') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-bold text-white hover:bg-indigo-700 dark:bg-indigo-500 dark:text-gray-950 dark:hover:bg-indigo-400">
                                    Rejestracja
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </header>

            <main class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
                <section class="grid gap-8 lg:grid-cols-[1fr_0.85fr] lg:items-center">
                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:p-8 lg:p-10">
                        <p class="text-sm font-black uppercase tracking-widest text-indigo-600 dark:text-indigo-300">
                            Aplikacja do wspólnych rozliczeń
                        </p>
                        <h1 class="mt-4 text-4xl font-black leading-tight text-gray-950 dark:text-white sm:text-5xl">
                            Rozliczaj wydatki w grupie prosto i przejrzyście.
                        </h1>
                        <p class="mt-5 max-w-2xl text-base leading-7 text-gray-600 dark:text-gray-300">
                            Twórz grupy, dodawaj uczestników, zapisuj rachunki i sprawdzaj, kto komu powinien oddać pieniądze.
                        </p>

                        <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                            @auth
                                <a href="{{ route('groups.index') }}" class="inline-flex justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-black text-white hover:bg-indigo-700 dark:bg-indigo-500 dark:text-gray-950 dark:hover:bg-indigo-400">
                                    Przejdź do grup
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-black text-white hover:bg-indigo-700 dark:bg-indigo-500 dark:text-gray-950 dark:hover:bg-indigo-400">
                                    Zaloguj się
                                </a>
                                @if(Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex justify-center rounded-xl border border-gray-300 px-5 py-3 text-sm font-black text-gray-800 hover:border-indigo-400 hover:text-indigo-700 dark:border-gray-700 dark:text-gray-200 dark:hover:border-indigo-500 dark:hover:text-indigo-300">
                                        Utwórz konto
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <h2 class="text-xl font-black text-gray-950 dark:text-white">Co możesz zrobić?</h2>
                        <div class="mt-5 space-y-4">
                            <div class="rounded-2xl bg-gray-50 p-4 dark:bg-gray-950">
                                <p class="font-bold text-gray-900 dark:text-gray-100">Tworzyć grupy</p>
                                <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-300">Oddziel rozliczenia wyjazdu, imprezy albo mieszkania.</p>
                            </div>
                            <div class="rounded-2xl bg-gray-50 p-4 dark:bg-gray-950">
                                <p class="font-bold text-gray-900 dark:text-gray-100">Dodawać wydatki</p>
                                <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-300">Zapisuj kwoty, płatników i pozycje z paragonu.</p>
                            </div>
                            <div class="rounded-2xl bg-gray-50 p-4 dark:bg-gray-950">
                                <p class="font-bold text-gray-900 dark:text-gray-100">Sprawdzać salda</p>
                                <p class="mt-1 text-sm leading-6 text-gray-600 dark:text-gray-300">System pokazuje podział kosztów i aktualne należności.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="mt-8 grid gap-4 md:grid-cols-3">
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <p class="text-sm font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400">Grupy</p>
                        <p class="mt-2 text-3xl font-black text-gray-950 dark:text-white">{{ $groupsCount ?? 0 }}</p>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <p class="text-sm font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400">Użytkownicy</p>
                        <p class="mt-2 text-3xl font-black text-gray-950 dark:text-white">{{ $usersCount ?? 0 }}</p>
                    </div>
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-800 dark:bg-gray-900">
                        <p class="text-sm font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400">Wydatki</p>
                        <p class="mt-2 text-3xl font-black text-gray-950 dark:text-white">{{ $billsCount ?? 0 }}</p>
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>
