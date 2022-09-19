<?php
session_start();
include("../init.php");
$UserRepository = new App\User\UserRepository($pdo);
echo $UserRepository->logoutUser();
?>

