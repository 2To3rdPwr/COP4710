<?php
    include 'dbh.inc.php';
    $event_id = $_GET['event_key'];

    $sql = "DELETE FROM event WHERE event_id=$event_id;";
    mysqli_query($conn, $sql)or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);

    header("Location: ../admin.php?success=refused");
?>