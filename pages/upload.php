<?php
session_start();
include("../init.php");
error_reporting(E_ALL);
$page = $_GET['page'];
$PhotoAlbumRepository = new App\Upload\PhotoAlbumRepository($pdo);
echo $PhotoAlbumRepository->upload($_SESSION['userid'], $page);
