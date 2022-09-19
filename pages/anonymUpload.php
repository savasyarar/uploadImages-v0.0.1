<?php
session_start();
include("../init.php");
$PhotoAlbumRepository = new App\Upload\PhotoAlbumRepository($pdo);
echo $PhotoAlbumRepository->anonymUpload($_SESSION['ipfromuser']);
