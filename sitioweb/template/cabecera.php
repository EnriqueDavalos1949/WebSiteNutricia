<?php 
session_start(); 
// Definir el tema por defecto si no existe
$tema = isset($_SESSION['tema']) ? $_SESSION['tema'] : 'bg-primary'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.min.css"/>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark <?php echo $tema; ?>">
        <ul class="nav navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="registros.php">Registro</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="consultas.php">Consultas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Config.php">Configuración</a>
            </li>
        </ul>
    </nav>
    <div class="container">
        <br/>
        <div class="row">
