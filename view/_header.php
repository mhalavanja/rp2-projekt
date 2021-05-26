<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf8">
    <title><?php if (isset($title)) echo $title; else echo "ebuy"; ?></title>
    <link rel="stylesheet" href="<?php echo __SITE_URL; ?>/static/css/style.css">
</head>
<body>
<img src="<?php echo __SITE_URL; ?>/static/logo.png" alt="logo">
<h1>Welcome, <?php if (isset($_SESSION["user"])) echo $_SESSION["user"] -> getUsername(); else echo " please login or register!"; ?></h1>

<?php
if (isset($_SESSION["user"])) require "_navBar.php";
