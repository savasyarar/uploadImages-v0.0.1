<?php
session_start();
include("../init.php");
if(!isset($_SESSION['userid'])){
    header("Location: ../pages/login.php");
}
/*
if(isset($_COOKIE['photoly_login'])){
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE logged = ?");
    $stmt->execute([$_COOKIE['photoly_login']]);

    if($stmt->rowCount() === 1){

    } else {
        setcookie('photoly_login', '', time() - 3600);
    }
}
*/

$UserRepository = new App\User\UserRepository($pdo);
$UserRepository->getUserDetails($_SESSION['userid'])['vorname'];
$userEmail = $UserRepository->getUserDetails($_SESSION['userid'])['email'];
$pageTitle = "Dashboard";


//Album erstellen
$PhotoAlbumRepository = new App\Upload\PhotoAlbumRepository($pdo);
if(isset($_POST['createAlbum'])){
    $title = htmlentities($_POST['title'] ,ENT_QUOTES, "UTF-8");
    $status = htmlentities($_POST['status'] ,ENT_QUOTES, "UTF-8");
    $description = htmlentities($_POST['description'] ,ENT_QUOTES, "UTF-8");
    echo $PhotoAlbumRepository->createAlbum($_SESSION['userid'], $title, $description, $status);
}





?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover, user-scalable=0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title><?php echo $pageTitle; ?></title>
    <!-- CSS files -->
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
  </head>
  <body >
    <div class="page">
      <header class="navbar navbar-expand-md navbar-light d-print-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            <a href="../pages/dashboard.php">
              <img src="./static/logo.png" width="110" height="32" alt="Tabler" class="navbar-brand-image">
            </a>
          </h1>
          <div class="navbar-nav flex-row order-md-last">
          <div class="nav-item d-none d-md-flex me-3">
              <div class="btn-list">
              <a href="javascript:void(0)" class="btn" data-bs-toggle="modal" data-bs-target="#modal-report">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                  Album erstellen
                </a>
              </div>
            </div>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
                <div class="d-none d-xl-block ps-2">
                <div><?php echo $UserRepository->getUserDetails($_SESSION['userid'])['vorname']; ?></div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="../pages/settings.php" class="dropdown-item">Kontoeinstellungen</a>
                <a href="#" class="dropdown-item">Hilfe</a>
                <div class="dropdown-divider"></div>
                <a href="../pages/logout.php" class="dropdown-item">Logout</a>
              </div>
            </div>
          </div>
        </div>
      </header>

      <div class="navbar-expand-md">
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div class="navbar navbar-light">
            <div class="container-xl">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="../pages/dashboard.php">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="5 12 3 12 12 3 21 12 19 12"></polyline><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path></svg>
                    </span>
                    <span class="nav-link-title">
                      Dashboard
                    </span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>