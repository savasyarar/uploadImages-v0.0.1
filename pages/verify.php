<?php
session_start();
include("../init.php");

$UserRepository = new App\User\UserRepository($pdo);
$UserRepository->userLoginBackend($_SESSION['userid']);

if(isset($_POST['submit'])){
    $verify = htmlentities($_POST['verify']);
    echo $UserRepository->userVerifyCode($_SESSION['userid'], $verify);
}

?>


<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8"/>
      <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Verifizieren</title>
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
        <form class="card card-md" action="" method="POST" autocomplete="off">
          <div class="card-body text-center">
              <div class="card-title text-center mb-4"><a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.png" height="36" alt=""></a></div>
            <div class="mb-4">
              <h2 class="card-title">Aktiviere dein Konto</h2>
              <p class="text-muted">Bitte gebe den Code den wir dir per E-Mail geschickt haben hier ein.</p>
            </div>
            <div class="mb-4">
              <input type="text" name="verify" class="form-control" placeholder="Verifizierungscode">
            </div>
            <div>
              <button type="submit" name="submit" class="btn btn-dark w-100">
                <!-- Download SVG icon from http://tabler-icons.io/i/lock-open -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="5" y="11" width="14" height="10" rx="2" /><circle cx="12" cy="16" r="1" /><path d="M8 11v-5a4 4 0 0 1 8 0" /></svg>
                Verifizieren
              </button>
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


