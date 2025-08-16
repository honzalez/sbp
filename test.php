<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sebranka Praha</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Hlavička -->
  <header>
    <div class="logo">Sebranka Praha</div>
    <nav>
      <ul>
        <li><a href="#novinky">Novinky</a></li>
        <li><a href="#tym">Tým</a></li>
        <li><a href="#zapasy">Zápasy</a></li>
        <li><a href="#statistiky">Statistiky</a></li>
        <li><a href="#kontakt">Kontakt</a></li>
      </ul>
    </nav>
  </header>

  <!-- Hlavní obsah -->
  <main>
    <section id="novinky">
      <h2>Novinky</h2>
      <div class="novinky-grid">
        <article class="novinka">Novinka 1</article>
        <article class="novinka">Novinka 2</article>
        <article class="novinka">Novinka 3</article>
      </div>
    </section>

    <section id="tym">
      <h2>Tým</h2>
      <div class="tym-grid">
        <div class="hrac">Hráč 1</div>
        <div class="hrac">Hráč 2</div>
        <div class="hrac">Hráč 3</div>
      </div>
    </section>

    <section id="zapasy">
      <h2>Zápasy</h2>
      <table>
        <thead>
          <tr>
            <th>Datum</th>
            <th>Soupeř</th>
            <th>Výsledek</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>01.09.2025</td>
            <td>Tým A</td>
            <td>3:2</td>
          </tr>
          <tr>
            <td>05.09.2025</td>
            <td>Tým B</td>
            <td>1:4</td>
          </tr>
        </tbody>
      </table>
    </section>

    <section id="statistiky">
      <h2>Statistiky</h2>
      <p>Sem přijdou tabulky a grafy.</p>
    </section>

    <section id="kontakt">
      <h2>Kontakt</h2>
      <form>
        <label for="jmeno">Jméno</label>
        <input type="text" id="jmeno" name="jmeno">

        <label for="email">Email</label>
        <input type="email" id="email" name="email">

        <label for="zprava">Zpráva</label>
        <textarea id="zprava" name="zprava"></textarea>

        <button type="submit">Odeslat</button>
      </form>
    </section>
  </main>

  <!-- Patička -->
  <footer>
    <p>&copy; 2025 Sebranka Praha</p>
  </footer>
</body>
</html>
