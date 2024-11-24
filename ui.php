<?php
session_start();  // Session indítása
?>
<!DOCTYPE html> 
<html lang="hu"> 
    <head>
         <meta charset="UTF-8"> 
         <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
         <title>IMDB Applikáció</title>
          <style> #register, #login { display: none; } </style>
          <link rel="stylesheet" href="styles.css">
          <script src="imdbscript.js"></script>
        </head>
         <body> 
          <div id="ui">
            <header>
                 <h1>Üdvözöllek az ✨<span id="meno">IMDB</span>✨ adatbázisban!</h1>
                 
                 <?php if (isset($_SESSION['username'])): ?>
    
    <p id="greeting">Szia, <?php echo $_SESSION['username']; ?>!</p>
    <button onclick="window.location.href='ui.php'">Főoldal</button>
    <button onclick="document.getElementById('add').style.display='block';">Film/Sorozat felvétele</button>
    <button id="addButton" onclick="toggleForm()">Értékelés</button>
    <button onclick="window.location.href='logout.php'">Kijelentkezés</button>
    
<?php else: ?>
    
    <button onclick="document.getElementById('register').style.display='block'; document.getElementById('login').style.display='none';">Regisztráció</button>
    <button onclick="document.getElementById('login').style.display='block'; document.getElementById('register').style.display='none';">Bejelentkezés</button>
<?php endif; ?>
                </header>
                 <main>
                     <section id="register"> 
                         <h2>Regisztráció</h2> 
                         <form action="/adatbazisprojekt/register.php" method="POST"> 
                              <label for="felhasznalonev" id="loginsigninlabel">Felhasználónév:</label>
                               <input type="text" id="username" name="felhasznalonev" placeholder="Felhasználónév" required> 
                                <label for="password" id="loginsigninlabel">Jelszó:</label>
                                 <input type="password" id="password" name="jelszo" placeholder="Jelszó" required>
                                 <br>
                                  <button type="submit">Regisztráció</button>
                               </form>
                               </section>
                    <section id="login">
                         <h2>Bejelentkezés</h2>
                              <form action="/adatbazisprojekt/login.php" method="POST">
                                   <label for="login-username" id="loginsigninlabel">Felhasználónév:</label> 
                                   <input type="username" id="login-username" name="felhasznalonev" placeholder="Felhasználónév" required>
                                          <label for="login-password" id="loginsigninlabel">Jelszó:</label> 
                                          <input type="password" id="login-password" name="jelszo" placeholder="Jelszó" required> 
                                          <br><button type="submit">Bejelentkezés</button>
                                         </form> 
                                        </section>
                     <section id="add" style="display: none;">
                                <h2>Film/Sorozat hozzáadása</h2>
                                     <form action="add.php" method="POST" id="addForm">
                                            <!-- Típus kiválasztása -->
                                            <label for="type">Típus:</label>
                                                <select id="type" name="type" required>
                                                   <option value="movie">Film</option>
                                                <option value="series">Sorozat</option>
                                                 </select>

                                                    <!-- Közös mezők -->
                                                    <div id="commonFields">
                                                        <label for="title">Cím:</label>
                                                        <input type="text" id="title" name="title" placeholder="Cím" required>

                                                        <label for="genre">Műfaj:</label>
                                                        <input type="text" id="genre" name="genre" placeholder="Műfaj" required>
                                                    </div>

                                                    <!-- Film-specifikus mezők -->
                                                    <div id="movieFields" style="display: none;">
                                                        <label for="duration">Játékidő (perc):</label>
                                                        <input type="number" id="duration" name="duration" placeholder="Játékidő" min="1">

                                                        <label for="release_year_movie">Megjelenés éve:</label>
                                                        <input type="number" id="release_year_movie" name="release_year_movie" placeholder="Megjelenés éve" min="1900">
                                                    </div>

                                                    <!-- Sorozat-specifikus mezők -->
                                                    <div id="seriesFields" style="display: none;">
                                                        <label for="seasons">Évadok:</label>
                                                        <input type="number" id="seasons" name="seasons" placeholder="Évadok" min="1">

                                                        <label for="episodes">Részek száma:</label>
                                                        <input type="number" id="episodes" name="episodes" placeholder="Részek száma" min="1">
                                                    </div>

                                                    <!-- Beküldés -->
                                                    <button type="submit">Hozzáadás</button>
                                                </form>
                                            </section>

                                            <script>
                                                // Dinamikus mezőváltás
                                                document.getElementById('type').addEventListener('change', function () {
                                                    const type = this.value;
                                                    document.getElementById('movieFields').style.display = type === 'movie' ? 'block' : 'none';
                                                    document.getElementById('seriesFields').style.display = type === 'series' ? 'block' : 'none';
                                                });
                                            </script>
                                            <script>
                                                // A form megjelenítése/elrejtése
                                                function toggleForm() {
                                                    const formSection = document.getElementById('add');
                                                    const isVisible = formSection.style.display === 'block';
                                                    formSection.style.display = isVisible ? 'none' : 'block';
                                                }
                                                // Dinamikus mezőváltás
                                                    document.getElementById('type').addEventListener('change', function () {
                                                        const type = this.value;
                                                        document.getElementById('movieFields').style.display = type === 'movie' ? 'block' : 'none';
                                                        document.getElementById('seriesFields').style.display = type === 'series' ? 'block' : 'none';
                                                    });
                                 </section>
                <section id="rating">
                                                                
                 </section>

            </main>
        </div>
        <img src="protekcio.jfif" title="protekcio" alt="protekcio">
                                   
        <footer>
              © 2024 use code kormosbiznisz in the itemshop
        </footer> 
    </body>
</html>
                    