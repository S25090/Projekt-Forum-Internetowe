<?php
include 'header.php';
require_once 'db_connect.php';
$db_connect = new db_connect();
$mysqli = $db_connect->connect();

echo "<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    width: 100%;
}
</style>";

echo '<tr>';
echo '<td class="leftpart">';

echo '</td>';
echo '<td class="rightpart">';

echo '</td>';
echo '</tr>';

if ( $mysqli == null)
    return;

$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            kategorie
		";

$result = $mysqli->query($sql);

if(!$result)
{
    echo 'Nie można wyświetlić kategorii, spróbuj ponownie później';
}
else
{
    if($result->num_rows == 0)
    {
        echo 'Nie zdefiniowano jeszcze kategorii.';
    }
    else
    {
        echo '<table>
              <tr>
                <th>Kategoria</th>
              </tr>';

        while($row = $result->fetch_assoc( ))
        {
            echo '<tr>';
            echo '<td>';
            echo '<h3><a href="pytanie_view.php?id=' . $row['cat_id'] . '">' . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
            echo '</td>';
            echo '</tr>';
        }
    }
}

include 'footer.php';
?>