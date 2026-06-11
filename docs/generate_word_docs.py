from datetime import date

from docx import Document


PROJECT_NAME = "BillsBuddy"
REPO_URL = "https://github.com/Dudzinska/Wydatki-app.git"


TECH_ROWS = [
    ("PHP", "8.2.x", "https://www.php.net/"),
    ("Laravel", "12.59.0", "https://laravel.com/"),
    ("Node.js", "v22.x", "https://nodejs.org/"),
    ("npm", "10.x", "https://www.npmjs.com/"),
    ("Vite", "7.3.3", "https://vitejs.dev/"),
    ("Tailwind CSS", "3.x", "https://tailwindcss.com/"),
    ("Composer", "2.x", "https://getcomposer.org/"),
    ("Baza danych (dev)", "SQLite 3", "https://www.sqlite.org/"),
    ("Baza danych (opcjonalnie)", "MySQL 8.0+", "https://www.mysql.com/"),
]


def add_heading(doc: Document, text: str, level: int = 1) -> None:
    doc.add_heading(text, level=level)


def add_bullets(doc: Document, items: list[str]) -> None:
    for item in items:
        doc.add_paragraph(item, style="List Bullet")


def add_numbered(doc: Document, items: list[str]) -> None:
    for item in items:
        doc.add_paragraph(item, style="List Number")


def add_tech_table(doc: Document) -> None:
    table = doc.add_table(rows=1, cols=3)
    table.style = "Light List Accent 1"
    hdr = table.rows[0].cells
    hdr[0].text = "Technologia"
    hdr[1].text = "Wersja"
    hdr[2].text = "Oficjalna strona"
    for name, version, url in TECH_ROWS:
        row = table.add_row().cells
        row[0].text = name
        row[1].text = version
        row[2].text = url


def add_common_developer_section(doc: Document) -> None:
    add_heading(doc, "Uruchomienie projektu (developer)", level=2)
    doc.add_paragraph(
        "Poniżej znajduje się konfiguracja użyta w projekcie. "
        "Wymagania przedmiotowe z dokumentu IA wskazują PHP 8.5 i Laravel 13, "
        "natomiast bieżący stan repozytorium działa na PHP 8.2 i Laravel 12.59.0."
    )
    add_tech_table(doc)

    add_heading(doc, "Wymagania programowe", level=3)
    add_bullets(
        doc,
        [
            "System operacyjny: Windows 10/11, Linux lub macOS.",
            "PHP 8.2+ z rozszerzeniami wymaganymi przez Laravel.",
            "Composer 2.x.",
            "Node.js v22+ oraz npm 10+.",
            "SQLite 3 (domyślnie) lub MySQL 8.0+.",
            "Git do pobrania repozytorium.",
        ],
    )

    add_heading(doc, "Proces instalacji", level=3)
    add_numbered(
        doc,
        [
            f"Pobierz projekt: git clone {REPO_URL}",
            "Przejdź do katalogu projektu: cd Wydatki-app",
            "Zainstaluj zależności backendu: composer install",
            "Zainstaluj zależności frontendu: npm install",
        ],
    )

    add_heading(doc, "Proces konfiguracji", level=3)
    add_numbered(
        doc,
        [
            "Utwórz plik środowiskowy: skopiuj .env.example do .env",
            "Wygeneruj klucz aplikacji: php artisan key:generate",
            "Utwórz plik bazy SQLite: database/database.sqlite",
            "Wykonaj migracje i seedy: php artisan migrate:fresh --seed",
            "Uruchom frontend: npm run dev",
            "Uruchom backend: php artisan serve",
        ],
    )
    doc.add_paragraph("Aplikacja lokalnie: http://127.0.0.1:8000")


def add_common_user_run_section(doc: Document) -> None:
    add_heading(doc, "Uruchomienie projektu (user)", level=2)
    doc.add_paragraph(
        "Aktualnie projekt jest przygotowany do uruchamiania lokalnego. "
        "Brak publicznego wdrożenia produkcyjnego w momencie tworzenia dokumentacji."
    )
    add_bullets(
        doc,
        [
            "Wymagania sprzętowe: standardowy komputer (8 GB RAM rekomendowane).",
            "Przeglądarka: Chrome/Edge/Firefox (aktualna wersja).",
            "Użytkownik końcowy korzysta z aplikacji przez przeglądarkę po uruchomieniu lokalnym.",
        ],
    )


def build_doc_person_1(path: str) -> None:
    doc = Document()
    doc.add_heading(f"{PROJECT_NAME} – Dokumentacja projektowa (Osoba 1)", 0)
    doc.add_paragraph(f"Data opracowania: {date.today().isoformat()}")
    doc.add_paragraph("Autor: Osoba 1 (zakres: role, uprawnienia, panel administratora, CRUD grup).")

    add_heading(doc, "Temat projektu", level=2)
    doc.add_paragraph(
        "BillsBuddy to aplikacja webowa do rozliczania wspólnych wydatków w grupach "
        "(np. wyjazdy, mieszkanie, wydarzenia). Głównym celem jest uproszczenie kontroli "
        "nad tym, kto zapłacił i kto komu powinien oddać pieniądze."
    )
    add_bullets(
        doc,
        [
            "Problem, który rozwiązuje aplikacja: ręczne rozliczenia są nieczytelne i podatne na błędy.",
            "Wyróżnik: połączenie prostego CRUD grup/rachunków z czytelnym podziałem ról i uprawnień.",
            "Nawiązanie do problemu nr 3 z dokumentu IA: rozliczanie wspólnych wydatków.",
        ],
    )

    add_common_developer_section(doc)
    add_common_user_run_section(doc)

    add_heading(doc, "Podręcznik użytkownika (zakres Osoby 1)", level=2)
    add_heading(doc, "Role i uprawnienia (wymaganie 4.0)", level=3)
    add_bullets(
        doc,
        [
            "Rola administratora: dostęp do panelu admina i zarządzania użytkownikami.",
            "Rola użytkownika: zarządzanie własnymi grupami i rachunkami.",
            "Niezalogowany: dostęp tylko do katalogu publicznego (read-only).",
            "Administrator zarządza profilami użytkowników (zmiana roli, edycja, usuwanie kont).",
        ],
    )

    add_heading(doc, "Ścieżki użytkownika (user flow)", level=3)
    add_numbered(
        doc,
        [
            "Logowanie użytkownika.",
            "Wejście do sekcji „Moje grupy”.",
            "Utworzenie grupy i dodanie opisu.",
            "Filtrowanie listy grup po nazwie/opisie/właścicielu.",
            "Edycja lub usunięcie własnej grupy.",
            "Dla administratora: wejście do „Panel admina” i zarządzanie kontami użytkowników.",
        ],
    )

    add_heading(doc, "Przypadki brzegowe obsługiwane przez system", level=3)
    add_bullets(
        doc,
        [
            "Unikalna nazwa grupy (walidacja duplikatów).",
            "Walidacja pól obowiązkowych i formatów (np. e-mail).",
            "Brak dostępu do zasobów nieuprawnionych użytkowników (HTTP 403).",
            "Brak możliwości odebrania sobie roli admina w panelu administratora.",
        ],
    )

    add_heading(doc, "Dane przechowywane i udostępniane", level=3)
    add_bullets(
        doc,
        [
            "Użytkownicy: imię, e-mail, rola, hasło (hash).",
            "Grupy: nazwa, opis, właściciel, członkowie.",
            "Rachunki i pozycje: opis, kwota, płatnik, data.",
        ],
    )

    add_heading(doc, "Responsywność i zrzuty ekranu", level=3)
    add_bullets(
        doc,
        [
            "Rysunek 1: Widok „Moje grupy” (desktop).",
            "Rysunek 2: Widok panelu admina (desktop).",
            "Rysunek 3: Widok mobilny menu i listy grup.",
            "Każdy zrzut powinien mieć podpis opisujący kontekst i akcję użytkownika.",
        ],
    )

    add_heading(doc, "Plany rozbudowy", level=2)
    add_bullets(
        doc,
        [
            "Rozbudowa panelu administratora o historię zmian ról.",
            "Powiadomienia e-mail o zaproszeniu do grupy.",
            "Polityki (Policies/Gates) jako dodatkowa warstwa autoryzacji.",
        ],
    )

    doc.save(path)


def build_doc_person_2(path: str) -> None:
    doc = Document()
    doc.add_heading(f"{PROJECT_NAME} – Dokumentacja projektowa (Osoba 2)", 0)
    doc.add_paragraph(f"Data opracowania: {date.today().isoformat()}")
    doc.add_paragraph("Autor: Osoba 2 (zakres: logika biznesowa rozliczeń, UX, mechanizmy obliczeń).")

    add_heading(doc, "Temat projektu", level=2)
    doc.add_paragraph(
        "BillsBuddy wspiera rozliczanie złożonych wydatków grupowych. "
        "Aplikacja upraszcza pracę użytkownika końcowego przez automatyzację obliczeń "
        "i prezentację prostych komunikatów „kto komu i ile oddaje”."
    )
    add_bullets(
        doc,
        [
            "Rozwiązywany problem: trudność rozliczeń wielu osób i wielu rachunków.",
            "Wyróżnik: automatyczny podział kosztów, bilans, plan spłat minimalizujący liczbę przelewów.",
            "Nawiązanie do problemu nr 3 z dokumentu IA (Splitwise-like, ale dopasowane do projektu).",
        ],
    )

    add_common_developer_section(doc)
    add_common_user_run_section(doc)

    add_heading(doc, "Podręcznik użytkownika (zakres Osoby 2)", level=2)
    add_heading(doc, "Główne ścieżki użytkownika", level=3)
    add_numbered(
        doc,
        [
            "Utwórz grupę i dodaj członków.",
            "Dodaj rachunek: nazwa wydatku, kwota, płatnik.",
            "Dodaj pozycje z paragonu (nazwa, cena, liczba sztuk).",
            "System dzieli pozycje po równo na członków grupy i przelicza salda.",
            "W sekcji „Kto ile oddaje” sprawdź wynik i wykonaj rozliczenie.",
        ],
    )

    add_heading(doc, "Najważniejsze mechanizmy biznesowe (wymaganie 5.0)", level=3)
    add_bullets(
        doc,
        [
            "Domyślny podział nowego rachunku po równo na członków grupy.",
            "Automatyczne przeliczenie po dodaniu pozycji z paragonu.",
            "Jeśli suma pozycji jest mniejsza od kwoty rachunku, różnica dzielona jest po równo.",
            "Jeśli suma pozycji przekracza kwotę rachunku, udziały są skalowane proporcjonalnie.",
            "Plan spłat minimalizujący liczbę przelewów między dłużnikami i wierzycielami.",
        ],
    )

    add_heading(doc, "Przypadki brzegowe", level=3)
    add_bullets(
        doc,
        [
            "Nazwa wydatku nie może składać się wyłącznie z cyfr.",
            "Kwoty ujemne i zero są odrzucane walidacją.",
            "Liczba sztuk pozycji musi być liczbą całkowitą >= 1.",
            "System obsługuje rachunki bez pozycji i z pozycjami częściowymi.",
        ],
    )

    add_heading(doc, "Dane przechowywane przez mechanizm rozliczeń", level=3)
    add_bullets(
        doc,
        [
            "Rachunek: opis, kwota, płatnik, data.",
            "Pozycja rachunku: nazwa, cena, ilość.",
            "Podział (split): użytkownik, kwota udziału, status względem płatnika.",
            "Bilans użytkownika w grupie: zapłacone, należne, saldo końcowe.",
        ],
    )

    add_heading(doc, "Responsywność i zrzuty ekranu", level=3)
    add_bullets(
        doc,
        [
            "Rysunek 1: Dodawanie rachunku i pozycji (desktop).",
            "Rysunek 2: Sekcja „Kto ile oddaje” po przeliczeniu.",
            "Rysunek 3: Widok mobilny listy rachunków i panelu bilansu.",
            "Każde zdjęcie powinno mieć podpis: co widać, jaki był krok i jaki wynik.",
        ],
    )

    add_heading(doc, "Plany rozbudowy", level=2)
    add_bullets(
        doc,
        [
            "Eksport rozliczeń do PDF/CSV.",
            "Historia i statusy spłat (częściowo zapłacone / zapłacone).",
            "Powiadomienia push/e-mail o nowych rachunkach i zmianie salda.",
            "Cache dla cięższych zestawień i raportów.",
        ],
    )

    doc.save(path)


if __name__ == "__main__":
    build_doc_person_1("/workspace/docs/Dokumentacja_BillsBuddy_Osoba_1.docx")
    build_doc_person_2("/workspace/docs/Dokumentacja_BillsBuddy_Osoba_2.docx")
    print("Wygenerowano pliki DOCX w katalogu /workspace/docs")
