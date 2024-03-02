<?php

include('../config/dbcon.php');

function getAll($table)
{
    global $con;

    $query = "SELECT * FROM $table";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    };

    $stmt->close();

    return $rows;
}

function getById($table, $id)
{
    global $con;
    $query = "SELECT * FROM categories WHERE id=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt->close();

    return $result;
}

function redirect($url, $message)
{
    $_SESSION['message'] = $message;
    header('Location: ' . $url);

    die();
}
