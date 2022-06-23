<?php
include 'header.php';
require_once 'db_connect.php';
$db_connect = new db_connect();
$mysqli = $db_connect->connect();

echo '<h2>Zadaj pytanie</h2>';
if($_SESSION['signed_in'] == false)
{

    echo 'Ups, musisz być <a href="/forum/login.php">zalogowany</a>,aby zadać pytanie.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        $sql = "SELECT
                    cat_id,
                    cat_name,
                    cat_description
                FROM
                    kategorie";

        $result = $mysqli->query($sql);

        if(!$result)
        {
            echo 'Błąd podczas wybierania danych z bazy. Spróbuj ponownie później.';
        }
        else
        {
            if($result->num_rows == 0)
            {
                if($_SESSION['user_level'] == 1)
                {
                    echo 'Nie utworzyłeś jeszcze żadnych kategorii.';
                }
                else
                {
                    echo 'Zanim będziesz mógł opublikować pytanie, musisz poczekać, aż administrator utworzy kilka kategorii.';
                }
            }
            else
            {
                echo '<form method="post" action="">
                    Pytanie: <br><textarea name="pytanie_subject" /></textarea><br>
                    Kategoria:';

                echo '<select name="pytanie_cat">';
                while($row = $result->fetch_assoc( ))
                {
                    echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                }
                echo '</select>';
                echo '<input type="submit" value="Zadaj pytanie" />
                      </form>';
            }
        }
    }
    else
    {
        try {
            if(!empty($_POST['pytanie_subject']) && !ctype_space($_POST['pytanie_subject'])) {
                $sql = "INSERT INTO 
                    pytania(pytanie_subject,
                           pytanie_date,
                           pytanie_cat,
                           pytanie_by)
               VALUES('" . $mysqli->real_escape_string($_POST['pytanie_subject']) . "',
                           NOW(),
                           " . $mysqli->real_escape_string($_POST['pytanie_cat']) . ",
                           " . $_SESSION['user_id'] . "
                           )";

                $result = $mysqli->query($sql);
                header('Location: pytanie_view.php?id=' . $_POST['pytanie_cat']);
            } else {
                echo 'Nazwa pytania nie moze byc pusta!';
            }
        } catch (Exception $e) {
            header('Location: index.php');
        }

    }
}

include 'footer.php';
?>