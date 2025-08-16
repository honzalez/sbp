# SBP – web HC Sebranka Praha

webová stránka amaterského hokejového klubu

## Požadavky
- PHP 8.1+
- (Volitelně) Composer, MySQL/MariaDB
- hosting: wedos
- test

## Lokální start (příklad)
```bash
php -S 127.0.0.1:8000 -t public
```

Ověření ochrany větve a CI

Test bad PR title


# 🏒 Sebranka Praha – Webový systém

Oficiální webový systém hokejového týmu **Sebranka Praha**.  
Projekt zahrnuje veřejnou prezentaci týmu a administraci pro správu obsahu.

---

## 📌 Funkce projektu

### Veřejná část
- Zobrazení novinek, zápasů, výsledků a statistik.
- Soupiska hráčů a realizačního týmu.
- Galerie momentek a promo obrázků.
- Kontaktní stránka, sekce sponzorů a partnerů.

### Administrace
- Přihlášení uživatelů (role: admin, editor, hráč).
- Správa hráčů, zápasů, statistik a galerií.
- Nahrávání médií (obrázky, promo bannery, momentky).
- Možnost propojení s Instagramem a dalšími externími zdroji.

---

## 📂 Struktura projektu

/admin - Administrace webu
/config - Konfigurační soubory (DB připojení, nastavení)
/css - Kaskádové styly (style.css, responzivní úpravy)
/fonts - Používané fonty
/img - Obrázky rozhraní a loga
/includes - Společné části webu (header, footer, navigace)
/js - JavaScript (hlavní skripty, hamburger menu)
/logo - Logo a grafické varianty
/uploads - Uploadované soubory (fotky, momentky, bannery)
/media - Alternativní adresář pro média (bude sjednoceno s uploads)
/sql - SQL exporty
index.php - Hlavní vstupní stránka
about.php - O týmu
matches.php - Přehled zápasů
roster.php - Soupiska
login.php - Přihlášení
logout.php - Odhlášení
README.md - Tento soubor
struktura.txt - Export stromové struktury


---

## 🗑️ Testovací / nepoužívané soubory
> Označeno podle obsahu a názvů – nutno ověřit před smazáním.

- `admin/test.php` – pravděpodobně testovací script.
- `upload_test.php` – zkušební upload obrázků.
- `gallery_old.php` – stará verze galerie.
- `matches_old.php` – stará verze seznamu zápasů.
- `roster_old.php` – stará verze soupisky.
- `config/config_old.php` – stará konfigurace.
- `temp/` (celý adresář) – dočasné soubory.

---

## 🛠️ Instalace a spuštění

1. **Naklonuj repozitář**:
   ```bash
   git clone https://github.com/honzalez/sbp.git

    Vytvoř databázi a naimportuj SQL z /sql/.

    Uprav připojení k DB v config/config.php:

    $conn = new mysqli('localhost', 'uzivatel', 'heslo', 'nazev_db');

    Nahraj projekt na server (např. Wedos, Apache + PHP 8+).

👤 Autor

    Honza Gonzalez – hlavní vývoj a správa

    Další přispěvatelé vítáni


----

Chceš, abych ti **hned teď** k tomu připravil i **seznam všech PHP souborů, které by bylo dobré přesunout do `/archive`**, aby se to nepletlo?  
Tím bychom hned začali čistit repozitář.