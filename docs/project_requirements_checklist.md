# Weryfikacja wymagan projektu (Aplikacje Internetowe 2025/2026)

Punkt odniesienia: <https://ia.lazysolutions.pl/project_requirements.html>

## Pokrycie wymagan funkcjonalnych

### Ocena 3.0
- [x] CRUD zasobu `groups` (tworzenie, lista, edycja, usuwanie) z walidacja po stronie serwera i klienta.
- [x] Relacje miedzy zasobami (`groups`, `bills`, `bill_items`, `users`).
- [x] Panel administratora do zarzadzania kontami i rolami.
- [x] Lista zasobow z filtrowaniem i sortowaniem (`groups.index`, `groups.show`, `admin.users.index`).

### Ocena 4.0
- [x] Rozroznienie rol `admin` oraz `user` (middleware `admin`, role w modelu `User`).
- [x] Zarzadzanie wlasnymi zasobami przez uzytkownika (kontrola dostepu w `GroupController` i kontrolerach rachunkow).
- [x] Zarzadzanie profilami i rolami przez administratora (`Admin\UserController`).
- [x] Dostep publiczny read-only dla niezalogowanych:
  - `GET /katalog-grup`
  - `GET /katalog-grup/{group}`

### Ocena 5.0
- [x] Dodatkowa logika biznesowa: algorytm propozycji splat minimalizujacy liczbe przelewow (`Group::getSettlementPlan()`).
- [x] Dodatkowa logika biznesowa: automatyczne przeliczanie podzialu kosztu rachunku na podstawie pozycji paragonu (`BillSplitService`).
- [x] Funkcje dla uzytkownika koncowego ponad CRUD:
  - statystyki wydatkow w grupie,
  - publiczny katalog grup,
  - automatyczne podpowiedzi rozliczen.

## Warstwa UI / UX
- [x] Motyw glamour (gradientowe sekcje, karty, delikatne akcenty kolorystyczne) w layoutach i kluczowych widokach.

## Uwaga organizacyjna
- Pytania egzaminacyjne z dokumentu (sekcja "Pytania do projektu") wymagaja przygotowania odpowiedzi opisowych i sa poza zakresem samej implementacji kodu.
