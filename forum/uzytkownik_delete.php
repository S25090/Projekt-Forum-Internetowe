<?php
include 'header.php';
require_once 'db_connect.php';
$db_connect = new db_connect();
$mysqli = $db_connect->connect();

echo '<h2>Edytuj użytkownika</h2>';
if($_SESSION['signed_in'])
{
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {

        $mysqli->begin_transaction();

        try {
            $mysqli->query("DELETE FROM pytania
                WHERE pytanie_by = " . $_SESSION['user_id']);

            $mysqli->query("DELETE FROM uzytkownicy
                WHERE user_id = " . $_SESSION['user_id']);

            $mysqli->commit();
        } catch (mysqli_sql_exception $exception) {
            $mysqli->rollback();

            throw $exception;
        }
        session_start();
        session_destroy();
        header("Location: index.php");
    }
}
?>