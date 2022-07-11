<?php
$dimension_x = 100;
$dimension_y = 100;
$major_price_money = 25000;
$minor_price_money = 100;
$num_minor_price = 100;

// Required to ensure database is available as this script is run when the database is yet starting.
$waiting_for_database_connection = true;
while ($waiting_for_database_connection) {
    try {
        $conn = mysqli_connect("database", $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD'], $_ENV['MYSQL_DATABASE']);
        $waiting_for_database_connection = false;
    } catch (mysqli_sql_exception $e) {
        echo "[Info] Waiting for database connection to be ready..." . PHP_EOL;
        sleep(1);
    }
}

// Check if any prices are already registered in the database.
$count_query = "SELECT COUNT(*) FROM nlo.price";
$count_result = mysqli_query($conn, $count_query);
$count_prices = mysqli_fetch_array($count_result)[0];

// If no prices are registered, do the drawing for new prices.
if (!$count_prices) {
    print("[Info] No prices found in database. Seeding prices..." . PHP_EOL);
    $major_price_pos_x = rand(1, $dimension_x);
    $major_price_pos_y = rand(1, $dimension_y);
    $query = "INSERT INTO nlo.price (pos_x, pos_y, price) VALUES ($major_price_pos_x, $major_price_pos_y, $major_price_money)";
    $result = mysqli_query($conn, $query);
    print("[Secret] The major price is @ $major_price_pos_x - $major_price_pos_y" . PHP_EOL);

    $num_created_minor_price = 0;
    while ($num_created_minor_price < $num_minor_price) {
        $minor_price_pos_x = rand(1, $dimension_x);
        $minor_price_pos_y = rand(1, $dimension_y);
        $query = "INSERT INTO nlo.price (pos_x, pos_y, price) VALUES ($minor_price_pos_x, $minor_price_pos_y, $minor_price_money)";
        try {
            $result = mysqli_query($conn, $query);
            $num_created_minor_price++;
        } catch (mysqli_sql_exception $e) {
            echo "[Info] Double-draw minor price, lets pick another one..." . PHP_EOL;
        }
    }
}

mysqli_close($conn);