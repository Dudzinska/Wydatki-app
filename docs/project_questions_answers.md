# Pytania do projektu – odpowiedzi (ocena 3.0 i 4.0)

Źródło pytań i kryteriów: https://ia.lazysolutions.pl/project_requirements.html

> Kontekst projektu: BillsBuddy (Laravel), aplikacja do rozliczania wspólnych wydatków.

## Pytania na ocenę 3.0

### 1. Opisz działanie protokołu HTTP.
HTTP to protokół komunikacji klient-serwer używany w WWW. Przeglądarka wysyła żądanie (request), serwer zwraca odpowiedź (response). Każde żądanie jest niezależne i zawiera wszystkie informacje potrzebne do jego obsługi.

### 2. Czym różni się HTTP od HTTPS?
HTTPS to HTTP działające przez TLS/SSL. W HTTPS dane są szyfrowane, zapewniona jest integralność i weryfikacja certyfikatu serwera. HTTP nie szyfruje ruchu i jest podatne na podsłuch oraz modyfikację.

### 3. Jak zbudowane jest żądanie HTTP?
Żądanie zawiera: linię startową (metoda, ścieżka, wersja), nagłówki, pustą linię oraz opcjonalne body. Przykład: `POST /groups HTTP/1.1`, nagłówki `Host`, `Content-Type`, `Cookie`, a body np. JSON lub dane formularza.

### 4. Jak zbudowana jest odpowiedź HTTP?
Odpowiedź ma linię statusu (np. `HTTP/1.1 200 OK`), nagłówki, pustą linię i body (HTML/JSON/itp.). Status mówi o wyniku operacji, nagłówki określają metadane odpowiedzi.

### 5. Jak obsługiwane są żądania HTTP w projekcie Laravel?
Ruch trafia przez `public/index.php` do kernela aplikacji. Laravel dopasowuje route z `routes/web.php`, uruchamia middleware, a potem odpowiedni kontroler/metodę (lub closure). Wynik to widok Blade albo redirect/JSON.

### 6. Jakie są metody HTTP?
Najczęściej: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS. W API spotyka się też TRACE/CONNECT, ale rzadziej w aplikacjach webowych.

### 7. Jakie są kody odpowiedzi HTTP?
Grupy kodów: 1xx informacyjne, 2xx sukces, 3xx przekierowania, 4xx błędy klienta, 5xx błędy serwera. Przykłady: 200 OK, 201 Created, 302 Found, 403 Forbidden, 404 Not Found, 422 Unprocessable Entity, 500 Internal Server Error.

### 8. Jakie są nagłówki HTTP?
To metadane żądania/odpowiedzi, np. `Host`, `Authorization`, `Content-Type`, `Accept`, `Cookie`, `Set-Cookie`, `Cache-Control`, `User-Agent`. Wpływają na autoryzację, format danych i cache.

### 9. Jakie metody HTTP obsługuje domyślnie język HTML?
Formularze HTML wspierają natywnie tylko `GET` i `POST`.

### 10. Jak obsługiwać pozostałe metody HTTP w Laravel, których HTML nie wspiera?
Używa się spoofingu metod: formularz wysyła `POST`, a Laravel dostaje ukrytą wartość metody przez `@method('PUT')`, `@method('PATCH')`, `@method('DELETE')`.

### 11. Jakie znasz narzędzia do debugowania i testowania UI?
DevTools w przeglądarce (Elements, Responsive Mode), Lighthouse, Playwright/Cypress (testy E2E), testy manualne scenariuszy użytkownika.

### 12. Jakie znasz narzędzia do debugowania HTTP/JavaScript?
Network tab w DevTools, Postman/Insomnia, curl, logi JS w Console, source maps, debugger w VS Code/Chrome.

### 13. Jakie znasz narzędzia do debugowania bazy danych?
phpMyAdmin/DB client (MySQL), sqlitebrowser (SQLite), Laravel Query Log, `php artisan tinker`, logi SQL (np. Telescope/Debugbar – jeśli użyte).

### 14. Opisz drogę instrukcji po wpisaniu adresu strony i Enter.
Przeglądarka wysyła request GET do serwera. Laravel ładuje aplikację, route jest dopasowany, middleware sprawdza dostęp, kontroler/closure pobiera dane, renderuje widok Blade, a serwer odsyła HTML do przeglądarki.

### 15. Opisz drogę instrukcji po kliknięciu „dodaj/usuń/edytuj” w formularzu.
Formularz wysyła request (POST/DELETE/PATCH przez spoofing). Laravel przechodzi przez middleware i walidację, kontroler wykonuje operację na modelu/bazie, po czym zwraca redirect z komunikatem sukcesu lub błędami walidacji.

### 16. Czym różni się GET od POST?
GET służy do pobierania danych i parametry ma zwykle w URL. POST służy do tworzenia/wywołania operacji z body żądania; nie powinien być używany do bezpiecznego cache’owanego odczytu.

### 17. Do czego wykorzystujemy poszczególne metody HTTP?
GET – odczyt, POST – tworzenie, PUT – pełna aktualizacja, PATCH – częściowa aktualizacja, DELETE – usuwanie, HEAD – nagłówki bez body, OPTIONS – informacje o dozwolonych metodach.

### 18. W jaki sposób działa walidacja po stronie frontendu?
Przez typy pól HTML (`type="email"`, `required`, `min`, `step`) oraz dodatkowy JavaScript. Ma poprawiać UX, ale nie zastępuje walidacji serwerowej.

### 19. W jaki sposób działa walidacja po stronie serwera Laravel?
Kontroler (lub FormRequest) definiuje reguły walidacji. Gdy dane są błędne, Laravel zwraca redirect z błędami do sesji i old input; gdy poprawne – kod przechodzi do zapisu.

### 20. Czym są migracje i jak je tworzyć?
Migracje to wersjonowanie schematu bazy danych. Tworzy się je przez `php artisan make:migration`, a uruchamia przez `php artisan migrate`.

Przykład:
```php
Schema::create('subscriptions', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->decimal('price', 10, 2);
    $table->timestamps();
});
```

### 21. Czym są seedery i jak je tworzyć?
Seedery służą do wstawiania danych początkowych/testowych. Tworzenie: `php artisan make:seeder`, uruchomienie: `php artisan db:seed` albo `migrate:fresh --seed`.

Przykład:
```php
User::factory()->create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'role' => 'admin',
]);
```

### 22. Czym są kontrolery i jak je tworzyć?
Kontroler grupuje logikę obsługi requestów HTTP. Tworzenie: `php artisan make:controller GroupController`.

Przykład:
```php
public function index() {
    $groups = Group::latest()->paginate();
    return view('groups.index', compact('groups'));
}
```

### 23. Czym są modele i jak je tworzyć?
Model Eloquent reprezentuje tabelę i logikę danych. Tworzenie: `php artisan make:model Group`.

Przykład:
```php
class Group extends Model {
    protected $fillable = ['name', 'description', 'owner_id'];
}
```

### 24. Czym są widoki i jak je tworzyć?
Widoki to szablony HTML (Blade) renderowane użytkownikowi. Tworzy się je jako pliki `.blade.php` w `resources/views`.

### 25. Czym są routing i jak je tworzyć?
Routing mapuje URL + metodę HTTP na akcję aplikacji. Definiuje się je np. w `routes/web.php`.

Przykład:
```php
Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
```

### 26. Jak zabezpieczyć route tylko dla administratora?
Przez middleware sprawdzający rolę użytkownika i przypięcie go do trasy/grupy tras, np. `Route::middleware('admin')->group(...)`.

### 27. Czym jest CSRF Token i dlaczego jest wymagany?
To token chroniący przed atakami CSRF (fałszywe żądania z cudzej strony). Laravel weryfikuje token dla żądań modyfikujących dane, dlatego formularze mają `@csrf`.

### 28. Sposoby wyświetlania zmiennych w Blade i ochrona XSS.
`{{ $var }}` – bezpieczne (escape HTML), `{!! $html !!}` – bez escape (tylko dla zaufanego HTML), `@json($var)` – bezpieczny JSON do JS. Ochrona XSS jest domyślnie przez escaping w `{{ }}`.

### 29. Czym różni się Eloquent ORM od Query Buildera?
Eloquent operuje na modelach i relacjach (bardziej obiektowo). Query Builder operuje na zapytaniach SQL bez warstwy modeli (często prostszy i wydajny do specyficznych zapytań).

### 30. Do czego służy plik .env i czemu nie trafia do repo?
`.env` trzyma konfigurację zależną od środowiska (DB, klucze, hasła). Nie powinien trafiać do Git, bo zawiera wrażliwe dane.

### 31. Gdzie szukać logów aplikacji Laravel?
W `storage/logs/`, najczęściej plik `laravel.log`.

### 32. HTTP jest bezstanowy – jak Laravel „pamięta” zalogowanego?
Przez sesję i cookie sesyjne. Po logowaniu identyfikator sesji jest przechowywany po stronie klienta (cookie), a dane sesji po stronie serwera.

### 33. Jak przechowywać hasła i jaki mechanizm ma Laravel?
Hasła przechowuje się wyłącznie jako hash (nigdy plaintext). Laravel używa `Hash::make()` (bcrypt/argon) oraz `Hash::check()` do weryfikacji.

## Pytania na ocenę 4.0

### 1. Jak zrealizowano rozróżnienie uprawnień admin/user?
W projekcie użyto pola `role` w modelu `User` oraz `AdminMiddleware` (alias `admin`). Trasy panelu admina są w grupie `Route::middleware('admin')`, a zwykły użytkownik nie ma do nich dostępu.

### 2. Jak działają relacje i jak je wykorzystać w widoku?
Przykłady: `Group` ma wielu `Bill` (one-to-many), `Group` ma wielu `User` (many-to-many), `Bill` ma wielu `BillSplit`. W widoku używamy np. `$group->users`, `$bill->payer->name`, a dla wydajności stosujemy eager loading `with(...)`.

### 3. Co to FormRequest i czemu warto?
To dedykowane klasy walidacji/autoryzacji requestu. Upraszczają kontrolery, porządkują reguły i pozwalają wielokrotnie używać tej samej walidacji.

### 4. Jak działa Route Model Binding?
Laravel automatycznie podmienia parametr trasy na model, np. w metodzie `show(Group $group)` na podstawie `{group}` z URL. Jeśli rekord nie istnieje, zwraca 404.

### 5. Jak zapewniono, że user edytuje/usuwa tylko własne zasoby?
W kontrolerach są warunki autoryzacyjne (np. właściciel grupy lub admin). Dla nieuprawnionych akcji zwracane jest 403.

### 6. Jakie dyrektywy Blade użyto dla DRY?
W projekcie użyto m.in. komponentów i layoutów (`<x-app-layout>`, `<x-input-error>`), `@include`, `@auth`, `@if`, `@foreach`, `@csrf`, `@method`. To ogranicza duplikację i porządkuje widoki.

### 7. Jak zrealizować upload plików w Laravel i symlink do storage?
Standardowo: walidacja pliku, zapis przez `Storage::putFile(...)` albo `$request->file(...)->store(...)`. Dla publicznego dostępu tworzy się link: `php artisan storage:link`.

W tym projekcie upload plików nie jest główną funkcją produkcyjną; mechanizm można dodać analogicznie (np. zdjęcia paragonów).

### 8. Czym są Soft Deletes i kiedy są użyteczne?
Soft Deletes oznaczają logiczne usunięcie rekordu (kolumna `deleted_at`), bez fizycznego kasowania danych. Przydatne przy audycie, możliwości przywracania danych i bezpieczeństwie operacyjnym.
