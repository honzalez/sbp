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

📂 Struktura projektu

.
├── CHANGELOG.md
├── README.md
├── index.php
├── about.php
├── login.php
├── logout.php
├── register.php
├── profile.php
├── roster.php
├── lineup.php
├── matches.php
├── stats.php
│
├── admin/             # administrace (uživatelé, hráči, zápasy, nastavení)
├── api/               # API endpointy (budoucí rozšíření) – prázdné, .gitkeep
├── assets/            # statické soubory (obrázky, fonty, atd.) – prázdné, .gitkeep
├── config/            # konfigurace aplikace a DB
├── core/              # jádro aplikace – prázdné, .gitkeep
├── css/               # styly
│   ├── body.css
│   ├── cards.css
│   ├── footer.css
│   ├── menu.css
│   ├── responsive.css
│   ├── sponsors.css
│   ├── style.css
│   ├── backup/        # záložní styly – prázdné, .gitkeep
│   └── modules/       # CSS moduly – prázdné, .gitkeep
├── includes/          # společné části webu (header, footer, auth check)
├── js/                # JavaScript soubory
│   └── main.js
├── logo/              # loga a favicon
├── scripts/           # pomocné skripty – prázdné, .gitkeep
├── uploads/           # nahrané soubory (avatars, sponsors, news, team, …)
│   ├── avatars/
│   ├── matches/
│   │   └── 0_test/
│   │       ├── gallery/   # prázdné, .gitkeep
│   │       └── video/     # prázdné, .gitkeep
│   └── temp/
├── old/               # staré soubory a zálohy (dočasně uchováváno)
├── struktura.txt      # export stromu projektu (původní)
└── struktura_new.txt  # export stromu projektu (aktuální)

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