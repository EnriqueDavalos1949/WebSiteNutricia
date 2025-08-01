<?php
include("config/DB.php");

// Verificar que se proporcionó un idPac válido
if (!isset($_GET['idPac'])) {
    echo "ID de paciente no especificado.";
    exit;
}

$idPac = intval($_GET['idPac']);

// Procesar formularios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table = $_POST['table'] ?? '';
    $action = $_POST['action'] ?? '';

    // Generar query dinámico según la tabla
    switch ($table) {
        case 'healthstate':
            // Recibir los estados de salud seleccionados
            $nauseas = isset($_POST['nauseas']) ? 1 : 0;
            $vomito = isset($_POST['vomito']) ? 1 : 0;
            $diarrea = isset($_POST['diarrea']) ? 1 : 0;
            $estreñimiento = isset($_POST['estreñimiento']) ? 1 : 0;
            $reflujo = isset($_POST['reflujo']) ? 1 : 0;
            $gastritis = isset($_POST['gastritis']) ? 1 : 0;
            $disfagia = isset($_POST['disfagia']) ? 1 : 0;
        
            // Manejo del campo 'otro', con sanitización
            $otro = isset($_POST['otro']) ? $_POST['otro'] : '';  // Usamos cadena vacía por defecto
            $otro = htmlspecialchars($otro, ENT_QUOTES);  // Sanitizamos el valor de 'otro' para evitar inyecciones
        
            // Preparar la consulta
            $query = "INSERT INTO healthstate (idPac, nauseas, vomito, diarrea, estreñimiento, reflujo, gastritis, disfagia, otro) 
                      VALUES ($idPac, $nauseas, $vomito, $diarrea, $estreñimiento, $reflujo, $gastritis, $disfagia, '$otro') 
                      ON DUPLICATE KEY UPDATE 
                      nauseas = $nauseas, vomito = $vomito, diarrea = $diarrea, 
                      estreñimiento = $estreñimiento, reflujo = $reflujo, gastritis = $gastritis, disfagia = $disfagia, 
                      otro = '$otro'";
            break;
        

        

        case 'ec':
            // Recibir las enfermedades seleccionadas
            $diabetes = isset($_POST['diabetes']) ? 1 : 0;
            $HTA = isset($_POST['HTA']) ? 1 : 0;
            $COLESTEROL = isset($_POST['COLESTEROL']) ? 1 : 0;
            $TRIGLICERIDOS = isset($_POST['TRIGLICERIDOS']) ? 1 : 0;
            $ERENAL = isset($_POST['ERENAL']) ? 1 : 0;
            $CANCER = isset($_POST['CANCER']) ? 1 : 0;
            $HG = isset($_POST['HG']) ? 1 : 0;
            $TCA = isset($_POST['TCA']) ? 1 : 0;
            $OTRO = $_POST['OTRO'] ?? '';

            $query = "INSERT INTO ec (idPac, diabetes, HTA, COLESTEROL, TRIGLICERIDOS, ERENAL, CANCER, HG, TCA, OTRO) 
                      VALUES ($idPac, $diabetes, $HTA, $COLESTEROL, $TRIGLICERIDOS, $ERENAL, $CANCER, $HG, $TCA, '$OTRO') 
                      ON DUPLICATE KEY UPDATE diabetes = $diabetes, HTA = $HTA, COLESTEROL = $COLESTEROL, 
                      TRIGLICERIDOS = $TRIGLICERIDOS, ERENAL = $ERENAL, CANCER = $CANCER, HG = $HG, 
                      TCA = $TCA, OTRO = '$OTRO'";
            break;

        case 'hf':
            // Recibir las enfermedades heredofamiliares seleccionadas
            $CANCER = isset($_POST['CANCER']) ? 1 : 0;
            $DIABETES = isset($_POST['DIABETES']) ? 1 : 0;
            $TA = isset($_POST['TA']) ? 1 : 0;
            $OBESIDAD = isset($_POST['OBESIDAD']) ? 1 : 0;
            $GENETICA = isset($_POST['GENETICA']) ? 1 : 0;
            $GASTRO = isset($_POST['GASTRO']) ? 1 : 0;
            $OTRO = $_POST['OTRO'] ?? '';
        
            $query = "INSERT INTO hf (idPac, CANCER, DIABETES, TA, OBESIDAD, GENETICA, GASTRO, OTRO) 
                        VALUES ($idPac, $CANCER, $DIABETES, $TA, $OBESIDAD, $GENETICA, $GASTRO, '$OTRO') 
                        ON DUPLICATE KEY UPDATE CANCER = $CANCER, DIABETES = $DIABETES, TA = $TA, 
                        OBESIDAD = $OBESIDAD, GENETICA = $GENETICA, GASTRO = $GASTRO, OTRO = '$OTRO'";
            break;
        case 'nutricion':
            // Recibir los datos relacionados con nutrición
            $apetito = $_POST['apetito'] ?? '';
            $haModificadoAlimentacion = isset($_POST['haModificadoAlimentacion']) ? 1 : 0;
            $quienPrepara = $_POST['quienPrepara'] ?? '';
            $motivoPreparacion = $_POST['motivoPreparacion'] ?? '';
            $alimentosPreferidos = $_POST['alimentosPreferidos'] ?? '';
            $alimentosNoPreferidos = $_POST['alimentosNoPreferidos'] ?? '';
            $alergias = $_POST['alergias'] ?? '';
            $suplementos = $_POST['suplementos'] ?? '';
            $consumoSal = $_POST['consumoSal'] ?? '';
            $variaCuandoEmocional = isset($_POST['variaCuandoEmocional']) ? 1 : 0;
            $grasaUsada = $_POST['grasaUsada'] ?? '';
            $haSeguidoDieta = isset($_POST['haSeguidoDieta']) ? 1 : 0;
            $haUsadoMedicamentos = isset($_POST['haUsadoMedicamentos']) ? 1 : 0;
            $TipoDieta = $_POST['TipoDieta'] ?? '';
            $TiempoDieta = $_POST['TiempoDieta'] ?? '';
            $DuracionDieta = $_POST['DuracionDieta'] ?? '';
            $MedDieta = $_POST['MedDieta'] ?? '';
            $ResDieta = $_POST['ResDieta'] ?? '';

            $query = "INSERT INTO nutricion (idPac, apetito, haModificadoAlimentacion, quienPrepara, motivoPreparacion, 
            alimentosPreferidos, alimentosNoPreferidos, alergias, suplementos, consumoSal, 
            variaCuandoEmocional, grasaUsada, haSeguidoDieta, haUsadoMedicamentos, TipoDieta, TiempoDieta, DuracionDieta, MedDieta, ResDieta) 
    VALUES ($idPac, '$apetito', $haModificadoAlimentacion, '$quienPrepara', '$motivoPreparacion', 
            '$alimentosPreferidos', '$alimentosNoPreferidos', '$alergias', '$suplementos', '$consumoSal', 
            $variaCuandoEmocional, '$grasaUsada', $haSeguidoDieta, $haUsadoMedicamentos, 
            '$TipoDieta', '$TiempoDieta', '$DuracionDieta', '$MedDieta', '$ResDieta') 
    ON DUPLICATE KEY UPDATE 
            apetito = '$apetito', 
            haModificadoAlimentacion = $haModificadoAlimentacion, 
            quienPrepara = '$quienPrepara', 
            motivoPreparacion = '$motivoPreparacion', 
            alimentosPreferidos = '$alimentosPreferidos', 
            alimentosNoPreferidos = '$alimentosNoPreferidos', 
            alergias = '$alergias', 
            suplementos = '$suplementos', 
            consumoSal = '$consumoSal', 
            variaCuandoEmocional = $variaCuandoEmocional, 
            grasaUsada = '$grasaUsada', 
            haSeguidoDieta = $haSeguidoDieta, 
            haUsadoMedicamentos = $haUsadoMedicamentos, 
            TipoDieta = '$TipoDieta', 
            TiempoDieta = '$TiempoDieta', 
            DuracionDieta = '$DuracionDieta', 
            MedDieta = '$MedDieta', 
            ResDieta = '$ResDieta'";

            break;
    

        case 'med':
            if ($action === 'delete') {
                $idMed = intval($_POST['idMed']);
                $query = "DELETE FROM med WHERE idMed = $idMed AND idPac = $idPac";
            } else {
                $medicamento = $_POST['medicamento'] ?? '';
                $dosis = $_POST['dosis'] ?? '';
                $via = $_POST['via'] ?? '';
                $frecuencia = $_POST['frecuencia'] ?? '';
                $query = "INSERT INTO med (idPac, medicamento, dosis, via, frecuencia) 
                            VALUES ($idPac, '$medicamento', '$dosis', '$via', '$frecuencia')";
            }
            break;
        case 'dh':
            if ($action === 'delete') {
                $idDH = intval($_POST['idDH']); // ID del registro de dieta habitual
                $query = "DELETE FROM dh WHERE idDH = $idDH AND idPac = $idPac";
            } else {
                // Obtener los valores enviados desde el formulario
                $momento = $_POST['Momento'] ?? '';
                $FOOD = $_POST['FOOD'] ?? '';
                $hora = $_POST['Hora'] ?? '';
                $lugar = $_POST['Lugar'] ?? '';
        
                // Preparar la consulta para insertar un nuevo registro de dieta habitual
                $query = "INSERT INTO dh(idPac, Momento, FOOD, Hora, Lugar) 
                            VALUES ($idPac, '$momento', '$FOOD', '$hora', '$lugar')";
            }
            break;
            

        case 'gral':

            $data = $_POST['DATA'] ?? '';
        
            $query = "INSERT INTO gral(idPac, DATA)
                        VALUES ($idPac, '$data')";
            break;

        default:
            $query = '';
    }

    if (!empty($query)) {
        if (mysqli_query($conn, $query)) {
            echo "<div class='alert alert-success'>Datos guardados correctamente en la tabla $table.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al guardar los datos: " . mysqli_error($conn) . "</div>";
        }
    }
}

// Consultas de datos
$paciente = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pxreg WHERE idPac = $idPac"));
$healthstate = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM healthstate WHERE idPac = $idPac"));
$ec = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM ec WHERE idPac = $idPac"));
$hf = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM hf WHERE idPac = $idPac"));
$meds = mysqli_query($conn, "SELECT * FROM med WHERE idPac = $idPac");
$dh = mysqli_query($conn, "SELECT * FROM dh WHERE idPac = $idPac");
$gral = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM gral WHERE idPac = $idPac"));

include("template/cabecera.php");
?>

<div class="container mt-4">
    <h2>Información del Paciente: <?= htmlspecialchars($paciente['name']) ?></h2>
    <div class="accordion" id="accordionExample">

        <!-- Estado de Salud -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingHealthstate">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHealthstate">
                    Estado de Salud
                </button>
            </h2>
            <div id="collapseHealthstate" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <form method="POST">
                        <input type="hidden" name="table" value="healthstate">
                        <!-- Campos de checkboxes para el estado de salud -->
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="nauseas" 
                            <?= isset($healthstate['nauseas']) && $healthstate['nauseas'] ? 'checked' : '' ?>> Náuseas
                        </div>                        <div class="form-check"><input class="form-check-input" type="checkbox" name="vomito" <?= $healthstate['vomito'] ? 'checked' : '' ?>> Vómito</div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="diarrea" <?= isset($healthstate['diarrea']) && $healthstate['diarrea'] ? 'checked' : '' ?>> Diarrea
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="estreñimiento" <?= isset($healthstate['estreñimiento']) && $healthstate['estreñimiento'] ? 'checked' : '' ?>> Estreñimiento
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="reflujo" <?= isset($healthstate['reflujo']) && $healthstate['reflujo'] ? 'checked' : '' ?>> Reflujo
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="gastritis" <?= isset($healthstate['gastritis']) && $healthstate['gastritis'] ? 'checked' : '' ?>> Gastritis
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="disfagia" <?= isset($healthstate['disfagia']) && $healthstate['disfagia'] ? 'checked' : '' ?>> Disfagia
                        </div>
                        <input class="form-control mt-2" type="text" name="otro" placeholder="Otro..." value="<?= isset($healthstate['otro']) ? htmlspecialchars($healthstate['otro']) : '' ?>">

                        <button class="btn btn-primary mt-2">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
        <!--Enfermedades crónicas -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingec">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseec">
                    Enfermedades crónicas
                </button>
            </h2>
            <div id="collapseec" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <form method="POST">
                        <input type="hidden" name="table" value="ec">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="diabetes" <?= isset($ec['diabetes']) && $ec['diabetes'] ? 'checked' : '' ?>> Diabetes
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="HTA" <?= isset($ec['HTA']) && $ec['HTA'] ? 'checked' : '' ?>> HTA
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="COLESTEROL" <?= isset($ec['COLESTEROL']) && $ec['COLESTEROL'] ? 'checked' : '' ?>> Colesterol
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="TRIGLICERIDOS" <?= isset($ec['TRIGLICERIDOS']) && $ec['TRIGLICERIDOS'] ? 'checked' : '' ?>> Trigliceridos
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="ERENAL" <?= isset($ec['ERENAL']) && $ec['ERENAL'] ? 'checked' : '' ?>> Enfermedades renales
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="CANCER" <?= isset($ec['CANCER']) && $ec['CANCER'] ? 'checked' : '' ?>> Cáncer
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="HG" <?= isset($ec['HG']) && $ec['HG'] ? 'checked' : '' ?>> Hígado graso
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="TCA" <?= isset($ec['TCA']) && $ec['TCA'] ? 'checked' : '' ?>> TCA
                        </div>

                        <input class="form-control mt-2" type="text" name="OTRO" placeholder="Otro.." value="<?= htmlspecialchars($ec['OTRO']) ?>">
                        <button class="btn btn-primary mt-2">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>


        <!--Enfermedades heredofamiliares-->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headinghf">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsehf">
                    Enfermedades heredofamiliares
                </button>
            </h2>
            <div id="collapsehf" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <form method="POST">
                        <input type="hidden" name="table" value="hf">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="CANCER" <?= isset($hf['CANCER']) && $hf['CANCER'] ? 'checked' : '' ?>> Cáncer
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="DIABETES" <?= isset($hf['DIABETES']) && $hf['DIABETES'] ? 'checked' : '' ?>> Diabetes
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="TA" <?= isset($hf['TA']) && $hf['TA'] ? 'checked' : '' ?>> T/A
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="OBESIDAD" <?= isset($hf['OBESIDAD']) && $hf['OBESIDAD'] ? 'checked' : '' ?>> Obesidad
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="GENETICA" <?= isset($hf['GENETICA']) && $hf['GENETICA'] ? 'checked' : '' ?>> Genética
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="GASTRO" <?= isset($hf['GASTRO']) && $hf['GASTRO'] ? 'checked' : '' ?>> Gastrointestinales
                        </div>

                        <input class="form-control mt-2" type="text" name="OTRO" placeholder="Otro..." value="<?= htmlspecialchars($hf['OTRO']) ?>">
                        <button class="btn btn-primary mt-2">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="accordion mt-4" id="accordionMed">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingMed">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMed" aria-expanded="false" aria-controls="collapseMed">
                Medicamentos
            </button>
        </h2>
        <div id="collapseMed" class="accordion-collapse collapse" aria-labelledby="headingMed" data-bs-parent="#accordionMed">
            <div class="accordion-body">

                <!-- Formulario para agregar medicamento -->
                <form method="POST">
                    <input type="hidden" name="table" value="med">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="medicamento" class="form-label">Medicamento:</label>
                            <input type="text" class="form-control" id="medicamento" name="medicamento" required>
                        </div>
                        <div class="col-md-3">
                            <label for="dosis" class="form-label">Dosis:</label>
                            <input type="text" class="form-control" id="dosis" name="dosis" required>
                        </div>
                        <div class="col-md-3">
                            <label for="via" class="form-label">Vía:</label>
                            <input type="text" class="form-control" id="via" name="via" required>
                        </div>
                        <div class="col-md-3">
                            <label for="frecuencia" class="form-label">Frecuencia:</label>
                            <input type="text" class="form-control" id="frecuencia" name="frecuencia" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Agregar Medicamento</button>
                </form>

                <!-- Lista de medicamentos -->
                <h5 class="mt-4">Medicamentos registrados:</h5>
        <ul class="list-group">
            <?php while ($med = mysqli_fetch_assoc($meds)): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong><?= htmlspecialchars($med['medicamento']) ?></strong><br>
                        Dosis: <?= htmlspecialchars($med['dosis']) ?> |
                        Vía: <?= htmlspecialchars($med['via']) ?> |
                        Frecuencia: <?= htmlspecialchars($med['frecuencia']) ?>
                    </div>
                    <form method="POST" class="ms-3">
                        <input type="hidden" name="table" value="med">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="idMed" value="<?= $med['idMed'] ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </li>
            <?php endwhile; ?>
        </ul>
            </div>
        </div>
    </div>
</div>


<div class="accordion mt-4" id="accordionDH">
    <div class="accordion-item">
        <h2 class="accordion-header" id="headingDH">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDH" aria-expanded="false" aria-controls="collapseDH">
                Dieta Habitual
            </button>
        </h2>
        <div id="collapseDH" class="accordion-collapse collapse" aria-labelledby="headingDH" data-bs-parent="#accordionDH">
            <div class="accordion-body">

                <!-- Formulario para agregar dieta habitual -->
                <form method="POST">
                    <input type="hidden" name="table" value="dh">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="Momento" class="form-label">Momento:</label>
                            <input type="text" class="form-control" id="Momento" name="Momento" required>
                        </div>
                        <div class="col-md-3">
                            <label for="FOOD" class="form-label">Alimentos y Bebidas:</label>
                            <input type="text" class="form-control" id="FOOD" name="FOOD" required>
                        </div>
                        <div class="col-md-3">
                            <label for="Hora" class="form-label">Hora:</label>
                            <input type="text" class="form-control" id="Hora" name="Hora" required>
                        </div>
                        <div class="col-md-3">
                            <label for="Lugar" class="form-label">Lugar:</label>
                            <input type="text" class="form-control" id="Lugar" name="Lugar" required>
                        </div>
                    </div>
                    <input type="hidden" name="idPac" value="<?= $idPac ?>"> <!-- Asegúrate de que $idPac esté definido -->
                    <button type="submit" class="btn btn-success mt-3">Agregar Dieta Habitual</button>
                </form>

                <!-- Lista de dietas habituales registradas -->
                <h5 class="mt-4">Dietas Habituales Registradas:</h5>
                <ul class="list-group mt-3">
                    <?php
                    $dhQuery = mysqli_query($conn, "SELECT * FROM dh WHERE idPac = $idPac");
                    while ($dh = mysqli_fetch_assoc($dhQuery)): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?= htmlspecialchars($dh['Momento']) ?></strong><br>
                                Alimentos: <?= htmlspecialchars($dh['FOOD']) ?> |
                                Hora: <?= htmlspecialchars($dh['Hora']) ?> |
                                Lugar: <?= htmlspecialchars($dh['Lugar']) ?>
                            </div>
                            <form method="POST" class="ms-3">
                                <input type="hidden" name="table" value="dh">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="idDH" value="<?= $dh['idDH'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </li>
                    <?php endwhile; ?>
                </ul>

            </div>
        </div>
    </div>
</div>


        <!--Aspectos físicos generales-->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headinggral">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsegral">
                    Aspectos físicos generales
                </button>
            </h2>
            <div id="collapsegral" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <form method="POST">
                        <input type="hidden" name="table" value="gral">
                        <!-- Campos de checkboxes para el estado de salud -->
                        <input class="form-control mt-2" type="text" name="DATA" placeholder="Aspectos generales..." value="<?= htmlspecialchars($gral['DATA']) ?>">
                        <button class="btn btn-primary mt-2">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>


        <!--Aspectos nutricionales-->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingnut">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsenut">
                    Evaluación dietética y actividad física
                </button>
            </h2>
            <div id="collapsenut" class="accordion-collapse collapse">
                <div class="accordion-body">
                    <form method="POST">
                        <input type="hidden" name="table" value="nutricion">
                        <!-- Campos de checkboxes para el estado de salud -->
                        <div class="form-group">
                            <label for="apetito">Apetito:</label>
                            <input class="form-control" type="text" name="apetito" value="<?= htmlspecialchars($nutricion['apetito'] ?? '') ?>">
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="haModificadoAlimentacion" <?= !empty($nutricion['haModificadoAlimentacion']) ? 'checked' : '' ?>>
                            <label class="form-check-label">¿Ha modificado su alimentación recientemente?</label>
                        </div>

                        <div class="form-group mt-2">
                            <label for="quienPrepara">¿Quién prepara sus alimentos?</label>
                            <input class="form-control" type="text" name="quienPrepara" value="<?= htmlspecialchars($nutricion['quienPrepara'] ?? '') ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="alimentosPreferidos">Alimentos preferidos:</label>
                            <textarea class="form-control" name="alimentosPreferidos"><?= htmlspecialchars($nutricion['alimentosPreferidos'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="alimentosNoPreferidos">Alimentos no preferidos:</label>
                            <textarea class="form-control" name="alimentosNoPreferidos"><?= htmlspecialchars($nutricion['alimentosNoPreferidos'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="alergias">Alergias:</label>
                            <textarea class="form-control" name="alergias"><?= htmlspecialchars($nutricion['alergias'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="suplementos">¿Consume suplementos?</label>
                            <textarea class="form-control" name="suplementos"><?= htmlspecialchars($nutricion['suplementos'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="consumoSal">¿Cómo es su consumo de sal?</label>
                            <input class="form-control" type="text" name="consumoSal" value="<?= htmlspecialchars($nutricion['consumoSal'] ?? '') ?>">
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="variaCuandoEmocional" <?= !empty($nutricion['variaCuandoEmocional']) ? 'checked' : '' ?>>
                            <label class="form-check-label">¿Varía su alimentación con el estado emocional?</label>
                        </div>

                        <div class="form-group mt-2">
                            <label for="grasaUsada">Tipo de grasa que utiliza:</label>
                            <textarea class="form-control" name="grasaUsada"><?= htmlspecialchars($nutricion['grasaUsada'] ?? '') ?></textarea>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="haSeguidoDieta" <?= !empty($nutricion['haSeguidoDieta']) ? 'checked' : '' ?>>
                            <label class="form-check-label">¿Ha seguido alguna dieta?</label>
                        </div>
                        <h2>*En caso de que haya seguido alguna dieta</h2>
                        <div class="form-group">
                            <label for="TipoDieta">¿Qué tipo de dieta?:</label>
                            <textarea class="form-control" name="TipoDieta"><?= htmlspecialchars($nutricion['TipoDieta'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="TiempoDieta">¿Hace cuanto tiempo?</label>
                            <textarea class="form-control" name="TiempoDieta"><?= htmlspecialchars($nutricion['TiempoDieta'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="DuracionDieta">¿Durante cuanto tiempo?</label>
                            <textarea class="form-control" name="DuracionDieta"><?= htmlspecialchars($nutricion['DuracionDieta'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="ResDieta">¿Obtuvo los resultados esperados?</label>
                            <textarea class="form-control" name="ResDieta"><?= htmlspecialchars($nutricion['ResDieta'] ?? '') ?></textarea>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="haUsadoMedicamentos" <?= !empty($nutricion['haUsadoMedicamentos']) ? 'checked' : '' ?>>
                            <label class="form-check-label">¿Ha utilizado medicamentos para bajar de peso?</label>
                        </div>
                        <h2>*En caso de que haya consumido algun medicamento para bajar de peso</h2>
                        <div class="form-group">
                            <label for="MedDieta">¿Cuales medicamentos?:</label>
                            <textarea class="form-control" name="MedDieta"><?= htmlspecialchars($nutricion['MedDieta'] ?? '') ?></textarea>
                        </div>

                        <button class="btn btn-primary mt-3">Guardar Cambios</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="registros.php" class="btn btn-secondary mt-4">Regresar</a>
<a href="InfoPerson.php?idPac=<?= $idPac ?>" class="btn btn-info mt-3">Ver Info</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include("template/pie.php"); ?>
