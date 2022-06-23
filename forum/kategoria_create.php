<?php
include 'header.php';
require_once 'db_connect.php';
$db_connect = new db_connect();
$mysqli = $db_connect->connect();

echo '<h2>Utwórz kategorie</h2>';

if($_SESSION['signed_in'] == false) {
    echo 'Ups, musisz być <a href="/forum/login.php">zalogowany</a>, aby utworzyć kategorie.';
}
else {
    if (($_SERVER['REQUEST_METHOD'] != 'POST')) {

        echo "<form method='post' action=''>
            Nazwa kategorii: <input type='text' name='cat_name' />
            Opis kategorii:<br><textarea name='cat_description' /></textarea>
            <input type='submit' value='Dodaj' />
         </form>";
    } else {

        try {
            if (!empty($_POST['cat_name']) && !ctype_space($_POST['cat_name'])) {

                $sql = "INSERT INTO kategorie(cat_name, cat_description)
                VALUES('" . $mysqli->real_escape_string($_POST['cat_name']) . "', '"
                    . $mysqli->real_escape_string($_POST['cat_description']) . "')";

                $result = $mysqli->query($sql);
                $mysqli->close();
                header('Location: index.php');
            } else {
                echo 'Pole nazwy kategorii nie moze byc puste!';
            }
        } catch (Exception $e) {
            header('Location: index.php');
        }
    }
}
?>