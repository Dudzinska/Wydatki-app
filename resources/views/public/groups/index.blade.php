<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            <section class="glamour-hero rounded-3xl p-8 text-white shadow-2xl">
                <p class="text-sm font-bold uppercase tracking-[0.22em] text-fuchsia-100">Katalog grup</p>
                <h1 class="mt-4 text-3xl font-black sm:text-4xl">Przegladaj grupy</h1>
                <p class="mt-4 max-w-3xl text-sm leading-7 text-fuchsia-50/95">
                    Dostep do danych grup i wydatkow wymaga zalogowania.
                </p>
            </section>

            <section class="glamour-card rounded-2xl border p-6 shadow-xl">
                <h2 class="text-lg font-black text-slate-900 dark:text-slate-100">Filtrowanie i sortowanie</h2>
                <form action="{{ route('public.groups.index') }}" method="GET" class="mt-5 grid gap-4 md:grid-cols-5">
                    <div class="md:col-span-2">
                        <label for="search" class="text-sm font-bold text-slate-700 dark:text-slate-200">Szukaj grupy</label>
                        <input id="search" type="search" name="search" value="{{ $filters['search'] ?? '' }}"
                               class="mt-1 w-full rounded-xl border-slate-300 bg-white/80 text-slate-900 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 dark:border-slate-700 dark:bg-slate-950/70 dark:text-slate-100">
                    </div>
                    <div>
                        <label for="min_total" class="text-sm font-bold text-slate-700 dark:text-slate-200">Wydatki od (PLN)</label>
                        <input id="min_total" type="number" step="0.01" min="0" name="min_total" value="{{ $filters['min_total'] ?? '' }}"
                               class="mt-1 w-full rounded-xl border-slate-300 bg-white/80 text-slate-900 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 dark:border-slate-700 dark:bg-slate-950/70 dark:text-slate-100">
                    </div>
                    <div>
                        <label for="min_members" class="text-sm font-bold text-slate-700 dark:text-slate-200">Min. osob</label>
                        <input id="min_members" type="number" min="1" name="min_members" value="{{ $filters['min_members'] ?? '' }}"
                               class="mt-1 w-full rounded-xl border-slate-300 bg-white/80 text-slate-900 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 dark:border-slate-700 dark:bg-slate-950/70 dark:text-slate-100">
                    </div>
                    <div>
                        <label for="sort" class="text-sm font-bold text-slate-700 dark:text-slate-200">Sortowanie</label>
                        <select id="sort" name="sort"
                                class="mt-1 w-full rounded-xl border-slate-300 bg-white/80 text-slate-900 shadow-sm focus:border-fuchsia-500 focus:ring-fuchsia-500 dark:border-slate-700 dark:bg-slate-950/70 dark:text-slate-100">
                            <option value="newest" @selected(($filters['sort'] ?? 'newest') === 'newest')>Najnowsze</option>
                            <option value="oldest" @selected(($filters['sort'] ?? '') === 'oldest')>Najstarsze</option>
                            <option value="name_asc" @selected(($filters['sort'] ?? '') === 'name_asc')>Nazwa A-Z</option>
                            <option value="name_desc" @selected(($filters['sort'] ?? '') === 'name_desc')>Nazwa Z-A</option>
                            <option value="total_desc" @selected(($filters['sort'] ?? '') === 'total_desc')>Najwieksze wydatki</option>
                            <option value="members_desc" @selected(($filters['sort'] ?? '') === 'members_desc')>Najwiecej czlonkow</option>
                        </select>
                    </div>
                    <div class="md:col-span-5 flex flex-wrap gap-3">
                        <button type="submit" class="rounded-xl bg-fuchsia-600 px-5 py-3 text-sm font-black text-white hover:bg-fuchsia-700">Filtruj</button>
                        <a href="{{ route('public.groups.index') }}" class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-black text-slate-700 hover:border-fuchsia-500 hover:text-fuchsia-700 dark:border-slate-700 dark:text-slate-200 dark:hover:border-fuchsia-500 dark:hover:text-fuchsia-300">Wyczysc</a>
                    </div>
                </form>
            </section>

            <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @forelse($groups as $group)
                    <article class="glamour-card rounded-2xl border p-6 shadow-lg">
                        <div class="flex items-start justify-between gap-4">
                            <h3 class="text-xl font-black text-slate-900 dark:text-slate-100">{{ $group->name }}</h3>
                            <span class="rounded-full bg-fuchsia-100 px-3 py-1 text-xs font-black uppercase tracking-wide text-fuchsia-700 dark:bg-fuchsia-950 dark:text-fuchsia-200">
                                Zalogowany
                            </span>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-300">
                            {{ $group->description ?: 'Brak opisu grupy.' }}
                        </p>
                        <dl class="mt-5 grid grid-cols-3 gap-2 text-center">
                            <div class="rounded-xl bg-slate-50 p-3 dark:bg-slate-950/60">
                                <dt class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Osoby</dt>
                                <dd class="mt-1 text-lg font-black text-slate-900 dark:text-slate-100">{{ $group->users_count }}</dd>
                            </div>
                            <div class="rounded-xl bg-slate-50 p-3 dark:bg-slate-950/60">
                                <dt class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Wydatki</dt>
                                <dd class="mt-1 text-lg font-black text-slate-900 dark:text-slate-100">{{ $group->bills_count }}</dd>
                            </div>
                            <div class="rounded-xl bg-slate-50 p-3 dark:bg-slate-950/60">
                                <dt class="text-[11px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Suma</dt>
                                <dd class="mt-1 text-lg font-black text-emerald-600 dark:text-emerald-300">{{ number_format($group->total_amount, 2) }}</dd>
                            </div>
                        </dl>
                        <p class="mt-4 text-xs text-slate-500 dark:text-slate-400">Lider: {{ $group->owner->name ?? 'Brak danych' }}</p>
                        <a href="{{ route('public.groups.show', $group) }}" class="mt-5 inline-flex rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-black text-white hover:bg-slate-800 dark:bg-slate-100 dark:text-slate-950 dark:hover:bg-white">
                            Zobacz szczegoly
                        </a>
                    </article>
                @empty
                    <div class="md:col-span-2 xl:col-span-3 rounded-2xl border border-dashed border-slate-300 p-8 text-center text-slate-500 dark:border-slate-700 dark:text-slate-400">
                        Brak grup pasujacych do podanych filtrow.
                    </div>
                @endforelse
            </section>

            <div class="rounded-2xl border border-slate-200 bg-white/60 px-5 py-4 shadow-sm dark:border-slate-800 dark:bg-slate-900/50">
                {{ $groups->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
