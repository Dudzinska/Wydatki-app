# DOKUMENTACJA PROJEKTU

**BillsBuddy — aplikacja do wspólnego rozliczania wydatków w grupie**

Przedmiot: Aplikacje internetowe

Projekt grupowy — 2 osoby

- **Osoba 1:** [Imię i nazwisko], nr indeksu [Nr indeksu] — moduł „Konta, grupy i administracja"
- **Osoba 2:** [Imię i nazwisko], nr indeksu [Nr indeksu] — moduł „Rachunki i rozliczenia"

Zakres dokumentacji: backend, baza danych, logika biznesowa oraz wybrane elementy frontendu, z wyraźnym oznaczeniem wkładu każdej z dwóch osób.

Data: czerwiec 2026

> **Legenda oznaczeń wkładu:** przy każdej sekcji w nawiasie podano osobę odpowiedzialną — **(Osoba 1)**, **(Osoba 2)** lub **(Osoba 1 + Osoba 2)** dla części wspólnych.

---

## 1. Wprowadzenie — cel aplikacji

BillsBuddy to aplikacja webowa, która pozwala grupie osób (np. współlokatorom, znajomym z wycieczki, rodzinie) wspólnie zapisywać poniesione wydatki i automatycznie wyliczać, kto komu ile jest winien. Użytkownik tworzy grupę, zaprasza do niej uczestników po adresie e-mail, dodaje rachunki (kto zapłacił i ile), a aplikacja sama dzieli koszty po równo, wylicza salda każdej osoby i proponuje minimalny zestaw przelewów, które zamykają wszystkie długi. Aplikacja zawiera również publiczny katalog grup (dla zalogowanych), statystyki wydatków oraz panel administratora.

### 1.1. Pytania pomocnicze

**1. Jaki problem rozwiązuje nasza aplikacja?**

Gdy grupa osób ponosi wspólne wydatki (wspólne zakupy, wyjazd, mieszkanie), trudno na bieżąco pamiętać, kto za co zapłacił i jak się rozliczyć na koniec. Ręczne liczenie na kartce jest podatne na błędy, a liczba przelewów „każdy każdemu” szybko rośnie. BillsBuddy gromadzi wszystkie rachunki w jednym miejscu, automatycznie dzieli koszty i mówi wprost: „Adam przelej Oliwii 200 zł” — zamiast wielu drobnych przelewów wykonuje się tylko niezbędne.

**2. Czym wyróżnia się BillsBuddy wobec podobnych rozwiązań?**

W odróżnieniu od zwykłego arkusza kalkulacyjnego BillsBuddy:
- automatycznie wylicza **plan rozliczeń minimalizujący liczbę przelewów** (algorytm dłużnik–wierzyciel),
- pozwala rozbić rachunek na **pozycje z paragonu** i automatycznie przeliczyć podział,
- pokazuje **salda i statystyki wydatków** grupy w czasie rzeczywistym,
- udostępnia **publiczny katalog grup** z filtrowaniem i sortowaniem,
- rozdziela **role admin/user** oraz chroni zasoby kontrolą dostępu,
- ma responsywny interfejs z motywem jasnym/ciemnym (Tailwind CSS + Alpine.js).

### 1.2. Podział pracy w zespole (2 osoby)

Projekt powstał w dwuosobowym zespole. Praca została podzielona według obszarów funkcjonalnych:

| Obszar | Osoba 1 — Konta, grupy i administracja | Osoba 2 — Rachunki i rozliczenia |
|--------|----------------------------------------|----------------------------------|
| Backend (kontrolery) | `GroupController`, `PublicGroupController`, `Admin\UserController`, `ProfileController` | `BillController`, `BillItemController`, `BillSplitService` |
| Modele | `User`, `Group` (relacje i dostęp) | `Bill`, `BillItem`, `BillSplit`, metody salda/planu w `Group` |
| Logika biznesowa | role i kontrola dostępu, publiczny katalog z filtrami i sortowaniem | automatyczny podział kosztów, plan rozliczeń, statystyki wydatków |
| Baza danych (tabele) | `users`, `groups`, `group_user` | `bills`, `bill_items`, `bill_item_user`, `bill_splits` |
| Baza danych (MySQL) | — | triggery salda grupy + funkcja `get_user_net_balance()` |
| Frontend (widoki) | logowanie/rejestracja, lista i formularze grup, katalog, panel admina | strona grupy (rachunki, salda, plan rozliczeń, statystyki), formularze rachunków i pozycji |
| Wspólne | layout, motyw jasny/ciemny, nawigacja, strona główna, seeder danych testowych | jw. |

#### 1.2.1. Zakres Osoby 1 — Konta, grupy i administracja

- Uwierzytelnianie i role użytkowników (Laravel Breeze, kolumna `role`, `AdminMiddleware`).
- CRUD grup rozliczeniowych (tworzenie, lista, edycja, usuwanie) z walidacją po stronie serwera i klienta oraz unikalnością nazwy.
- Kontrola dostępu do grup (członek/właściciel/admin).
- Publiczny katalog grup z filtrowaniem i sortowaniem.
- Panel administratora: zarządzanie kontami i rolami użytkowników.

#### 1.2.2. Zakres Osoby 2 — Rachunki i rozliczenia

- Dodawanie i usuwanie rachunków oraz pozycji z paragonu wraz z walidacją kwot.
- Automatyczne dzielenie kosztów (po równo oraz na podstawie pozycji paragonu) — `BillSplitService`.
- Algorytm planu rozliczeń minimalizujący liczbę przelewów (`Group::getSettlementPlan()`).
- Statystyki wydatków grupy (bieżący miesiąc, ostatnie 30 dni, najwyższy/średni rachunek).
- Automatyczne saldo grupy (triggery MySQL / logika PHP na SQLite) oraz funkcja SQL `get_user_net_balance()`.

#### 1.2.3. Część wspólna (Osoba 1 + Osoba 2)

- Layout aplikacji, nawigacja, motyw jasny/ciemny, strona główna z licznikami.
- Seeder danych testowych (użytkownicy, grupa, rachunek, podział kosztów).

---

## 2. Uruchomienie projektu (developer) — (Osoba 1 + Osoba 2)

### 2.1. Użyte technologie

| Technologia | Wersja | Rola | Dokumentacja |
|-------------|--------|------|--------------|
| PHP | 8.2+ | Język backendu | https://www.php.net/ |
| Laravel | 12.x | Framework aplikacji | https://laravel.com/docs/12.x |
| SQLite | 3.x (wbudowany) | Baza danych (dev) | https://www.sqlite.org/ |
| Composer | 2.x | Zależności PHP | https://getcomposer.org/ |
| Node.js | 18+ (zalecane 20+) | Build frontendu | https://nodejs.org/ |
| Vite | 7.x | Kompilacja assetów | https://vite.dev/ |
| Tailwind CSS | 3.x | Style UI | https://tailwindcss.com/ |
| Alpine.js | 3.x | Interakcje frontendu | https://alpinejs.dev/ |
| Blade | — (Laravel) | Szablony HTML | https://laravel.com/docs/12.x/blade |
| Laravel Breeze | 2.x | Szkielet uwierzytelniania | https://laravel.com/docs/12.x/starter-kits |

### 2.2. Wymagania programowe

- System operacyjny: Windows 10/11, macOS lub Linux.
- PHP 8.2 lub nowszy z rozszerzeniami: `openssl`, `pdo_sqlite`, `mbstring`, `fileinfo`, `curl`.
- Composer 2.x.
- Node.js 18+ oraz npm.
- Git (do klonowania repozytorium).
- Przeglądarka internetowa (Chrome, Firefox, Edge).

### 2.3. Proces instalacji

1. Sklonuj repozytorium: `git clone https://github.com/Dudzinska/Wydatki-app`
2. Wejdź do katalogu projektu.
3. Zainstaluj zależności PHP: `composer install`
4. Zainstaluj zależności Node: `npm install`
5. Skopiuj plik konfiguracyjny: `copy .env.example .env` (Windows) lub `cp .env.example .env` (Linux/macOS)
6. Wygeneruj klucz aplikacji: `php artisan key:generate`

### 2.4. Proces konfiguracji

Plik `.env` — najważniejsze zmienne:

| Zmienna | Opis | Przykład |
|---------|------|----------|
| `APP_NAME` | Nazwa aplikacji | BillsBuddy |
| `APP_URL` | Adres aplikacji | http://localhost:8000 |
| `DB_CONNECTION` | Typ bazy danych | sqlite |
| `DB_DATABASE` | Ścieżka do pliku SQLite (opcjonalnie) | database/database.sqlite |

7. Utwórz plik bazy SQLite (jeśli nie istnieje): `New-Item database/database.sqlite -ItemType File` (Windows) lub `touch database/database.sqlite` (Linux/macOS).
8. Uruchom migracje i załaduj dane testowe: `php artisan migrate:fresh --seed`
9. Zbuduj assety frontendu: `npm run build` (lub `npm run dev` w trybie deweloperskim).

> Uwaga: domyślnie projekt korzysta z **SQLite** — nie trzeba instalować osobnego serwera bazy. Triggery i funkcja SQL z wymagań na 5.0 są aktywne tylko na **MySQL**; na SQLite ich rolę przejmuje logika w PHP (salda i sumy liczone są po stronie aplikacji), więc aplikacja działa w pełni również na SQLite.

### 2.5. Dane początkowe (seed) — konta testowe

| Login (e-mail) | Hasło | Rola |
|----------------|-------|------|
| oliwia@example.com | password | Administrator |
| adam@example.com | password | Użytkownik |
| ewa@example.com | password | Użytkownik |
| hacker@example.com | password | Użytkownik (spoza grupy demo) |

Seeder `DatabaseSeeder` tworzy czterech użytkowników, grupę „Wycieczka w góry 2026" (z trzema członkami), przykładowy rachunek (600 zł), podział kosztów (`bill_splits`) oraz pozycję z paragonu. Konto `hacker@example.com` celowo nie należy do grupy — służy do testowania kontroli dostępu.

### 2.6. Uruchomienie w terminalu

Tryb deweloperski (serwer + kolejka + logi + Vite jednocześnie):

```
composer run dev
```

Alternatywnie osobno:
- `php artisan serve` → http://127.0.0.1:8000
- `npm run dev` → kompilacja CSS/JS na żywo

---

## 3. Uruchomienie projektu (użytkownik końcowy) — (Osoba 1 + Osoba 2)

Aplikacja jest webowa — użytkownik końcowy nie instaluje kodu. W środowisku produkcyjnym wystarczy adres URL opublikowanej aplikacji. W wersji lokalnej/demonstracyjnej: http://127.0.0.1:8000.

Wymagania sprzętowe:
- Komputer lub smartfon z nowoczesną przeglądarką.
- Połączenie internetowe.
- Rozdzielczość min. 360 px szerokości (layout responsywny Tailwind CSS).

---

## 4. Podręcznik użytkownika

### 4.1. Strona główna i logowanie — (Osoba 1)

Strona startowa (`/`) prezentuje krótki opis aplikacji oraz liczniki (liczba grup, użytkowników i rachunków). Gość może się zalogować lub zarejestrować. Po zalogowaniu użytkownik trafia do panelu (`/dashboard`) i ma dostęp do swoich grup oraz publicznego katalogu.

> [Miejsce na Rys. 1] — Strona główna z opisem aplikacji i licznikami.

### 4.2. Moje grupy — lista (READ) — (Osoba 1)

Ścieżka: **Moje grupy** → `/groups`

- Zwykły użytkownik widzi tylko grupy, do których należy; administrator widzi wszystkie grupy.
- Lista jest stronicowana (8 na stronę) i sortowana po nazwie.
- Dostępne jest wyszukiwanie po nazwie i opisie grupy; administrator dodatkowo może filtrować po właścicielu (nazwa lub e-mail).
- Każda karta pokazuje liczbę uczestników i liczbę rachunków.

> [Miejsce na Rys. 2] — Lista grup z wyszukiwarką.

### 4.3. Tworzenie grupy (CREATE — użytkownik zalogowany) — (Osoba 1)

Ścieżka: formularz na liście grup → `POST /groups`

- Nazwa grupy (wymagana, max 255 znaków, **unikalna** — nazwy nie mogą się powtarzać).
- Opis (opcjonalny, max 1000 znaków).

Po utworzeniu twórca grupy zostaje automatycznie jej właścicielem i pierwszym członkiem (`owner_id` ustawiane z `Auth::id()` — użytkownik nie wpisuje ID ręcznie).

Walidacja po stronie klienta: atrybuty HTML5 `required`, `maxlength`.
Walidacja po stronie serwera (Laravel): `required`, `unique:groups,name`, `max` — błędy wyświetlane przy formularzu z polskimi komunikatami.

> [Miejsce na Rys. 3] — Formularz tworzenia grupy.

### 4.4. Szczegóły grupy — rachunki, salda i rozliczenia (READ) — (Osoba 2)

Ścieżka: karta grupy → `/groups/{id}`

Na stronie grupy znajdują się:
- lista uczestników i przycisk dodania użytkownika po e-mailu,
- lista rachunków (stronicowana, 5 na stronę) z filtrowaniem po opisie, płatniku oraz zakresie kwoty,
- formularz dodania rachunku oraz formularz dodania pozycji z paragonu,
- panel **salda** każdego uczestnika (zapłacone − należne),
- **plan rozliczeń** (kto, komu i ile powinien przelać),
- **statystyki wydatków** (bieżący miesiąc, ostatnie 30 dni, najwyższy i średni rachunek, liczba rachunków, liczba aktywnych członków).

Dostęp ma tylko członek grupy lub administrator (w przeciwnym razie HTTP 403).

> [Miejsce na Rys. 4] — Strona grupy: rachunki, salda i plan rozliczeń.

### 4.5. Dodawanie rachunku i pozycji z paragonu — (Osoba 2)

**Dodanie rachunku** (`POST /groups/{group}/bills`):
- Opis wydatku (wymagany, max 255 znaków; nie może składać się z samych cyfr).
- Kwota (wymagana, liczba, min. 0,01 — kwota ujemna i zero są odrzucane).
- Płatnik (wymagany, musi być członkiem grupy).

Po zapisaniu rachunku koszt jest **automatycznie dzielony po równo** między wszystkich członków grupy (reszta groszowa rozdzielana deterministycznie), a udział płatnika oznaczany jest jako opłacony.

**Dodanie pozycji z paragonu** (`POST /groups/{group}/bills/{bill}/items`):
- Nazwa pozycji (wymagana), cena (min. 0,01), liczba sztuk (liczba całkowita, min. 1).
- Po dodaniu pozycji podział kosztu rachunku jest **automatycznie przeliczany** na podstawie sumy pozycji.

> [Miejsce na Rys. 5] — Formularz dodawania rachunku / pozycji z paragonu.

### 4.6. Edycja i usuwanie grupy (UPDATE / DELETE) — (Osoba 1)

- Edycja grupy (`/groups/{id}/edit`) — dostępna dla właściciela lub administratora; zmienia nazwę i opis (z walidacją unikalności).
- Usunięcie grupy (`DELETE /groups/{id}`) — dostępne dla właściciela lub administratora; kasuje grupę wraz z powiązanymi rachunkami (kaskadowo).
- Usunięcie rachunku (`DELETE /groups/{group}/bills/{bill}`) — dostępne dla członków grupy.

### 4.7. Publiczny katalog grup — (Osoba 1)

Ścieżka: **Katalog grup** → `/katalog-grup`

Katalog (dla zalogowanych) pokazuje wszystkie grupy w siatce kart z:
- wyszukiwaniem po nazwie/opisie,
- filtrem minimalnej sumy wydatków oraz minimalnej liczby członków,
- sortowaniem (najnowsze, najstarsze, nazwa A–Z / Z–A, suma malejąco, liczba członków malejąco).

Widok szczegółów katalogu (`/katalog-grup/{group}`) prezentuje salda i plan rozliczeń w trybie tylko do odczytu.

> [Miejsce na Rys. 6] — Publiczny katalog grup z filtrami i sortowaniem.

### 4.8. Role w systemie — (Osoba 1)

| Rola | Możliwości |
|------|------------|
| Użytkownik | Tworzenie grup, dodawanie rachunków i pozycji, zarządzanie własnymi grupami, podgląd sald, planu rozliczeń i statystyk, przeglądanie katalogu. |
| Administrator | Wszystko co użytkownik + dostęp do wszystkich grup, panel administratora (zarządzanie kontami i rolami). |

### 4.9. Przypadki brzegowe (walidacja) — (Osoba 1 + Osoba 2)

- Kwota ujemna lub zero — odrzucana regułą `min:0.01`.
- Pusty opis rachunku — błąd „Podaj nazwę wydatku".
- Opis rachunku z samych cyfr — odrzucany regułą niestandardową.
- Płatnik spoza grupy — odrzucany regułą `exists` na tabeli `group_user`.
- Duplikat nazwy grupy — odrzucany regułą `unique:groups,name`.
- Próba wejścia do cudzej grupy — HTTP 403 (`authorizeGroupAccess`).
- Próba edycji/usunięcia cudzej grupy — HTTP 403 (`authorizeGroupOwnerOrAdmin`).
- Administrator nie może odebrać sobie roli admina ani usunąć własnego konta.

### 4.10. Responsywność — (Osoba 1 + Osoba 2)

Layout wykorzystuje Tailwind CSS (breakpointy `sm`, `md`, `lg`). Karty grup wyświetlają się w siatce 1/2/3 kolumn zależnie od szerokości ekranu, a formularze przechodzą z układu wielokolumnowego na jednokolumnowy na wąskich ekranach. Dostępny jest przełącznik motywu jasny/ciemny (Alpine.js + localStorage).

> [Miejsce na Rys. 7] — Widok responsywny (symulacja mobile w DevTools).

---

## 5. Udokumentowany CRUD — zasób Grupa (Group) — (Osoba 1)

Relacje: `User belongsToMany Group` (przez tabelę `group_user`) oraz `User hasMany Group` jako właściciel (`owner_id`). Dodatkowo `Group hasMany Bill`, a `Bill hasMany BillItem` oraz `Bill hasMany BillSplit`.

| Operacja | Kto | Endpoint / widok | Opis |
|----------|-----|------------------|------|
| CREATE | Zalogowany użytkownik | `POST /groups` | Formularz nazwa + opis, walidacja serwer+klient, unikalna nazwa |
| READ (lista) | Zalogowany (admin: wszystkie) | `GET /groups` | Lista z wyszukiwaniem i stronicowaniem |
| READ (szczegóły) | Członek lub admin | `GET /groups/{id}` | Rachunki, salda, plan rozliczeń, statystyki |
| READ (katalog) | Zalogowany | `GET /katalog-grup` | Publiczny katalog z filtrami i sortowaniem |
| UPDATE | Właściciel lub admin | `PUT /groups/{id}` | Edycja nazwy i opisu |
| DELETE | Właściciel lub admin | `DELETE /groups/{id}` | Usunięcie grupy z rachunkami (kaskada) |

### 5.1. CREATE — szczegóły formularza

Mapowanie relacji: `owner_id` ustawiane automatycznie z `Auth::id()`. Po utworzeniu twórca jest dopisywany do tabeli `group_user` metodą `syncWithoutDetaching()`, więc od razu staje się członkiem grupy.

### 5.2. READ — filtrowanie i sortowanie

- **Moje grupy** (`GroupController@index`): zwykły użytkownik widzi tylko swoje grupy (`Auth::user()->groups()`), admin — wszystkie. Wyszukiwanie po nazwie/opisie, dla admina też po właścicielu.
- **Katalog** (`PublicGroupController@index`): filtry (fraza, min. suma, min. liczba członków) i 6 trybów sortowania realizowanych wyrażeniem `match`.

### 5.3. UPDATE / DELETE — walidacja i autoryzacja

Edycja używa tej samej reguły unikalności nazwy co CREATE, z wyłączeniem bieżącego rekordu (`Rule::unique(...)->ignore($group->id)`). Operacje UPDATE i DELETE wymagają roli właściciela lub administratora (`authorizeGroupOwnerOrAdmin`). Usunięcie korzysta z metody `DELETE` (formularz z `@method('DELETE')` i tokenem CSRF).

---

## 6. Role, uprawnienia i zarządzanie — (Osoba 1)

### 6.1. Role użytkowników

Kolumna `role` w tabeli `users` (wartości `user` / `admin`, domyślnie `user`). Metoda pomocnicza `User::isAdmin()`.

### 6.2. Uprawnienia

- Middleware `auth` + `verified` — wszystkie trasy zasobów (grupy, rachunki, katalog, profil).
- Middleware `admin` (`AdminMiddleware`) — sekcja `/admin/*`.
- `authorizeGroupAccess()` — wejście do grupy/rachunków tylko dla członka lub admina.
- `authorizeGroupOwnerOrAdmin()` — edycja/usuwanie grupy tylko dla właściciela lub admina.

### 6.3. Zarządzanie zasobami przez użytkownika

Użytkownik zarządza swoimi grupami (tworzy, edytuje, usuwa), dodaje uczestników po e-mailu, zapisuje rachunki i pozycje z paragonu oraz przegląda salda, plan rozliczeń i statystyki.

### 6.4. Zarządzanie profilami przez administratora

`/admin/users` — lista użytkowników z wyszukiwaniem i filtrem roli oraz statystykami (liczba kont, adminów, grup, rachunków). Administrator może:
- zmienić imię i rolę użytkownika (`PATCH /admin/users/{user}`),
- usunąć konto (`DELETE /admin/users/{user}`).

Zabezpieczenia: admin nie może odebrać sobie roli admina ani usunąć własnego konta.

---

## 7. Logika biznesowa wykraczająca poza prosty CRUD — (Osoba 2)

### 7.1. Plan rozliczeń minimalizujący liczbę przelewów

Metoda `Group::getSettlementPlan()` wylicza salda wszystkich członków (zapłacone − należne), dzieli ich na wierzycieli i dłużników, a następnie iteracyjnie dopasowuje największego dłużnika do największego wierzyciela, tworząc minimalny zestaw przelewów zamykających długi. Obliczenia prowadzone są w groszach (liczby całkowite), aby uniknąć błędów zaokrągleń.

### 7.2. Automatyczne dzielenie kosztów (`BillSplitService`)

- `createInitialEqualSplit()` — po dodaniu rachunku dzieli kwotę **po równo** między członków, deterministycznie rozdzielając groszową resztę.
- `recalculateFromItems()` — po dodaniu pozycji z paragonu **przelicza** podział na podstawie sumy pozycji; jeśli pozycje nie pokrywają całej kwoty rachunku, brakująca część jest dodatkowo dzielona po równo, a nadwyżka — proporcjonalnie skalowana do kwoty rachunku.

### 7.3. Statystyki wydatków grupy

`GroupController@show` agreguje dane: suma wydatków w bieżącym miesiącu, suma z ostatnich 30 dni, najwyższy i średni rachunek, liczba rachunków oraz liczba aktywnych członków.

### 7.4. Automatyczne saldo grupy

Suma wydatków grupy (`groups.total_amount`) aktualizowana jest automatycznie: na MySQL przez **triggery** (INSERT/UPDATE/DELETE na tabeli `bills`), a na SQLite przez logikę PHP (`increment`/`decrement`) w kontrolerze rachunków — dzięki czemu aplikacja działa spójnie na obu silnikach.

### 7.5. Walidacja przynależności do grupy

Na MySQL trigger `validate_user_in_group_before_item_assign` blokuje przypisanie do pozycji paragonu osoby spoza grupy, a funkcja składowa `get_user_net_balance()` liczy saldo netto w bazie. Na SQLite tę samą rolę pełni walidacja w kontrolerach i obliczenia w PHP.

---

## 8. Przechowywane dane — (Osoba 1 + Osoba 2)

W kolumnie „Autor" oznaczono osobę odpowiedzialną za daną tabelę.

| Tabela | Kluczowe pola | Opis | Autor |
|--------|---------------|------|-------|
| `users` | name, email, password, role | Konta użytkowników i ich role | Osoba 1 |
| `groups` | name, description, owner_id, total_amount | Grupy rozliczeniowe (nazwa unikalna) | Osoba 1 |
| `group_user` | group_id, user_id | Członkostwo w grupach (para unikalna) | Osoba 1 |
| `bills` | group_id, payer_id, description, amount, date | Rachunki (kto zapłacił i ile) | Osoba 2 |
| `bill_items` | bill_id, name, price, quantity | Pozycje z paragonu | Osoba 2 |
| `bill_item_user` | bill_item_id, user_id | Przypisanie pozycji do osób | Osoba 2 |
| `bill_splits` | bill_id, user_id, amount, is_paid | Podział kosztu rachunku na osoby | Osoba 2 |

---

## 9. Plany rozbudowy (v2.0) — (Osoba 1 + Osoba 2)

### 9.1. Czego brakuje w v1.0

- Ręczny wybór sposobu podziału rachunku (nierówny, procentowy).
- Powiadomienia e-mail o nowych rachunkach i rozliczeniach.
- Oznaczanie przelewów jako wykonanych (rozliczanie sald).

### 9.2. Potencjalne v2.0

- Eksport rozliczeń do PDF/CSV.
- Obsługa wielu walut i przeliczanie kursów.
- Wgrywanie zdjęcia paragonu i odczyt pozycji (OCR).
- Wdrożenie produkcyjne na MySQL z aktywnymi triggerami i funkcją SQL.

### 9.3. Optymalizacje

- Indeksy DB na `bills.date`, `bills.payer_id` dla szybszego filtrowania.
- Cache statystyk i list katalogu (Redis).
- Kolejka (queue) do wysyłki powiadomień.
