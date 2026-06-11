<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-100">
            {{ __('Panel główny') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-800 dark:bg-gray-900 sm:p-8 lg:p-10">
                <div class="grid gap-12 lg:grid-cols-[1fr_0.85fr] lg:items-center">

                    <div>
                        <p class="text-sm font-black uppercase tracking-widest text-indigo-600 dark:text-indigo-400">
                            Rozliczanie wydatków
                        </p>
                        <h1 class="mt-4 text-3xl font-black leading-tight text-gray-950 dark:text-white sm:text-4xl lg:text-5xl lg:leading-tight">
                            Zarządzaj grupami i wspólnymi rachunkami.
                        </h1>
                        <p class="mt-6 text-base leading-relaxed text-gray-600 dark:text-gray-300">
                            Dodawaj wydatki, przypisuj je do osób i sprawdzaj salda w grupach. Rozliczanie ze znajomymi jeszcze nigdy nie było tak proste.
                        </p>

                        <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                            @auth
                                <a href="{{ route('groups.index') }}" class="inline-flex justify-center rounded-xl bg-indigo-600 px-6 py-3.5 text-sm font-bold text-white shadow-md transition-all hover:-translate-y-0.5 hover:bg-indigo-700 hover:shadow-lg focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:text-gray-950 dark:hover:bg-indigo-400">
                                    Moje grupy
                                </a>
                            @else
                                @if(Route::has('register'))
                                    <a href="{{ route('register') }}" class="inline-flex justify-center rounded-xl bg-indigo-600 px-6 py-3.5 text-sm font-bold text-white shadow-md transition-all hover:-translate-y-0.5 hover:bg-indigo-700 hover:shadow-lg dark:bg-indigo-500 dark:text-gray-950 dark:hover:bg-indigo-400">
                                        Utwórz konto
                                    </a>
                                @endif
                                <a href="{{ route('login') }}" class="inline-flex justify-center rounded-xl border-2 border-gray-200 bg-transparent px-6 py-3.5 text-sm font-bold text-gray-800 transition-all hover:border-indigo-600 hover:text-indigo-600 dark:border-gray-700 dark:text-gray-200 dark:hover:border-indigo-400 dark:hover:text-indigo-400">
                                    Zaloguj się
                                </a>
                            @endauth
                        </div>
                    </div>

                    <div class="rounded-2xl border border-indigo-50 bg-indigo-50/30 p-6 shadow-inner dark:border-indigo-900/20 dark:bg-gray-950/50 sm:p-8">
                        <h2 class="flex items-center gap-3 text-lg font-black text-gray-950 dark:text-white">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-100 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                </svg>
                            </span>
                            Szybki start
                        </h2>
                        <ul class="mt-8 space-y-5 text-sm leading-6 text-gray-700 dark:text-gray-300">
                            <li class="flex items-center gap-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white font-black text-indigo-600 shadow-sm border border-indigo-100 dark:border-indigo-900/50 dark:bg-gray-900 dark:text-indigo-400">1</span>
                                <span class="font-medium">Utwórz grupę rozliczeniową.</span>
                            </li>
                            <li class="flex items-center gap-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white font-black text-indigo-600 shadow-sm border border-indigo-100 dark:border-indigo-900/50 dark:bg-gray-900 dark:text-indigo-400">2</span>
                                <span class="font-medium">Dodaj uczestników do grupy.</span>
                            </li>
                            <li class="flex items-center gap-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white font-black text-indigo-600 shadow-sm border border-indigo-100 dark:border-indigo-900/50 dark:bg-gray-900 dark:text-indigo-400">3</span>
                                <span class="font-medium">Zapisz wydatki i pozycje z rachunków.</span>
                            </li>
                            <li class="flex items-center gap-4">
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-white font-black text-indigo-600 shadow-sm border border-indigo-100 dark:border-indigo-900/50 dark:bg-gray-900 dark:text-indigo-400">4</span>
                                <span class="font-medium">Sprawdź, kto komu oddaje pieniądze.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
                <div class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md dark:border-gray-800 dark:bg-gray-900">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-widest text-gray-500 dark:text-gray-400">Grupy</p>
                            <p class="mt-2 text-4xl font-black text-gray-900 dark:text-gray-100">{{ $groupsCount ?? 0 }}</p>
                        </div>
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 transition-colors group-hover:bg-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-400 dark:group-hover:bg-indigo-900/60">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-7 w-7">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                </div>

        </div>
    </div>
</x-app-layout>
