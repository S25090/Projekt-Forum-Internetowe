<?php
include 'header.php';

echo '<h2>Utwórz kategorie</h2>';

if (($_SERVER['REQUEST_METHOD'] != 'POST')) {

    echo "<form method='post' action=''>
        Nazwa kategorii: <input type='text' name='cat_name' />
        Opis kategorii:<br><textarea name='cat_description' /></textarea>
        <input type='submit' value='Dodaj' />
     </form>";
} else {

    try {

        $mysqli = new mysqli("localhost", "root", "admin", "myschema1");

        if(!empty($_POST['cat_name']) && !ctype_space($_POST['cat_name'])) {

            $sql = "INSERT INTO categories(cat_name, cat_description)
            VALUES('" . $mysqli->real_escape_string($_POST['cat_name']) . "', '"
                . $mysqli->real_escape_string($_POST['cat_description']) . "')";

            $result = $mysqli->query($sql);
            header('Location: index.php');
        } else {
            echo 'Pole nazwy kategorii nie moze byc puste!';
        }
    } catch (Exception $e) {
        header('Location: index.php');
    }
}


?>