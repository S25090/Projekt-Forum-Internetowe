<?php
include 'header.php';
require_once 'db_connect.php';
$db_connect = new db_connect();
$mysqli = $db_connect->connect();

echo '<h2>Edytuj pytanie</h2>';
if($_SESSION['signed_in'] == false)
{
    echo 'Ups, musisz być <a href="/forum/login.php">zalogowany</a> aby edytować pytanie.';
}
else {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {

        $sql = "SELECT
                    pytanie_id,
                    pytanie_subject,
                    pytanie_date,
                    pytanie_cat,
                    pytanie_by
                FROM
                    pytania
                WHERE pytanie_id = " . $mysqli->real_escape_string($_GET['id']);


        $result = $mysqli->query($sql);

        if (!$result) {
            echo 'Błąd podczas wybierania z bazy danych. Spróbuj ponownie później.';
        } else {
            if ($result->num_rows == 0) {

                if ($_SESSION['user_level'] == 1) {
                    echo 'Nie utworzyłeś jeszcze kategorii na forum.';
                } else {
                    echo 'Zanim napiszesz pytanie, upewnij się czy są kategorie na forum.';
                }
            } else {
                $row = $result->fetch_assoc();
                echo '<form method="post" action="pytanie_update.php?id=' . $_GET['id'] . '&cat_id=' . $_GET['cat_id'] . '">' .
                    '<textarea name="pytanie_subject">' . $row['pytanie_subject'] . '</textarea>' .
                    '<input type="submit" value="Zatwierdź" /> 
                    </form>';
            }
        }
    }
}
?>