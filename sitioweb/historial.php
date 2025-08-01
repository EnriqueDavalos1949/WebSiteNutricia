<?php include("template/cabecera.php"); ?>
<?php include("config/DB.php"); ?>

<?php
// Obtener idPac desde GET
$idPac = isset($_GET['idPac']) ? intval($_GET['idPac']) : 0;
$nombrePaciente = "";

// Consultar el nombre del paciente usando mysqli
if ($idPac > 0) {
    $stmt = $conn->prepare("SELECT name FROM pxreg WHERE idPac = ?");
    $stmt->bind_param("i", $idPac);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($fila = $resultado->fetch_assoc()) {
        $nombrePaciente = $fila['name'];
    }
    $stmt->close();
}

// Consultar las fechas disponibles en la tabla generall para el paciente
$fechasDisponibles = [];
if ($idPac > 0) {
    $stmtFechas = $conn->prepare("SELECT FECHAGRAL FROM generall WHERE idPac = ? ORDER BY FECHAGRAL DESC");
    $stmtFechas->bind_param("i", $idPac);
    $stmtFechas->execute();
    $resultadoFechas = $stmtFechas->get_result();
    
    while ($filaFecha = $resultadoFechas->fetch_assoc()) {
        $fechasDisponibles[] = $filaFecha['FECHAGRAL'];
    }
    $stmtFechas->close();
}

// Obtener la fecha seleccionada (si está definida)
$fechaSeleccionada = isset($_GET['fecha']) ? $_GET['fecha'] : '';
if (isset($_POST['eliminar'])) {
    $tabla = $_POST['tabla'];
    $idPac = $_POST['idPac'];
    $fecha = $_POST['fecha'];

    // Relación tabla -> columna de fecha
    $columnasFecha = [
        'lipidos' => 'FECHALIPIDOS',
        'proteina' => 'FECHAPROTE',
        'carbos' => 'FECHACARBOS',
        'generall' => 'FECHAGRAL',
        'energnutri' => 'FECHANEC',
        'antropometria' => 'FECHAANTRO',
        'ibqm' => 'FECHAIBQM'
    ];

    if (array_key_exists($tabla, $columnasFecha)) {
        $colFecha = $columnasFecha[$tabla];

        // Validar que la tabla y columna no se inyecten manualmente
        $allowedTables = array_keys($columnasFecha);
        if (in_array($tabla, $allowedTables)) {
            $stmt = $conn->prepare("DELETE FROM `$tabla` WHERE idPac = ? AND `$colFecha` = ?");
            $stmt->bind_param("is", $idPac, $fecha);
            $stmt->execute();
            $stmt->close();
        }
    }
}


?>

<div class="container mt-4">
    <h3>Historia Nutricional</h3>

    <!-- Mostrar el nombre del paciente -->
    <?php if (!empty($nombrePaciente)): ?>
        <h4>Paciente: <?php echo htmlspecialchars($nombrePaciente); ?></h4>
    <?php else: ?>
        <p>No se encontró el paciente.</p>
    <?php endif; ?>

    <!-- Formulario para seleccionar la fecha -->
    <?php if (count($fechasDisponibles) > 0): ?>
        <form method="GET" action="historial.php">
            <input type="hidden" name="idPac" value="<?php echo $idPac; ?>">
            <div class="form-group">
                <label for="fecha">Seleccionar fecha:</label>
                <select name="fecha" id="fecha" class="form-control" required>
                    <option value="">Seleccione una fecha</option>
                    <?php foreach ($fechasDisponibles as $fecha): ?>
                        <option value="<?php echo $fecha; ?>" <?php echo $fecha == $fechaSeleccionada ? 'selected' : ''; ?>>
                            <?php echo $fecha; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Consultar</button>
        </form>

        <form method="POST" class="row g-3">
        <div class="col-md-4">
            <label for="tabla" class="form-label">Seleccionar tabla</label>
            <select name="tabla" class="form-select" required>
            <option value="lipidos">Lípidos</option>
            <option value="proteina">Proteína</option>
            <option value="carbos">Carbohidratos</option>
            <option value="energnutri">Necesidades Energéticas y Nutrimentales</option>
            <option value="generall">Observaciones Generales</option>
            <option value="antropometria">Antropometría</option>
            <option value="ibqm">Bioquímico</option>
            </select>
        </div>

        <!-- Valores ocultos -->
        <input type="hidden" name="idPac" value="<?php echo $idPac; ?>">
        <input type="hidden" name="fecha" value="<?php echo $fechaSeleccionada; ?>">

        <div class="col-md-4 align-self-end">
            <button type="submit" name="eliminar" class="btn btn-danger w-100">Eliminar Registro</button>
        </div>
        </form>




    <?php else: ?>
        <p>No hay fechas disponibles para este paciente.</p>
    <?php endif; ?>

    <hr>

    <!-- Mostrar el PDF generado si la fecha está seleccionada -->
    <?php if ($idPac > 0 && !empty($fechaSeleccionada)): ?>
        <h5>Mostrando historial nutricional para la fecha: <?php echo htmlspecialchars($fechaSeleccionada); ?></h5>
        <iframe src="PDFHist.php?idPac=<?php echo $idPac; ?>&fecha=<?php echo $fechaSeleccionada; ?>" width="100%" height="600px" style="border:1px solid #ccc;"></iframe>
    <?php endif; ?>
</div>

<?php include("template/pie.php"); ?>










