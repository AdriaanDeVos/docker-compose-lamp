<?php
$dimension_x = 100;
$dimension_y = 100;

// Create 2D-Array with correct dimensions.
$grid = array_fill(1, $dimension_x, array_fill(1, $dimension_y, 0));

// Obtain guesses from database and update the 2D-Array.
$conn = mysqli_connect("database", $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'], $_ENV['MYSQL_DATABASE']);
$query = "SELECT pos_x, pos_y FROM nlo.ticket";
$grid_result = mysqli_query($conn, $query);

// For all guesses registered in the database, update the grid.
while ($row = mysqli_fetch_assoc($grid_result)) {
    $pos_x = $row['pos_x'];
    $pos_y = $row['pos_y'];
    $grid[$pos_x][$pos_y] = 1;
}
mysqli_close($conn);

// Convert 2D-Array to string and return it.
$grid_string = implode(array_merge(...$grid));
$result = array("status" => 200, "grid-state" => $grid_string);
header('Content-Type: application/json; charset=utf-8');
echo(json_encode($result));
