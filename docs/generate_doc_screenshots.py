from pathlib import Path

from PIL import Image, ImageDraw, ImageFont


OUT_DIR = Path("/workspace/docs/screenshots")


def load_font(size: int, bold: bool = False):
    try:
        name = "DejaVuSans-Bold.ttf" if bold else "DejaVuSans.ttf"
        return ImageFont.truetype(name, size)
    except OSError:
        return ImageFont.load_default()


def draw_window(draw: ImageDraw.ImageDraw, width: int, height: int, title: str) -> None:
    draw.rounded_rectangle([(8, 8), (width - 8, height - 8)], radius=24, fill=(248, 250, 252), outline=(203, 213, 225), width=2)
    draw.rounded_rectangle([(8, 8), (width - 8, 52)], radius=24, fill=(30, 41, 59), outline=(30, 41, 59))
    draw.rectangle([(8, 32), (width - 8, 52)], fill=(30, 41, 59))
    draw.text((28, 19), title, font=load_font(18, bold=True), fill=(241, 245, 249))


def draw_card(draw: ImageDraw.ImageDraw, x: int, y: int, w: int, h: int, title: str, subtitle: str = "") -> None:
    draw.rounded_rectangle([(x, y), (x + w, y + h)], radius=16, fill=(255, 255, 255), outline=(226, 232, 240), width=2)
    draw.text((x + 16, y + 14), title, font=load_font(17, bold=True), fill=(15, 23, 42))
    if subtitle:
        draw.text((x + 16, y + 44), subtitle, font=load_font(13), fill=(71, 85, 105))


def save_dashboard() -> None:
    w, h = 1360, 760
    img = Image.new("RGB", (w, h), (245, 243, 255))
    d = ImageDraw.Draw(img)
    draw_window(d, w, h, "BillsBuddy — Dashboard")
    draw_card(d, 36, 86, 640, 180, "Panel główny", "Podsumowanie grup i wydatków")
    draw_card(d, 702, 86, 620, 180, "Kafle statystyk", "Grupy • Użytkownicy • Wydatki")
    draw_card(d, 36, 286, 1286, 212, "Szybki start", "1. Utwórz grupę  2. Dodaj członków  3. Dodaj rachunki")
    draw_card(d, 36, 520, 1286, 202, "Nawigacja", "Dostęp do katalogu publicznego i pytań IA")
    img.save(OUT_DIR / "screen_01_dashboard.png")


def save_groups_crud() -> None:
    w, h = 1360, 760
    img = Image.new("RGB", (w, h), (245, 243, 255))
    d = ImageDraw.Draw(img)
    draw_window(d, w, h, "BillsBuddy — Moje grupy (CRUD)")
    draw_card(d, 36, 86, 540, 280, "CREATE: Formularz grupy", "Nazwa, opis + walidacja serwer/klient")
    draw_card(d, 596, 86, 726, 152, "READ: Filtry", "Szukaj po nazwie/opisie, właściciel, paginacja")
    draw_card(d, 596, 258, 726, 108, "UPDATE/DELETE", "Przyciski Edytuj i Usuń z autoryzacją")
    draw_card(d, 36, 386, 1286, 336, "Lista grup", "Relacja owner -> group + statystyki użytkowników i wydatków")
    img.save(OUT_DIR / "screen_02_groups_crud.png")


def save_admin_panel() -> None:
    w, h = 1360, 760
    img = Image.new("RGB", (w, h), (245, 243, 255))
    d = ImageDraw.Draw(img)
    draw_window(d, w, h, "BillsBuddy — Panel administratora")
    draw_card(d, 36, 86, 1286, 130, "Role i uprawnienia", "Filtry użytkowników, zmiana roli user/admin, usuwanie kont")
    draw_card(d, 36, 236, 1286, 486, "Zarządzanie profilami", "Admin edytuje dane użytkownika i kontroluje dostęp do zasobów")
    img.save(OUT_DIR / "screen_03_admin_panel.png")


def save_settlement() -> None:
    w, h = 1360, 760
    img = Image.new("RGB", (w, h), (245, 243, 255))
    d = ImageDraw.Draw(img)
    draw_window(d, w, h, "BillsBuddy — Rozliczenia i bilans")
    draw_card(d, 36, 86, 430, 304, "Bilans grupy", "Do odzyskania / Do oddania + suma wydatków")
    draw_card(d, 486, 86, 836, 206, "Kto ile oddaje", "Czytelny komunikat: X oddaje Y PLN dla Z")
    draw_card(d, 486, 312, 836, 410, "Pozycje z paragonu", "Automatyczny podział i przeliczenie sald")
    draw_card(d, 36, 410, 430, 312, "Szybkie statystyki", "Miesiąc, 30 dni, max i średnia")
    img.save(OUT_DIR / "screen_04_settlement.png")


def save_public_catalog() -> None:
    w, h = 1360, 760
    img = Image.new("RGB", (w, h), (245, 243, 255))
    d = ImageDraw.Draw(img)
    draw_window(d, w, h, "BillsBuddy — Katalog publiczny")
    draw_card(d, 36, 86, 1286, 138, "Dostęp niezalogowanego", "Przeglądanie grup w trybie read-only (bez edycji i usuwania)")
    draw_card(d, 36, 244, 1286, 140, "Filtrowanie i sortowanie", "Nazwa, minimalna kwota, liczba członków, sortowanie")
    draw_card(d, 36, 404, 1286, 318, "Karty grup", "Widok szczegółów, statystyki, właściciel, łączna kwota")
    img.save(OUT_DIR / "screen_05_public_catalog.png")


def save_mobile() -> None:
    w, h = 540, 960
    img = Image.new("RGB", (w, h), (245, 243, 255))
    d = ImageDraw.Draw(img)
    draw_window(d, w, h, "BillsBuddy — Mobile")
    draw_card(d, 22, 86, 496, 156, "Menu mobilne", "Start, Katalog grup, Pytania IA")
    draw_card(d, 22, 262, 496, 220, "Formularz wydatku", "Nazwa • Kwota • Płatnik")
    draw_card(d, 22, 502, 496, 438, "Historia rozliczeń", "RWD: karty i sekcje w układzie pionowym")
    img.save(OUT_DIR / "screen_06_mobile_view.png")


if __name__ == "__main__":
    OUT_DIR.mkdir(parents=True, exist_ok=True)
    save_dashboard()
    save_groups_crud()
    save_admin_panel()
    save_settlement()
    save_public_catalog()
    save_mobile()
    print(f"Wygenerowano zrzuty dokumentacyjne w: {OUT_DIR}")
