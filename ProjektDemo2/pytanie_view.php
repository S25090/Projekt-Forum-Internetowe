<?php


include 'header.php';

echo "<style>
table, th, td {
    border:1px solid black;
    border-collapse: collapse;
}
</style>";

$mysqli = new mysqli("localhost","root","admin","myschema1");

//first select the category based on $_GET['cat_id']
$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories
        WHERE
            cat_id = " . $mysqli->real_escape_string($_GET['id']);


$result = $mysqli->query($sql);

if(!$result)
{
    echo 'Nie można wyświetlić kategorii, spróbuj ponownie później.' . mysqli_error();
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'Ta kategoria nie istnieje.';
    }
    else
    {
        //display category data
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<h2>Pytania w kategorii ′' . $row['cat_name'] . '′</h2>';
        }

        //do a query for the topics
        $sql = "SELECT  
                    topic_id,
                    topic_subject,
                    topic_date,
                    topic_cat
                FROM
                    topics
                WHERE
                    topic_cat = " . $mysqli->real_escape_string($_GET['id']);

        $result = $mysqli->query($sql);

        if(!$result)
        {
            echo 'Nie można wyświetlić pytań, spróbuj ponownie później.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
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

                while($row = mysqli_fetch_assoc($result))
                {
                    echo '<tr>';
                    echo '<td class="leftpart">';
                    echo '<h3><a href="komentarz_view.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><h3>';
                    echo '</td>';
                    echo '<td class="rightpart">';
                    echo date('d-m-Y', strtotime($row['topic_date']));
                    echo " ";
                    echo "przez: " . $_SESSION['user_name'];
                    echo '</td>';
                    echo '</tr>';
                }
            }
        }
    }
}

include 'footer.php';
?>