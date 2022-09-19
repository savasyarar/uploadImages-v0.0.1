<?php
session_start();
include("../init.php");

$PhotoAlbumRepository = new App\Upload\PhotoAlbumRepository($pdo);
if(isset($_POST['submit'])){
    $title = htmlentities($_POST['title'] ,ENT_QUOTES, "UTF-8");
    $status = htmlentities($_POST['status'] ,ENT_QUOTES, "UTF-8");
    $description = htmlentities($_POST['description'] ,ENT_QUOTES, "UTF-8");
    echo $PhotoAlbumRepository->createAlbum($_SESSION['userid'], $title, $description, $status);
}

?>

<form action="" method="POST">
    <input type="text" name="title">
    <select name="status">
        <option value="1">Öffentlich</option>
        <option value="2">Privat</option>
    </select>
    <input type="submit" name="submit" value="Album erstellen">
</form>