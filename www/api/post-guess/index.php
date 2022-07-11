<?php

$conn = mysqli_connect("database", $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'], $_ENV['MYSQL_DATABASE']);

// Ensure that all required POST parameters are send, otherwise return HTTP 400.
if (!key_exists('pos_x', $_REQUEST) || !key_exists('pos_y', $_REQUEST) || !key_exists('username', $_REQUEST)) {
    $result = array("status" => 400, "message" => "Missing required parameters.");
    header('Content-Type: application/json; charset=utf-8');
    echo(json_encode($result));
    exit();
}

// Make sure to sanitize and escape the user input as it will be used for SQL queries.
$pos_x = mysqli_real_escape_string($conn, $_REQUEST['pos_x']);
$pos_y = mysqli_real_escape_string($conn, $_REQUEST['pos_y']);
$user = mysqli_real_escape_string($conn, $_REQUEST['username']);

// Register the guess in the database and check for possible winnings.
$query = "INSERT INTO nlo.ticket (user, pos_x, pos_y) VALUES ('$user', '$pos_x', '$pos_y')";
try {
    $insert_result = mysqli_query($conn, $query);
    $price_query = "SELECT price FROM nlo.price WHERE pos_x = '$pos_x' AND pos_y = '$pos_y'";
    $price_result = mysqli_query($conn, $price_query);

    if (mysqli_num_rows($price_result) == 0) {
        $result = array("status" => 200, "message" => "No price found at this position. Better luck next time.");
    } else {
        $result = array("status" => 200, "message" => "You have won: €" . mysqli_fetch_assoc($price_result)['price']);
    }
} catch (mysqli_sql_exception $e) {
    // This occurs when one of the unique indexes fails. Either the user has already registered a ticket.
    // Or the gridposition has already been opened.
    $result = array("status" => 404, "message" => "Unable to register user / grid-position ticket.");
}

mysqli_close($conn);
header('Content-Type: application/json; charset=utf-8');
echo(json_encode($result));
