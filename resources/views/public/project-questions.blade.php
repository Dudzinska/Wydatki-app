<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
            <section class="glamour-hero rounded-3xl p-8 text-white shadow-2xl">
                <p class="text-sm font-black uppercase tracking-[0.22em] text-fuchsia-100">Pytania do projektu</p>
                <h1 class="mt-4 text-3xl font-black sm:text-4xl">Odpowiedzi 3.0 i 4.0</h1>
                <p class="mt-3 text-sm leading-7 text-fuchsia-50/95">
                    Zestaw odpowiedzi przygotowany na podstawie wymagań z dokumentu IA
                    oraz aktualnej implementacji projektu BillsBuddy.
                </p>
            </section>

            <section class="glamour-card rounded-2xl border p-6 shadow-xl">
                <article class="prose prose-slate max-w-none dark:prose-invert prose-headings:font-black prose-headings:text-slate-900 dark:prose-headings:text-slate-100 prose-p:text-slate-700 dark:prose-p:text-slate-300">
                    {!! $contentHtml !!}
                </article>
            </section>
        </div>
    </div>
</x-app-layout>
