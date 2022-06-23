<?php
include 'header.php';
require_once 'db_connect.php';
$db_connect = new db_connect();
$mysqli = $db_connect->connect();

echo "<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>";

$sql = "SELECT
            pytanie_subject       
        FROM
            pytania
        WHERE
            pytanie_id = " . $mysqli->real_escape_string($_GET['id']);

$result = $mysqli->query($sql);

if (!$result)
{
    echo 'Coś poszło nie tak.';
}
else
{
    if ($result->num_rows == 0)
    {
        echo 'Wiersz dla tego identyfikatora nie istnieje';
    }
    else
    {
        while($row = $result->fetch_assoc( ))
        {
            $subject = $row['pytanie_subject'];
        }
    }
}

$result = $mysqli->query($sql);

if (!$result) {
    echo 'Nie można wyświetlić komentarzy, spróbuj ponownie później' . $mysqli->error;
} else {
    if ($result->num_rows == 0) {
        echo 'This komentarze do not exist.';
    } else {
        $sql = "SELECT
            komentarze.komentarz_id,
            komentarze.komentarz_topic,
            komentarze.komentarz_content,
            komentarze.komentarz_date,
            komentarze.komentarz_by,
            uzytkownicy.user_id,
            uzytkownicy.user_name
        FROM
            komentarze
        LEFT JOIN
            uzytkownicy
        ON
            komentarze.komentarz_by = uzytkownicy.user_id
        WHERE
            komentarze.komentarz_topic = " . $mysqli->real_escape_string($_GET['id']);

        $result = $mysqli->query($sql);

        if (!$result) {
            echo 'Nie można wyświetlić postów, spróbuj ponownie później.';
        } else {
            if ($result->num_rows == 0) {
                echo 'Nie ma jeszcze żadnych komentarzy do tego pytania.';
            } else {
                echo '<table style="width:100%">
                      <tr>
                        <th colspan="2">' . $subject . '</th>          
                      </tr>';

                while ($row = $result->fetch_assoc( )) {
                    echo '<tr>';
                    echo '<td class="leftpart">';
                    echo $row['komentarz_content'];
                    echo '</td>';
                    echo '<td class="rightpart">';
                    if ($_SESSION['signed_in'] && $_SESSION['user_id'] == $row['user_id']) {
                        echo $row['user_name'] . ' <a href="komentarz_edit.php?id=' . $row['komentarz_id'] . '&pytanie_id=' . $_GET['id'] . '">Edytuj</a>';
                        echo ' <a href="komentarz_delete.php?id=' . $row['komentarz_id'] . '&pytanie_id=' . $_GET['id'] . '">Usuń</a>' . "<br>" . $row['komentarz_date'];
                    } else if ($_SESSION['signed_in'] && $_SESSION['user_level'] == MODERATOR_LEVEL) {
                        echo ' <a href="komentarz_delete.php?id=' . $row['komentarz_id'] . '&pytanie_id=' . $_GET['id'] . '">Usuń</a>' . "<br>" . $row['komentarz_date'];
                    } else {
                        echo $row['user_name'] .  "<br>" . $row['komentarz_date'];
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }
            echo '<a href="komentarz_create.php?id=' . $_GET['id'] . '">Skomentuj</a> jeśli chcesz.';
        }
    }
}

include 'footer.php';
?>