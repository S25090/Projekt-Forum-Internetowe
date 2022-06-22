<?php
    session_start();
    if (!isset($_SESSION['signed_in'])) {
        $_SESSION['signed_in'] = false;
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="nl" lang="nl">
<head>
    <link rel="stylesheet" href="style.css" type="text/css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="description" content="A short description." />
    <meta name="keywords" content="put, keywords, here" />
    <title>PHP-MySQL forum</title>

</head>
<body>
<h1>Moje forum</h1>
<div id="wrapper">
    <div id="menu">
        <a class="item" href="/ProjektDemo2/index.php">Strona główna</a> -
        <a class="item" href="/ProjektDemo2/pytanie_create.php">Zadaj pytanie</a> -
        <a class="item" href="/ProjektDemo2/kategoria_create.php">Utwórz kategorie</a>

        <div id="userbar">
            <?php
            if($_SESSION['signed_in']==true)
            {
                echo 'Witaj ' . $_SESSION['user_name'] . '. To nie ty? <a href="signout.php">Wyloguj mnie</a>';
            }
            else
            {
                echo '<a href="signin.php">Zaloguj się</a> lub <a href="rejestracja.php">utwórz konto</a>.';
            }
            ?>
        </div>
        <div id="content">