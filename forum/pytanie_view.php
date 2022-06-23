<?php
include 'header.php';
require_once 'db_connect.php';
$db_connect = new db_connect();
$mysqli = $db_connect->connect();

echo "<style>
table, th, td {
    border:1px solid black;
    border-collapse: collapse;
}
</style>";

$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            kategorie
        WHERE
            cat_id = " . $mysqli->real_escape_string($_GET['id']);


$result = $mysqli->query($sql);

if(!$result)
{
    echo 'Nie można wyświetlić kategorii, spróbuj ponownie później.' . $mysqli->error;
}
else
{
    if($result->num_rows == 0)
    {
        echo 'Ta kategoria nie istnieje.';
    }
    else
    {
        while($row = $result->fetch_assoc( ))
        {
            echo '<h2>Pytania w kategorii ′' . $row['cat_name'] . '′</h2>';
        }

        $sql = "SELECT  
                    pytanie_id,
                    pytanie_subject,
                    pytanie_date,
                    pytanie_cat,
                    pytanie_by,
                    user_id,
                    user_name
                FROM
                    pytania
                LEFT JOIN
                    uzytkownicy
                ON
	                pytania.pytanie_by = uzytkownicy.user_id
                WHERE
                    pytanie_cat = " . $mysqli->real_escape_string($_GET['id']);

        $result = $mysqli->query($sql);

        if(!$result)
        {
            echo 'Nie można wyświetlić pytań, spróbuj ponownie później.';
        }
        else
        {
            if($result->num_rows == 0)
            {
                echo 'W tej kategorii nie ma jeszcze pytań.';
            }
            else
            {
                echo '<table style="width:100%">
                      <tr>
                        <th>Pytanie</th>
                        <th>Zadane:</th>
                      </tr>';

                while($row = $result->fetch_assoc())
                {
                    echo '<tr>';
                    echo '<td class="leftpart">';
                    echo '<h3><a href="komentarz_view.php?id=' . $row['pytanie_id'] . '">' . $row['pytanie_subject'] . '</a><h3>';
                    echo '</td>';
                    echo '<td class="rightpart">';
                    echo date('d-m-Y', strtotime($row['pytanie_date']));
                    echo " ";
                    echo "przez: " . $row['user_name'] . ' ';
                    if ( $_SESSION['signed_in'] ) {
                        if ( ($_SESSION['user_id'] == $row['pytanie_by']) || ($_SESSION['user_level'] == ADMINISTRATOR_LEVEL)) {
                            echo '<a href="pytanie_edit.php?id=' . $row['pytanie_id'] . '&cat_id=' . $_GET['id'] . '">&nbsp;&nbsp;Edytuj&nbsp;&nbsp;</a>';
                            echo '<a href="pytanie_delete.php?id=' . $row['pytanie_id'] . '&cat_id=' . $_GET['id'] . '">Usuń</a>';
                        } else if ( $_SESSION['user_level'] == MODERATOR_LEVEL ) {
                            echo '<a href="pytanie_delete.php?id=' . $row['pytanie_id'] . '&cat_id=' . $_GET['id'] . '">Usuń</a>';
                        }
                    }
                    echo '</td>';
                    echo '</tr>';
                }
            }
        }
    }
}

include 'footer.php';
?>