# Sebranka Praha – Webová aplikace

## 🚀 Deploy status

- **Staging (`structure`)**  
  [![Deploy (structure)](https://github.com/honzalez/sbp/actions/workflows/deploy.yml/badge.svg?branch=structure)](https://github.com/honzalez/sbp/actions/workflows/deploy.yml?query=branch:structure)

- **Production (`main`)**  
  [![Deploy (main)](https://github.com/honzalez/sbp/actions/workflows/deploy.yml/badge.svg?branch=main)](https://github.com/honzalez/sbp/actions/workflows/deploy.yml?query=branch:main)


Oficiální repozitář webové aplikace hokejového týmu **Sebranka Praha**.  
Projekt je psaný v PHP 8+ s využitím HTML5, CSS3 a MySQL/MariaDB.

---

## 📌 Funkce projektu
- Správa uživatelů (admin / editor / user).
- Evidence zápasů, hráčů a statistik.
- Přihlašování, registrace a správa profilu.
- Upload obrázků (hráči, sponzoři, týmové materiály).
- Podpora vícejazyčných textů a responzivního designu.
- Synchronizace dat s Google Sheets (plánováno).

---

## 🛠 Použité technologie
- **Backend:** PHP 8+
- **Databáze:** MySQL / MariaDB
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Další:** Git, GitHub, VS Code

---

## 🚀 Lokální spuštění

1. Naklonuj repozitář:
   ```bash
   git clone https://github.com/honzalez/sbp.git
   cd sbp

    Přepni se na pracovní větev (např. structure):

git checkout structure

Vytvoř soubor konfigurace databáze:

cp config/config.php.example config/config.php

→ uprav podle svých údajů (DB host, user, password).

Spusť lokální PHP server:

    php -S localhost:8000

    a otevři http://localhost:8000.

## 📂 Struktura projektu

Projekt je rozdělen do následujících složek a souborů:

```text
.
├── CHANGELOG.md         # přehled změn v projektu
├── README.md            # dokumentace projektu
├── index.php            # hlavní stránka webu
├── about.php            # stránka "O nás"
├── login.php            # přihlášení uživatele
├── logout.php           # odhlášení uživatele
├── register.php         # registrace nového uživatele
├── profile.php          # uživatelský profil
├── roster.php           # soupisky hráčů
├── lineup.php           # sestavy pro zápasy
├── matches.php          # přehled zápasů
├── soupiska_match.php   # detailní soupiska konkrétního zápasu
├── stats.php            # týmové a hráčské statistiky
│
├── admin/               # administrační rozhraní (uživatelé, hráči, zápasy, nastavení)
│   ├── admin_menu.php   # menu administrace
│   ├── approve_role.php # schvalování rolí
│   ├── lineup_edit.php  # editace sestavy
│   ├── lineup_save.php  # uložení sestavy
│   ├── match_add.php    # přidání zápasu
│   ├── match_delete.php # smazání zápasu
│   ├── match_edit.php   # úprava zápasu
│   ├── match_list.php   # seznam zápasů
│   ├── media_upload.php # nahrávání médií
│   ├── news.php         # správa novinek
│   ├── player_add.php   # přidání hráče
│   ├── player_delete.php# smazání hráče
│   ├── player_edit.php  # úprava hráče
│   ├── player_list.php  # seznam hráčů
│   ├── requests.php     # požadavky uživatelů
│   ├── roster.php       # správa soupisek v adminu
│   ├── settings.php     # nastavení aplikace
│   ├── sponsors.php     # správa sponzorů
│   ├── user_add.php     # přidání uživatele
│   ├── user_delete.php  # smazání uživatele
│   ├── user_edit.php    # úprava uživatele
│   └── user_list.php    # seznam uživatelů
│
├── api/                 # API endpointy (budoucí rozšíření) – prázdné, .gitkeep
├── assets/              # statické soubory (obrázky, fonty, …) – prázdné, .gitkeep
├── config/              # konfigurace aplikace
│   ├── config.php       # hlavní konfigurace (ignorováno v gitu)
│   ├── config.php.example # ukázková konfigurace pro nasazení
│   ├── uc.php
│   └── usercreate.php
├── core/                # jádro aplikace – prázdné, .gitkeep
│
├── css/                 # kaskádové styly
│   ├── body.css
│   ├── cards.css
│   ├── footer.css
│   ├── menu.css
│   ├── responsive.css
│   ├── sponsors.css
│   ├── style.css
│   ├── backup/          # záložní styly – prázdné, .gitkeep
│   └── modules/         # CSS moduly – prázdné, .gitkeep
│
├── includes/            # společné části webu
│   ├── auth_check.php   # kontrola přihlášení
│   ├── footer.php       # patička stránky
│   └── header.php       # hlavička stránky
│
├── js/                  # JavaScript
│   └── main.js
│
├── logo/                # loga a favicon
│   ├── favicon.ico
│   ├── sebranka-lebkoun-01.svg
│   ├── sebranka-logo-01.svg
│   └── sebranka-napis-01.svg
│
├── old/                 # staré soubory a zálohy (prozatím uchováváno)
│   ├── about-old.php
│   ├── index-old.php
│   ├── main-old.js
│   ├── style-backup.css
│   ├── style-cervena.css
│   ├── style202505302311.css
│   ├── style20250531.css
│   ├── styleachjo.css
│   └── stylexx.css
│
├── scripts/             # pomocné skripty – prázdné, .gitkeep
├── uploads/             # nahrané soubory
│   ├── avatars/         # uživatelské a hráčské avatary
│   │   ├── players/
│   │   └── users/
│   ├── htaccess/        # bezpečnostní nebo upload pravidla
│   ├── matches/         # soubory k zápasům
│   │   └── 0_test/
│   │       ├── gallery/ # galerie zápasu (prázdné, .gitkeep)
│   │       └── video/   # videa ze zápasu (prázdné, .gitkeep)
│   ├── news/            # obrázky k novinkám
│   ├── sponsors/        # loga sponzorů
│   ├── team/            # týmové materiály
│   │   ├── misc/
│   │   └── promo/
│   └── temp/            # dočasné soubory
│
└── struktura.txt        # export stromu projektu (aktuální)


    ⚠️ Poznámka: .gitkeep soubory jsou používány k uchování prázdných složek v repozitáři.
    Obsah složky uploads/ je verzován pouze částečně (přes .gitignore), aby se do gitu nedostaly nahrané soubory, ale zůstala adresářová struktura.

📖 Konvence

    Commit message: používej popisné zprávy (např. Add player edit form, Fix login bug).

    Branching: nové funkce vyvíjej v samostatných větvích (např. feature/login, fix/navbar).

    Code style: drž se PSR-12 standardu pro PHP a jednotného formátu CSS/JS.

📌 TODO / Plán

Přidat REST API pro statistiky.

Propojení s Google Sheets API.

Nasazení CI/CD workflow.

Přidat unit testy (PHPUnit).

    Vyřešit optimalizaci obrázků v uploads/.

👥 Autoři

    Sebranka Praha tým – vývoj a správa.

    Kontakt: info@sebrankapraha.cz
    EOF