<?php
//kategoria_create.php
include 'connect.php';
include 'header.php';

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

$mysqli = new mysqli("localhost","root","admin","myschema1");

$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories
		";

$result = $mysqli->query($sql);

if(!$result)
{
    echo 'Nie można wyświetlić kategorii, spróbuj ponownie później';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'Nie zdefiniowano jeszcze kategorii.';
    }
    else
    {
        //prepare the table
        echo '<table>
              <tr>
                <th>Kategoria</th>
              </tr>';

        while($row = mysqli_fetch_assoc( $result))
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