<?php


include 'header.php';

echo "<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>";

$mysqli = new mysqli("localhost", "root", "admin", "myschema1");

$sql = "SELECT
            topic_subject       
        FROM
            topics
        WHERE
            topic_id = " . $mysqli->real_escape_string($_GET['id']);

$result = $mysqli->query($sql);

if (!$result)
{
    echo 'Coś poszło nie tak.';
}
else
{
    if (mysqli_num_rows($result) == 0)
    {
        echo 'Wiersz dla tego identyfikatora nie istnieje';
    }
    else
    {
        //we also put the user_id and user_name values in the $_SESSION, so we can use it at various pages
        while($row = mysqli_fetch_assoc( $result))
        {
            $subject = $row['topic_subject'];
        }
    }
}

$result = $mysqli->query($sql);

if (!$result) {
    echo 'Nie można wyświetlić komentarzy, spróbuj ponownie później' . mysqli_error();
} else {
    if (mysqli_num_rows($result) == 0) {
        echo 'This posts do not exist.';
    } else {
        $sql = "SELECT
            posts.post_id,
            posts.post_topic,
            posts.post_content,
            posts.post_date,
            posts.post_by,
            users.user_id,
            users.user_name
        FROM
            posts
        LEFT JOIN
            users
        ON
            posts.post_by = users.user_id
        WHERE
            posts.post_topic = " . $mysqli->real_escape_string($_GET['id']);

        $result = $mysqli->query($sql);

        if (!$result) {
            echo 'Nie można wyświetlić postów, spróbuj ponownie później.';
        } else {
            if (mysqli_num_rows($result) == 0) {
                echo 'Nie ma jeszcze żadnych komentarzy do tego pytania.';
            } else {
                //prepare the table

                echo '<table style="width:100%">
                      <tr>
                        <th colspan="2">' . $subject . '</th>          
                      </tr>';

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td class="leftpart">';
                    if ($_SESSION['signed_in'] && $_SESSION['user_id'] == $row['user_id']) {
                        echo $row['user_name'] . ' <a href="komentarz_edit.php?id=' . $row['post_id'] . '&topic_id=' . $_GET['id'] . '">Edytuj</a>';
                        echo ' <a href="komentarz_delete.php?id=' . $row['post_id'] . '&topic_id=' . $_GET['id'] . '">Usuń</a>' . "<br>" . $row['post_date'];
                    } else {
                        echo $row['user_name'] .  "<br>" . $row['post_date'];
                    }
                    echo '</td>';
                    echo '<td class="rightpart">';
                    echo $row['post_content'];
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