<?php include("template/cabecera.php");?>
<?php include("config/DB.php"); ?>

<?php
$idPac = isset($_GET['idPac']) ? intval($_GET['idPac']) : 0;
$nombrePaciente = 'Paciente no encontrado';

if ($idPac > 0) {
    $stmt = $conn->prepare("SELECT name FROM pxreg WHERE idPac = ?");
    $stmt->bind_param("i", $idPac);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($row = $resultado->fetch_assoc()) {
        $nombrePaciente = $row['name'];
    }
    $stmt->close();
}
?>

<div class="container mt-4">
    <h3>Historial PDF para: <strong><?php echo htmlspecialchars($nombrePaciente); ?></strong></h3>
    <iframe src="PDFHistory.php?idPac=<?php echo $idPac; ?>" width="100%" height="600px" style="border:1px solid #ccc;"></iframe>
</div>

<?php include("template/pie.php"); ?>
<div class="col-md-3">
    <div class="card">
    <img class="card-img-top" src="https://www.w3schools.com/bootstrap4/img_avatar1.png" alt="">
    <div class="card-body">
        <h4 class="card-title">Libro php</h4>
        <a name="" id="" class="btn btn-primary" href="#" role="button">Ver más</a>      
</div>
</div>
</div>

<div class="col-md-3">
    <div class="card">
    <img class="card-img-top" src="https://www.w3schools.com/bootstrap4/img_avatar1.png" alt="">
    <div class="card-body">
        <h4 class="card-title">Libro php</h4>
        <a name="" id="" class="btn btn-primary" href="#" role="button">Ver más</a>      
</div>
</div>
</div>

<div class="col-md-3">
    <div class="card">
    <img class="card-img-top" src="https://www.w3schools.com/bootstrap4/img_avatar1.png" alt="">
    <div class="card-body">
        <h4 class="card-title">Libro php</h4>
        <a name="" id="" class="btn btn-primary" href="#" role="button">Ver más</a>      
</div>
</div>
</div>


<div class="col-md-3">
    <div class="card">
    <img class="card-img-top" src="https://www.w3schools.com/bootstrap4/img_avatar1.png" alt="">
    <div class="card-body">
        <h4 class="card-title">Libro php</h4>
        <a name="" id="" class="btn btn-primary" href="#" role="button">Ver más</a>      
</div>
</div>
</div>

<?php include("template/pie.php");?>