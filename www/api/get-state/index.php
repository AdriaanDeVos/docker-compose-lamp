<?php
$dimension_x = 100;
$dimension_y = 100;

// Create 2D-Array with correct dimensions.
$grid = array_fill(0, $dimension_x, array_fill(0, $dimension_y, 0));

// Obtain guesses from database and update the 2D-Array.
#$conn = mysqli_connect("database", $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'], $_ENV['MYSQL_DATABASE']);
#mysqli_close($conn);

// Convert 2D-Array to string and return it.
$grid_string = implode(array_merge(...$grid));
$result = array("status" => 200, "grid-state" => $grid_string);
header('Content-Type: application/json; charset=utf-8');
echo(json_encode($result));
