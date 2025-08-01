<?php
include("config/DB.php");
include("template/cabecera.php");

if (!isset($_GET['idPac'])) {
    echo "<div class='container mt-4'><div class='alert alert-danger'>ID de paciente no proporcionado.</div></div>";
    include("template/pie.php");
    exit;
}

$idPac = intval($_GET['idPac']);
?>

<div class="container mt-4">
    <h2>Datos del Paciente</h2>
    <hr>

    <!-- ========== Tabla Healthstate ========== -->
    <h4>Estado de salud</h4>
    <?php
    $sql = "SELECT * FROM healthstate WHERE idPac = $idPac ORDER BY folioState DESC LIMIT 1";
    $res = mysqli_query($conn, $sql);
    if ($res && mysqli_num_rows($res) > 0) {
        $r = mysqli_fetch_assoc($res);
        echo "<table class='table table-bordered'>
            <tr><th>Náuseas</th><th>Vómito</th><th>Diarrea</th><th>Estreñimiento</th><th>Reflujo</th><th>Gastritis</th><th>Disfagia</th><th>Otro</th></tr>
            <tr>
            <td>" . ($r['nauseas'] ? 'Sí' : 'No') . "</td>
            <td>" . ($r['vomito'] ? 'Sí' : 'No') . "</td>
            <td>" . ($r['diarrea'] ? 'Sí' : 'No') . "</td>
            <td>" . ($r['estreñimiento'] ? 'Sí' : 'No') . "</td>
            <td>" . ($r['reflujo'] ? 'Sí' : 'No') . "</td>
            <td>" . ($r['gastritis'] ? 'Sí' : 'No') . "</td>
            <td>" . ($r['disfagia'] ? 'Sí' : 'No') . "</td>
            <td>" . htmlspecialchars($r['otro']) . "</td>
            </tr></table>";
    } else {
        echo "<p>No hay datos de estado de salud.</p>";
    }
    ?>

    <!-- ========== Tabla ec ========== -->
    <h4>Enfermedades Crónicas</h4>
    <?php
    $res = mysqli_query($conn, "SELECT * FROM ec WHERE idPac = $idPac ORDER BY folioEC DESC LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $r = mysqli_fetch_assoc($res);
        echo "<table class='table table-bordered'>
        <tr><th>Diabetes</th><th>HTA</th><th>Colesterol</th><th>Triglicéridos</th><th>Enf. Renal</th><th>Cáncer</th><th>HG</th><th>TCA</th><th>Otro</th></tr>
        <tr>
        <td>" . ($r['diabetes'] ? 'Sí' : 'No') . "</td>
        <td>" . ($r['HTA'] ? 'Sí' : 'No') . "</td>
        <td>" . ($r['COLESTEROL'] ? 'Sí' : 'No') . "</td>
        <td>" . ($r['TRIGLICERIDOS'] ? 'Sí' : 'No') . "</td>
        <td>" . ($r['ERENAL'] ? 'Sí' : 'No') . "</td>
        <td>" . ($r['CANCER'] ? 'Sí' : 'No') . "</td>
        <td>" . ($r['HG'] ? 'Sí' : 'No') . "</td>
        <td>" . ($r['TCA'] ? 'Sí' : 'No') . "</td>
        <td>" . htmlspecialchars($r['OTRO']) . "</td>
        </tr></table>";
    } else {
        echo "<p>No hay datos de EC.</p>";
    }
    ?>

    <!-- ========== Tabla hf ========== -->
    <h4>Enfermedades heredofamiliares</h4>
    <?php
    $res = mysqli_query($conn, "SELECT * FROM hf WHERE idPac = $idPac ORDER BY folioHF DESC LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $r = mysqli_fetch_assoc($res);
        echo "<table class='table table-bordered'>
        <tr><th>Cáncer</th><th>Diabetes</th><th>TA</th><th>Obesidad</th><th>Genética</th><th>Gastrointestinales</th><th>Otro</th></tr>
        <tr>
        <td>" . ($r['CANCER'] ? 'Sí' : 'No') . "</td>
        <td>" . ($r['DIABETES'] ? 'Sí' : 'No') . "</td>
        <td>" . ($r['TA'] ? 'Sí' : 'No') . "</td>
        <td>" . ($r['OBESIDAD'] ? 'Sí' : 'No') . "</td>
        <td>" . ($r['GENETICA'] ? 'Sí' : 'No') . "</td>
        <td>" . ($r['GASTRO'] ? 'Sí' : 'No') . "</td>
        <td>" . htmlspecialchars($r['OTRO']) . "</td>
        </tr></table>";
    } else {
        echo "<p>No hay datos de historial familiar.</p>";
    }
    ?>

    <!-- ========== Tabla med ========== -->
    <h4>Medicamentos</h4>
    <?php
    $res = mysqli_query($conn, "SELECT * FROM med WHERE idPac = $idPac ORDER BY idMed DESC");
    if ($res && mysqli_num_rows($res) > 0) {
        echo "<table class='table table-bordered'>
            <tr><th>Medicamento</th><th>Dosis</th><th>Vía</th><th>Frecuencia</th></tr>";
        while ($r = mysqli_fetch_assoc($res)) {
            echo "<tr>
                <td>{$r['medicamento']}</td>
                <td>{$r['dosis']}</td>
                <td>{$r['via']}</td>
                <td>{$r['frecuencia']}</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hay datos de medicamentos.</p>";
    }
    ?>


    <!-- ========== Tabla gral ========== -->
    <h4>Aspectos físicos generales</h4>
    <?php
    $res = mysqli_query($conn, "SELECT * FROM gral WHERE idPac = $idPac ORDER BY FOLIO DESC LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $r = mysqli_fetch_assoc($res);
        echo "<p><strong>Datos:</strong> " . htmlspecialchars($r['DATA']) . "</p>";
    } else {
        echo "<p>No hay datos generales.</p>";
    }
    ?>

    <!-- ========== Tabla nutricion ========== -->
    <h4>Evaluación dietética y nutricional</h4>
    <?php
    $res = mysqli_query($conn, "SELECT * FROM nutricion WHERE idPac = $idPac ORDER BY idNutricion DESC LIMIT 1");
    if ($res && mysqli_num_rows($res) > 0) {
        $r = mysqli_fetch_assoc($res);
        echo "<table class='table table-bordered'>
        <tr><th>Apetito</th><th>¿Modificó Alimentación?</th><th>¿Quién Prepara?</th><th>Motivo</th></tr>
        <tr>
            <td>{$r['apetito']}</td>
            <td>" . ($r['haModificadoAlimentacion'] ? 'Sí' : 'No') . "</td>
            <td>{$r['quienPrepara']}</td>
            <td>{$r['motivoPreparacion']}</td>
        </tr>
        <tr><th>Alimentos preferidos</th><th>Alimentos no preferidos</th><th>Alergias</th><th>Suplementos</th></tr>
        <tr>
            <td>{$r['alimentosPreferidos']}</td>
            <td>{$r['alimentosNoPreferidos']}</td>
            <td>{$r['alergias']}</td>
            <td>{$r['suplementos']}</td>
        </tr>
        <tr><th>Consumo de Sal</th><th>cambia apetito cuando está triste, nervioso o ansioso</th><th>Grasa que utiliza para cocción</th><th>Ha seguido dieta</th></tr>
        <tr>
            <td>{$r['consumoSal']}</td>
            <td>" . ($r['variaCuandoEmocional'] ? 'Sí' : 'No') . "</td>
            <td>{$r['grasaUsada']}</td>
            <td>" . ($r['haSeguidoDieta'] ? 'Sí' : 'No') . "</td>
        </tr>
        <tr><th colspan='4'>Ha usado medicamentos para bajar de peso: " . ($r['haUsadoMedicamentos'] ? 'Sí' : 'No') . "</th></tr>
        <tr><th>Tipo de Dieta</th><th>Tiempo de Dieta</th><th>Duración de Dieta</th><th>Medicamentos para bajar de peso</th></tr>
        <tr>
            <td>{$r['TipoDieta']}</td>
            <td>{$r['TiempoDieta']}</td>
            <td>{$r['DuracionDieta']}</td>
            <td>{$r['MedDieta']}</td>
        </tr>
        <tr><th colspan='4'>Respuestas adicionales sobre dieta:</th></tr>
        <tr><td colspan='4'>{$r['ResDieta']}</td></tr>
        </table>";
    } else {
        echo "<p>No hay datos de nutrición.</p>";
    }
    ?>


    <!-- ========== Tabla dh ========== -->
    <h4>Dieta Habitual</h4>
    <?php
    $res = mysqli_query($conn, "SELECT * FROM dh WHERE idPac = $idPac ORDER BY idDH DESC");
    if ($res && mysqli_num_rows($res) > 0) {
        echo "<table class='table table-bordered'>
            <tr><th>Momento</th><th>Alimento</th><th>Hora</th><th>Lugar</th></tr>";
        while ($r = mysqli_fetch_assoc($res)) {
            echo "<tr>
            <td>{$r['Momento']}</td>
            <td>{$r['FOOD']}</td>
            <td>{$r['Hora']}</td>
            <td>{$r['Lugar']}</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hay datos de Diario de Hábitos.</p>";
    }
    ?>| 

        <!-- ========== Botón de edición ========== -->
    <div class="text-center mt-4">
        <a href="personalData.php?idPac=<?php echo $idPac; ?>" class="btn btn-warning btn-lg">Editar</a>
    </div>
</div>

<?php include("template/pie.php"); ?>


