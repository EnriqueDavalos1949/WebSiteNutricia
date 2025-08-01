<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "nutricia";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    mysqli_set_charset($conn, "utf8");
} catch (mysqli_sql_exception $e) {
    echo "¡No se pudo conectar a la base de datos!<br>";
    echo "Error: " . $e->getMessage();
    exit;
}
?>


