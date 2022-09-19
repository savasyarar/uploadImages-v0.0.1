<?php
session_start();
include("../init.php");
$UserRepository = new App\User\UserRepository($pdo);

if(isset($_POST['submit'])){
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);

    if(isset($_POST['logged'])){
        $logged = htmlentities($_POST['logged']);
    } else {
        $logged = NULL;
    }

    echo $UserRepository->loginUser($email, $password, $logged);
}

?>
<!doctype html>
<html lang="de">
  <head>
    <script defer data-domain="preview.tabler.io" src="https://plausible.io/js/plausible.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-113467793-4"></script>
    <meta charset="utf-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Photoly Login</title>
    <link rel="preconnect" href="https://www.google-analytics.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://www.googletagmanager.com" crossorigin>
    <meta name="msapplication-TileColor" content="#206bc4"/>
    <meta name="theme-color" content="#206bc4"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="MobileOptimized" content="320"/>
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
    <meta name="description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!"/>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css?1655415752" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css?1655415752" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css?1655415752" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css?1655415752" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css?1655415752" rel="stylesheet"/>
  </head>
  <body  class=" border-top-wide border-primary d-flex flex-column">
    <div class="page page-center">
      <div class="container-tight py-4">
        <form class="card card-md" action="" method="POST" autocomplete="off">
          <div class="card-body">
            <div class="card-title text-center mb-4"><a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.png" height="36" alt=""></a></div>
            <div class="mb-3">
              <label class="form-label">E-Mail</label>
              <input type="email" class="form-control" name="email" placeholder="E-Mail Adresse" autocomplete="off">
            </div>
            <div class="mb-2">
              <label class="form-label">
                Passwort
                <span class="form-label-description">
                  <a href="../pages/register.php">Passwort vergessen?</a>
                </span>
              </label>
              <div class="input-group input-group-flat">
                <input type="password" class="form-control" name="password"  placeholder="Passwort"  autocomplete="off">
              </div>
            </div>
            <div class="mb-2">
              <label class="form-check">
                <input type="checkbox" name="logged" class="form-check-input"/>
                <span class="form-check-label">Angemeldet bleiben</span>
              </label>
            </div>
            <div class="form-footer">
              <button type="submit" name="submit" class="btn btn-dark w-100">Anmelden</button>
            </div>
              <div class="text-center text-muted mt-3">
                  Du hast noch kein Account? <a href="../pages/register.php" tabindex="-1"><b>Registrieren</b></a>
              </div>
          </div>
          </div>
        </form>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1655415752" defer></script>
    <script src="./dist/js/demo.min.js?1655415752" defer></script>
  </body>
</html>
