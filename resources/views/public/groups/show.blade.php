<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            <section class="glamour-hero rounded-3xl p-8 text-white shadow-2xl">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.22em] text-fuchsia-100">Podglad grupy</p>
                        <h1 class="mt-4 text-3xl font-black sm:text-4xl">{{ $group->name }}</h1>
                        <p class="mt-4 max-w-3xl text-sm leading-7 text-fuchsia-50/95">{{ $group->description ?: 'Brak opisu grupy.' }}</p>
                    </div>
                    <a href="{{ route('public.groups.index') }}" class="rounded-xl border border-white/60 px-4 py-2.5 text-sm font-black text-white hover:bg-white/15">Wroc do katalogu</a>
                </div>
            </section>

            <section class="grid gap-6 lg:grid-cols-3">
                <div class="glamour-card rounded-2xl border p-6 shadow-xl">
                    <h2 class="text-lg font-black text-slate-900 dark:text-slate-100">Podstawowe dane</h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div class="flex justify-between gap-3">
                            <dt class="text-slate-500 dark:text-slate-400">Lider grupy</dt>
                            <dd class="font-bold text-slate-900 dark:text-slate-100">{{ $group->owner->name ?? 'Brak danych' }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-slate-500 dark:text-slate-400">Liczba czlonkow</dt>
                            <dd class="font-bold text-slate-900 dark:text-slate-100">{{ $group->users->count() }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-slate-500 dark:text-slate-400">Liczba wydatkow</dt>
                            <dd class="font-bold text-slate-900 dark:text-slate-100">{{ $group->bills->count() }}</dd>
                        </div>
                        <div class="flex justify-between gap-3">
                            <dt class="text-slate-500 dark:text-slate-400">Suma wydatkow</dt>
                            <dd class="font-black text-emerald-600 dark:text-emerald-300">{{ number_format($group->total_amount, 2) }} PLN</dd>
                        </div>
                    </dl>
                </div>

                <div class="glamour-card rounded-2xl border p-6 shadow-xl lg:col-span-2">
                    <h2 class="text-lg font-black text-slate-900 dark:text-slate-100">Proponowane rozliczenie</h2>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">
                        Algorytm minimalizuje liczbe przelewow pomiedzy osobami z debetem i nadplata.
                    </p>
                    <div class="mt-4 space-y-3">
                        @forelse($settlementPlan as $step)
                            <div class="rounded-xl bg-slate-50 p-4 text-sm dark:bg-slate-950/60">
                                <span class="font-black text-slate-900 dark:text-slate-100">{{ $step['from']->name }}</span>
                                <span class="text-slate-500 dark:text-slate-400">powinien przelac</span>
                                <span class="font-black text-fuchsia-700 dark:text-fuchsia-300">{{ number_format($step['amount'], 2) }} PLN</span>
                                <span class="text-slate-500 dark:text-slate-400">do</span>
                                <span class="font-black text-slate-900 dark:text-slate-100">{{ $step['to']->name }}</span>.
                            </div>
                        @empty
                            <p class="rounded-xl bg-emerald-50 p-4 text-sm font-semibold text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">
                                W tej chwili grupa jest rozliczona - brak koniecznych przelewow.
                            </p>
                        @endforelse
                    </div>
                </div>
            </section>

            <section class="grid gap-6 lg:grid-cols-2">
                <div class="glamour-card rounded-2xl border p-6 shadow-xl">
                    <h2 class="text-lg font-black text-slate-900 dark:text-slate-100">Salda uczestnikow</h2>
                    <div class="mt-4 space-y-3">
                        @foreach($balances as $entry)
                            <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60">
                                <span class="font-bold text-slate-900 dark:text-slate-100">{{ $entry['user']->name }}</span>
                                <span class="{{ $entry['balance'] >= 0 ? 'text-emerald-600 dark:text-emerald-300' : 'text-rose-600 dark:text-rose-300' }} font-black">
                                    {{ number_format($entry['balance'], 2) }} PLN
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="glamour-card rounded-2xl border p-6 shadow-xl">
                    <h2 class="text-lg font-black text-slate-900 dark:text-slate-100">Ostatnie wydatki</h2>
                    <div class="mt-4 space-y-3">
                        @forelse($group->bills as $bill)
                            <div class="rounded-xl bg-slate-50 px-4 py-3 dark:bg-slate-950/60">
                                <p class="font-black text-slate-900 dark:text-slate-100">{{ $bill->description }}</p>
                                <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">
                                    Platnik: {{ $bill->payer->name ?? 'Brak danych' }} | Data: {{ $bill->date }}
                                </p>
                                <p class="mt-1 text-sm font-black text-emerald-600 dark:text-emerald-300">{{ number_format($bill->amount, 2) }} PLN</p>
                            </div>
                        @empty
                            <p class="rounded-xl bg-slate-50 p-4 text-sm text-slate-500 dark:bg-slate-950/60 dark:text-slate-400">Brak wydatkow do wyswietlenia.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
