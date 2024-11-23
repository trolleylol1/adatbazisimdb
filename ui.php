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
    <button onclick="document.getElementById('rating').style.display='block';">Értékelés</button>
    <button onclick="document.getElementById('add').style.display='block';">Film/Sorozat felvétele</button>
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
                                        <section id="rating">

                                        </section>
                                        <section id="add">
                    
                                        </section>

                                    </main>
                                   </div>
                                   <img src="protekcio.jfif" title="protekcio" alt="protekcio">
                                   
                                     <footer>
                                        © 2024 use code kormosbiznisz in the itemshop
                                       </footer> 

                                    </body>
                               </html>
                    