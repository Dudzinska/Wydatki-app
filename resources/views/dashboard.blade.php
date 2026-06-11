<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-gray-100">
            {{ __('Panel główny') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <section class="glamour-hero rounded-3xl p-8 text-white shadow-2xl sm:p-10">
                <p class="text-sm font-black uppercase tracking-[0.22em] text-fuchsia-100">BillsBuddy</p>
                <h1 class="mt-4 text-3xl font-black leading-tight sm:text-4xl lg:text-5xl">
                    Zarządzaj grupami i wspólnymi rachunkami.
                </h1>
                <p class="mt-5 max-w-3xl text-base leading-relaxed text-fuchsia-50/95">
                    Dodawaj wydatki, przypisuj je do osob i sprawdzaj salda w grupach.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('groups.index') }}" class="rounded-xl bg-white px-6 py-3 text-sm font-black text-fuchsia-700 hover:bg-fuchsia-50">
                        Moje grupy
                    </a>
                    <a href="{{ route('public.groups.index') }}" class="rounded-xl border border-white/80 px-6 py-3 text-sm font-black text-white hover:bg-white/10">
                        Katalog grup
                    </a>
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

        </div>
    </div>
</x-app-layout>
