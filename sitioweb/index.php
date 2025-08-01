<?php include("config/DB.php"); ?>

<?php include("template/cabecera.php"); 
$mensaje = "";

// Eliminar cita
if (isset($_GET['eliminar'])) {
    $id_cita = $_GET['eliminar'];
    $query = "DELETE FROM citas WHERE ID_cita = $id_cita";
    if (mysqli_query($conn, $query)) {
        $mensaje = "Cita eliminada correctamente.";
    } else {
        $mensaje = "Error al eliminar cita: " . mysqli_error($conn);
    }
}

// Editar cita (mostrar datos en formulario)
$cita = ['ID_cita' => '', 'Nombre' => '', 'TELEFONO' => '', 'Fecha' => '', 'HORA' => ''];
if (isset($_GET['editar'])) {
    $id_cita = $_GET['editar'];
    $query = "SELECT * FROM citas WHERE ID_cita = $id_cita";
    $result = mysqli_query($conn, $query);
    $cita = mysqli_fetch_assoc($result);
}

// Guardar nueva cita
if (isset($_POST['guardar_cita'])) {
    $nombre = $_POST['Nombre'];
    $telefono = $_POST['TELEFONO'];
    $fecha = $_POST['Fecha'];
    $hora = $_POST['HORA'];

    $query = "INSERT INTO citas (Nombre, TELEFONO, Fecha, HORA) VALUES ('$nombre', '$telefono', '$fecha', '$hora')";
    if (mysqli_query($conn, $query)) {
        $mensaje = "Cita registrada correctamente.";
    } else {
        $mensaje = "Error al registrar cita: " . mysqli_error($conn);
    }
}

// Actualizar cita
if (isset($_POST['editar_cita'])) {
    $id_cita = $_POST['ID_cita'];
    $nombre = $_POST['Nombre'];
    $telefono = $_POST['TELEFONO'];
    $fecha = $_POST['Fecha'];
    $hora = $_POST['HORA'];

    $query = "UPDATE citas SET Nombre='$nombre', TELEFONO='$telefono', Fecha='$fecha', HORA='$hora' WHERE ID_cita=$id_cita";
    if (mysqli_query($conn, $query)) {
        $mensaje = "Cita actualizada correctamente.";
    } else {
        $mensaje = "Error al actualizar cita: " . mysqli_error($conn);
    }
}
?>

<div class="jumbotron text-center">
    <img src="img/logo.png" alt="Logo Lunaria" class="img-fluid mb-3" style="max-width: 200px;">
    <p class="lead">¡Bienvenido al sistema integral para el control de pacientes en el área de nutrición. Aquí podrás registrar, consultar y actualizar información clínica, así como agendar y gestionar citas médicas de forma rápida y organizada!</p>
    <hr class="my-2">
</div>

<div class="container mt-4">
    <h2>Gestionar Citas</h2>

    <?php if (!empty($mensaje)): ?>
        <div id="mensaje-alerta" class="alert alert-info alert-dismissible fade show" role="alert">
            <?= $mensaje ?>
        </div>
    <?php endif; ?>

    <button class="btn btn-success mb-3" onclick="document.getElementById('form-cita').style.display='block';">Agregar Cita</button>

    <!-- Formulario de cita -->
    <div id="form-cita" style="display: <?= (isset($_GET['editar'])) ? 'block' : 'none' ?>;">
        <form method="POST">
            <input type="hidden" name="ID_cita" value="<?= $cita['ID_cita'] ?>">
            <div class="mb-2"><input type="text" class="form-control" name="Nombre" placeholder="Nombre" value="<?= $cita['Nombre'] ?>" required></div>
            <div class="mb-2"><input type="text" class="form-control" name="TELEFONO" placeholder="Teléfono" value="<?= $cita['TELEFONO'] ?>" required></div>
            <div class="mb-2"><input type="date" class="form-control" name="Fecha" value="<?= $cita['Fecha'] ?>" required></div>
            <div class="mb-2"><input type="time" class="form-control" name="HORA" value="<?= $cita['HORA'] ?>" required></div>
            <button type="submit" class="btn btn-primary" name="<?= isset($_GET['editar']) ? 'editar_cita' : 'guardar_cita' ?>">
                <?= isset($_GET['editar']) ? 'Actualizar Cita' : 'Guardar Cita' ?>
            </button>
        </form>
        <hr>
    </div>

    <!-- Tabla de citas -->
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $resultado = mysqli_query($conn, "SELECT * FROM citas");
            while ($fila = mysqli_fetch_assoc($resultado)):
            ?>
                <tr>
                    <td><?= $fila['ID_cita'] ?></td>
                    <td><?= $fila['Nombre'] ?></td>
                    <td><?= $fila['TELEFONO'] ?></td>
                    <td><?= $fila['Fecha'] ?></td>
                    <td><?= $fila['HORA'] ?></td>
                    <td>
                        <a href="index.php?editar=<?= $fila['ID_cita'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="index.php?eliminar=<?= $fila['ID_cita'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta cita?');">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Mensaje desaparece después de unos segundos -->
<script>
    setTimeout(function () {
        var alerta = document.getElementById('mensaje-alerta');
        if (alerta) {
            alerta.style.display = 'none';
        }
    }, 3000);
</script>

<?php include("template/pie.php"); ?>





