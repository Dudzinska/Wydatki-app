<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-100">
            {{ __('Panel główny') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <section class="glamour-hero rounded-3xl p-8 text-white shadow-2xl sm:p-10">
                <p class="text-sm font-black uppercase tracking-[0.22em] text-fuchsia-100">Rozliczanie wydatkow</p>
                <h1 class="mt-4 text-3xl font-black leading-tight sm:text-4xl lg:text-5xl">
                    Zarządzaj grupami i wspólnymi rachunkami.
                </h1>
                <p class="mt-5 max-w-3xl text-base leading-relaxed text-fuchsia-50/95">
                    Dodawaj wydatki, przypisuj je do osob i sprawdzaj salda w grupach. Motyw glamour poprawia czytelnosc panelu.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    @auth
                        <a href="{{ route('groups.index') }}" class="rounded-xl bg-white px-6 py-3 text-sm font-black text-fuchsia-700 hover:bg-fuchsia-50">
                            Moje grupy
                        </a>
                        <a href="{{ route('public.groups.index') }}" class="rounded-xl border border-white/80 px-6 py-3 text-sm font-black text-white hover:bg-white/10">
                            Katalog grup
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-xl bg-white px-6 py-3 text-sm font-black text-fuchsia-700 hover:bg-fuchsia-50">
                            Zaloguj sie
                        </a>
                    @endauth
                </div>
            </section>

            <section class="grid gap-6 sm:grid-cols-2 md:grid-cols-3">
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

            <section class="grid gap-6 lg:grid-cols-2">
                <article class="glamour-card rounded-2xl border p-6">
                    <h2 class="text-lg font-black text-slate-900 dark:text-slate-100">Nowe funkcje 5.0</h2>
                    <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-600 dark:text-slate-300">
                        <li>Publiczny katalog grup dla niezalogowanych (read-only).</li>
                        <li>Automatyczne przeliczanie podzialu kosztow po pozycjach paragonu.</li>
                        <li>Propozycje minimalnej liczby przelewow do zamkniecia sald.</li>
                    </ul>
                </article>
                <article class="glamour-card rounded-2xl border p-6">
                    <h2 class="text-lg font-black text-slate-900 dark:text-slate-100">Szybki start</h2>
                    <ol class="mt-4 space-y-3 text-sm leading-6 text-slate-600 dark:text-slate-300">
                        <li><span class="font-black text-fuchsia-700 dark:text-fuchsia-300">1.</span> Utworz grupe rozliczeniowa.</li>
                        <li><span class="font-black text-fuchsia-700 dark:text-fuchsia-300">2.</span> Dodaj uczestnikow i wydatki.</li>
                        <li><span class="font-black text-fuchsia-700 dark:text-fuchsia-300">3.</span> Dodaj pozycje paragonu dla precyzyjnego podzialu.</li>
                        <li><span class="font-black text-fuchsia-700 dark:text-fuchsia-300">4.</span> Skorzystaj z gotowego planu przelewow.</li>
                    </ol>
                </article>
            </section>
        </div>
    </div>
</x-app-layout>
