<?php
session_start();  // Session indítása
?>
<!DOCTYPE html> 
<html lang="hu"> 
    <head>
         <meta charset="UTF-8"> 
         <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
         <title>IMDB Applikáció</title>
          <link rel="stylesheet" href="styles.css">
        </head>
        
         <body> 
          <div id="ui">
            <header>
                <h1>Üdvözöllek az ✨<span id="verycool">IMDB</span>✨ adatbázisban!</h1>
                <?php if (isset($_SESSION['username'])): ?>
                    <p id="greeting">Szia, <?php echo $_SESSION['username']; ?>!</p>
                    <button onclick="window.location.href='ui.php'">Főoldal</button>
                    <button onclick="document.getElementById('add').style.display='block';">Film/Sorozat felvétele</button>
                    <!-- <button onclick="window.location.href='list.php'">Filmek és Sorozatok Listája</button> -->
                    <button onclick="window.location.href='list.php'">Filmek és Sorozatok Listája</button>
                    <button onclick="window.location.href='actorslist.php'">Szorgalmas színészek</button>
                    <button onclick="window.location.href='ratingavg.php'">Vicces tény</button>
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
                            <label for="nev">Név:</label>
                             <input type="text" id="nev" name="nev" required> 
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
                                            <label for="type">Típus:</label><br>
        <input type="radio" id="movie" name="type" value="movie" required onchange="toggleFields()">
        <label for="movie">Film</label>
        <input type="radio" id="series" name="type" value="series" required onchange="toggleFields()">
        <label for="series">Sorozat</label><br><br>

        <label for="title">Cím:</label><br>
        <input type="text" name="title" required><br><br>

        <label for="genre">Műfaj:</label><br>
        <input type="text" name="genre" required><br><br>

        <!-- Film-specifikus mezők -->
        <div id="movie_fields" style="display:none;">
            <label for="duration">Játékidő (Film esetén):</label><br>
            <input type="number" name="duration"><br><br>

            <label for="release_year_movie">Megjelenés Éve (Film esetén):</label><br>
            <input type="number" name="release_year_movie"><br><br>
        </div>

        <!-- Sorozat-specifikus mezők -->
        <div id="series_fields" style="display:none;">
            <label for="seasons">Évadok (Sorozat esetén):</label><br>
            <input type="number" name="seasons"><br><br>

            <label for="episodes">Részek (Sorozat esetén):</label><br>
            <input type="number" name="episodes"><br><br>
        </div>

        <label for="rating">Értékelés:</label><br>
        <input type="number" name="rating" min="0" max="10" step="0.1" required><br><br>

                                                    <!-- Beküldés -->
                                                    <button type="submit">Hozzáadás</button>
                                                </form>
                                            </section>

                                            <script>
        function toggleFields() {
            var type = document.querySelector('input[name="type"]:checked').value;
            if (type === 'movie') {
                document.getElementById("movie_fields").style.display = "block";
                document.getElementById("series_fields").style.display = "none";
            } else if (type === 'series') {
                document.getElementById("movie_fields").style.display = "none";
                document.getElementById("series_fields").style.display = "block";
            }
        }
    </script>
                                 </section>
                <section id="rating">
                                                          
                 </section>
                 
                 
            </main>
        </div>
        <div>
            <img src="protekcio.jpg" id="protekcio" alt="xd">
        </div>
                         
        <footer>
              © 2024 use code kormosbiznisz in the itemshop
        </footer> 
    </body>
</html>
                    