<?php
include("../init.php");
session_start();

$UserRepository = new App\User\UserRepository($pdo);

if(isset($_POST['submit'])){
    $email = htmlentities($_POST['email']);
    $vorname = htmlentities($_POST['vorname']);
    $password = htmlentities($_POST['password']);
    $passwordwdh = htmlentities($_POST['passwordwdh']);
    $status = 1;

    echo $UserRepository->createNewUser($email, $vorname, $password, $passwordwdh, $status);
}


?>

<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Registrieren</title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
  </head>
  <body  class=" border-top-wide border-primary d-flex flex-column">
    <div class="page page-center">
      <div class="container-tight py-4">
        <form class="card card-md" action="" method="POST">
          <div class="card-body">
            <div class="card-title text-center mb-4"><div class="text-center mb-4">
                    <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.png" height="36" alt=""></a>
                </div>
            </div>
            <div class="mb-3">
              <label class="form-label">E-Mail</label>
              <input type="email" name="email" class="form-control" placeholder="E-Mail Adresse" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Vorname</label>
              <input type="text" name="vorname" class="form-control" placeholder="Vorname" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Passwort</label>
              <div class="input-group input-group-flat">
                <input type="password" class="form-control" name="password"  placeholder="Passwort"  autocomplete="off" required>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Passwort wiederholen</label>
              <div class="input-group input-group-flat">
                <input type="password" class="form-control" name="passwordwdh"  placeholder="Passwort wiederholen"  autocomplete="off" required>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-check">
                <input type="checkbox" class="form-check-input"/>
                <span class="form-check-label">Mit der Erstellung eines Kontos stimmst du unseren <a href="./terms-of-service.html" tabindex="-1">Nutzungsbedingungen</a> zu. Bitte beachte auch unsere Datenschutz- und Cookie-Erklärung.</span>
              </label>
            </div>
            <div class="form-footer">
              <button type="submit" name="submit" class="btn btn-dark w-100">Registrieren</button>
            </div>
              <div class="text-center text-muted mt-3">
                  Du hast schon ein Account? <a href="../pages/login.php" tabindex="-1">Anmelden</a>
              </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js" defer></script>
    <script src="./dist/js/demo.min.js" defer></script>
  </body>
</html>