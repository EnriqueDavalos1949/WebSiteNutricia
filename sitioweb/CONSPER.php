<?php include("template/cabecera.php"); ?>
<?php include("config/DB.php"); ?>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPac = $_GET['idPac'] ?? '';
    // Obtener el valor de la actividad física del formulario
    $actividad_fisica = $_POST['actividad_fisica'] ?? '';
    $factor_actividad = 0.00; // Valor por defecto (Sedentario)
    switch ($actividad_fisica) {
        case 'Sedentario':
            $factor_actividad = 1.2;
            break;
        case 'Ligero':
            $factor_actividad = 1.38;
            break;
        case 'Activo':
            $factor_actividad = 1.55;
            break;
        case 'Muy Activo':
            $factor_actividad = 1.73;
            break;
        case 'Extremadamente Activo':
            $factor_actividad = 1.9;
            break;
        default:
            $factor_actividad = 0; // Por si acaso el valor no se encuentra
            break;
    }

    // Obtener PERCENT más reciente de la tabla carbos
    $sql = "SELECT KCAL FROM carbos WHERE idPac = ? ORDER BY FECHACARBOS DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPac);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $KCAL1 = $row ? $row['KCAL'] : 0;

    // Obtener PERCENT más reciente de la tabla lipidos
    $sql = "SELECT KCAL FROM lipidos WHERE idPac = ? ORDER BY FECHALIPIDOS DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPac);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $KCAL2 = $row ? $row['KCAL'] : 0;

    // Obtener PERCENT más reciente de la tabla proteina
    $sql = "SELECT KCAL FROM proteina WHERE idPac = ? ORDER BY FECHAPROTE DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPac);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $KCAL3 = $row ? $row['KCAL'] : 0;

    // Suponiendo que ya tienes la conexión $conn y el id del paciente $idPac
    
    // Obtener PERCENT más reciente de la tabla carbos
    $sql = "SELECT KCAL FROM carbos WHERE idPac = ? ORDER BY FECHACARBOS DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPac);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $KCAL1 = $row ? $row['KCAL'] : 0;
    
    // Obtener PERCENT más reciente de la tabla lipidos
    $sql = "SELECT KCAL FROM lipidos WHERE idPac = ? ORDER BY FECHALIPIDOS DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPac);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $KCAL2 = $row ? $row['KCAL'] : 0;
    
    // Obtener PERCENT más reciente de la tabla proteina
    $sql = "SELECT KCAL FROM proteina WHERE idPac = ? ORDER BY FECHAPROTE DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idPac);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $KCAL3 = $row ? $row['KCAL'] : 0;
    
    // Sumar todos los porcentajes
    $PT = $KCAL1 + $KCAL2 + $KCAL3;
    
    if (empty($idPac)) {
        echo "El ID del paciente es necesario.";
        exit;
    }
    if (isset($_POST['tabla'])) {
        switch ($_POST['tabla']) { /*En esta línea se encuentra el error*/
            case 'ibqm':
                $fecha = date('Y-m-d'); // Fecha actual
                $SIBQM = isset($_POST['SIBQM']) ? 1 : 0;
                $BQM = $_POST['BQM'];
                $fecha = date('Y-m-d'); // Fecha actual
                $sql = "INSERT INTO ibqm (idPac, FECHAIBQM, SIBQM, BQM) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("isis", $idPac, $fecha, $SIBQM, $BQM);
            
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success mt-3'>¡Datos de IBQM guardados correctamente!</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>Error al guardar los datos de IBQM.</div>";
                }
                break;
            case 'antropometria':

                // Insertar datos en la tabla antropometria
                $fecha = date(format: 'Y-m-d'); // Fecha actual
                $sql = "INSERT INTO antropometria (
                            idPac, FECHAANTRO, PESOACT, PESOHAB, ESTATURA, PCT, PCB, PCS, CB, CCIN,
                            CCAD, CABS, COMPLEX, PESOIDEAL, IMC, PESOAJUST, GRASACORP, MASALG, ICINCAD, AMUSCB, AGUACT
                        ) VALUES (
                            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
                        )";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param(
                    "issdddddddddsdddddddd",
                    $idPac, $fecha, $_POST['PESOACT'], $_POST['PESOHAB'], $_POST['ESTATURA'], $_POST['PCT'],
                    $_POST['PCB'], $_POST['PCS'], $_POST['CB'], $_POST['CCIN'], $_POST['CCAD'], $_POST['CABS'],
                    $_POST['COMPLEX'], $_POST['PESOIDEAL'], $_POST['IMC'], $_POST['PESOAJUST'], $_POST['GRASACORP'],
                    $_POST['MASALG'], $_POST['ICINCAD'], $_POST['AMUSCB'], $_POST['AGUACT']
                );
            
                if ($stmt->execute()) {
                    // Obtener datos necesarios para el cálculo del GEB
                    $sqlDatos = "SELECT pxreg.sexo, pxreg.age FROM pxreg WHERE idPac = ?";
                    $stmtDatos = $conn->prepare($sqlDatos);
                    $stmtDatos->bind_param("i", $idPac);
                    $stmtDatos->execute();
                    $result = $stmtDatos->get_result();
            
                    if ($row = $result->fetch_assoc()) {
                        $sexo = strtolower($row['sexo']); // Asegurarse de que sexo esté en minúsculas
                        $edad = (int) $row['age']; // Convertir edad a entero
                        $peso = (float) $_POST['PESOACT']; // Convertir peso a float
                        $estatura = (float) $_POST['ESTATURA']; // Convertir estatura a float
                        
                        // Calcular PESOIDEAL según el sexo
                        if ($sexo == "femenino") {
                            $pesoIdeal = ((($estatura / 100) * ($estatura / 100)) * 21.5); // Para mujeres
                        } elseif ($sexo == "masculino") {
                            $pesoIdeal = ((($estatura / 100) * ($estatura / 100)) * 23); // Para hombres
                        } else {
                            $pesoIdeal = 0; // Valor inválido si el sexo no es "f" o "m"
                        }
            
                        // Calcular IMC (Índice de Masa Corporal)
                        if ($peso > 0 && $estatura > 0) {
                            $imc = $peso / (($estatura / 100) ** 2); // IMC = peso (kg) / estatura^2 (m^2)
                        } else {
                            $imc = 0;
                        }
            
                        // Calcular PESOAJUST utilizando la fórmula corregida
                        $pesoAjustado = $pesoIdeal + (($peso - $pesoIdeal) * 0.25);
            
                        // Actualizar el campo PESOIDEAL, IMC y PESOAJUST en la tabla antropometria
                        $sqlActualizar = "UPDATE antropometria 
                                        SET PESOIDEAL = ?, IMC = ?, PESOAJUST = ? 
                                        WHERE idPac = ? AND FECHAANTRO = ?";
                        $stmtActualizar = $conn->prepare($sqlActualizar);
                        $stmtActualizar->bind_param("dddis", $pesoIdeal, $imc, $pesoAjustado, $idPac, $fecha);
            
                        if ($stmtActualizar->execute()) {
                            echo "<div class='alert alert-success mt-3'>¡Datos de Antropometría, Peso Ideal, IMC y Peso Ajustado guardados correctamente!</div>";
                        } else {
                            echo "<div class='alert alert-danger mt-3'>Error al actualizar los datos en la tabla antropometria.</div>";
                        }
            
                        // Calcular GEB, ETA, AFFE y GETO
                        if ($sexo == "femenino") {
                            $geb = 655.1 + (9.56 * $peso) + (1.85 * $estatura) - (4.67 * $edad);
                        } elseif ($sexo == "masculino") {
                            $geb = 66.47 + (13.75 * $peso) + (5 * $estatura) - (6.76 * $edad);
                        } else {
                            $geb = 0; // Si el sexo es inválido, GEB será 0
                        }
            
                        // Calcular ETA como el 10% de GEB
                        $eta = $geb * 0.1;
            
                        // Obtener el valor de AFFE desde el formulario o de alguna otra fuente
                        // Asegúrate de que el valor de AFFE esté disponible
                        $affe = isset($_POST['AFFE']) ? (float) $_POST['AFFE'] : 0;
            
                        // Calcular GETO como la suma de GEB, ETA y AFFE
                        $geto = $geb + $eta + $affe;
            
                        // Insertar el GEB, ETA, AFFE y GETO calculados en la tabla energnutri
                        $queryGEB = "INSERT INTO energnutri (idPac, FECHANEC, GEB, ETA, AFFE, GETO) VALUES (?, ?, ?, ?, ?, ?)";
                        $stmtGEB = $conn->prepare($queryGEB);
                        $stmtGEB->bind_param("isdddi", $idPac, $fecha, $geb, $eta, $affe, $geto);
            
                        if ($stmtGEB->execute()) {
                            echo "<div class='alert alert-success mt-3'>¡Datos de Antropometría, GEB, ETA, AFFE y GETO guardados correctamente!</div>";
                        } else {
                            echo "<div class='alert alert-danger mt-3'>Error al guardar los datos en energnutri.</div>";
                        }
            
                    } else {
                        echo "<div class='alert alert-danger mt-3'>No se encontraron los datos del paciente.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger mt-3'>Error al guardar los datos de Antropometría.</div>";
                }
                break;
            case 'macros':
                if (isset($_POST['KCALPROP'], $_POST['PERCENTCARBOS'], $_POST['PERCENTLIP'], $_POST['PERCENTPROT'])) {
                    $kcal_total = floatval($_POST['KCALPROP']);
                    $percent_carbos = floatval($_POST['PERCENTCARBOS']);
                    $percent_lip = floatval($_POST['PERCENTLIP']);
                    $percent_prot = floatval($_POST['PERCENTPROT']);
                    
                    $fecha_actual = date('Y-m-d'); // fecha actual
            
                    // Cálculos:
                    $kcal_carbos = ($percent_carbos / 100) * $kcal_total;
                    $grs_carbos = $kcal_carbos / 4;
            
                    $kcal_lip = ($percent_lip / 100) * $kcal_total;
                    $grs_lip = $kcal_lip / 9;
            
                    $kcal_prot = ($percent_prot / 100) * $kcal_total;
                    $grs_prot = $kcal_prot / 4;
            
                    // Insertar en tabla 'carbos'
                    $insert_carbos = $conn->prepare("INSERT INTO carbos (idPac, FECHACARBOS, PERCENT, KCAL, GRS) VALUES (?, ?, ?, ?, ?)");
                    $insert_carbos->bind_param("isddd", $idPac, $fecha_actual, $percent_carbos, $kcal_carbos, $grs_carbos);
                    $insert_carbos->execute();
                    $insert_carbos->close();
            
                    // Insertar en tabla 'lipidos'
                    $insert_lipidos = $conn->prepare("INSERT INTO lipidos (idPac, FECHALIPIDOS, PERCENT, KCAL, GRS) VALUES (?, ?, ?, ?, ?)");
                    $insert_lipidos->bind_param("isddd", $idPac, $fecha_actual, $percent_lip, $kcal_lip, $grs_lip);
                    $insert_lipidos->execute();
                    $insert_lipidos->close();
            
                    // Insertar en tabla 'proteina'
                    $insert_proteina = $conn->prepare("INSERT INTO proteina (idPac, FECHAPROTE, PERCENT, KCAL, GRS) VALUES (?, ?, ?, ?, ?)");
                    $insert_proteina->bind_param("isddd", $idPac, $fecha_actual, $percent_prot, $kcal_prot, $grs_prot);
                    $insert_proteina->execute();
                    $insert_proteina->close();
            
                    // Obtener el último registro en la tabla 'energnutri' para este paciente (idPac)
                    $query_last_record = "SELECT NumENERGNUTRI FROM energnutri WHERE idPac = ? ORDER BY NumENERGNUTRI DESC LIMIT 1";
                    $stmt_last = $conn->prepare($query_last_record);
                    $stmt_last->bind_param("i", $idPac);
                    $stmt_last->execute();
                    $stmt_last->bind_result($last_num);
                    $stmt_last->fetch();
                    $stmt_last->close();
            
                    // Verificar si se encontró un último registro
                    if ($last_num) {
                        // Actualizar el último registro con el valor de KCALPROP
                        $update_kcalprop = $conn->prepare("UPDATE energnutri SET kcalprop = ? WHERE NumENERGNUTRI = ?");
                        $update_kcalprop->bind_param("di", $kcal_total, $last_num);
                        $update_kcalprop->execute();
                        $update_kcalprop->close();
                    }
            
                    // Mostrar un mensaje con los datos
                    echo "<div class='alert alert-success mt-3'>";
                    echo "<h5>Datos guardados correctamente:</h5>";
                    echo "<ul>";
                    echo "<li><strong>Calorías propuestas:</strong> {$kcal_total} Kcal</li>";
                    echo "<li><strong>Carbohidratos:</strong> {$percent_carbos}% - {$kcal_carbos} kcal - {$grs_carbos} g</li>";
                    echo "<li><strong>Lípidos:</strong> {$percent_lip}% - {$kcal_lip} kcal - {$grs_lip} g</li>";
                    echo "<li><strong>Proteína:</strong> {$percent_prot}% - {$kcal_prot} kcal - {$grs_prot} g</li>";
                    echo "</ul>";
                    echo "</div>";
            
                } else {
                    echo "<div class='alert alert-danger mt-3'>Error: No se recibieron todos los datos del formulario.</div>";
                }
                break;                                          
            case 'generall':
                $fecha = date('Y-m-d'); // Obtener la fecha actual
            
                // Asegúrate de haber recibido estas variables vía POST
                $obs = $_POST['OBS'] ?? '';
                $diagn = $_POST['DIAGN'] ?? '';
                $trata = $_POST['TRATA'] ?? '';
            
                // Preparar y ejecutar el INSERT
                $stmt = $conn->prepare("INSERT INTO generall (idPac, FECHAGRAL, OBS, DIAGN, TRATA) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("issss", $idPac, $fecha, $obs, $diagn, $trata);
                
                if ($stmt->execute()) {
                    echo "<div class='alert alert-success mt-3'>Datos generales guardados correctamente.</div>";
                } else {
                    echo "<div class='alert alert-danger mt-3'>Error al guardar datos generales: " . $stmt->error . "</div>";
                }
                break;
            case 'energnutri':
                // Consultar si ya existe un registro para el paciente
                $query = "SELECT GEB, ETA FROM energnutri WHERE idPac = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $idPac);
                $stmt->execute();
                $result = $stmt->get_result();
                // Obtener el último registro en la tabla 'energnutri' para este paciente (idPac)
                $query_last_record = "SELECT NumENERGNUTRI FROM energnutri WHERE idPac = ? ORDER BY NumENERGNUTRI DESC LIMIT 1";
                $stmt_last = $conn->prepare($query_last_record);
                $stmt_last->bind_param("i", $idPac);
                $stmt_last->execute();
                $stmt_last->bind_result($last_num);
                $stmt_last->fetch();
                $stmt_last->close();

                // Verificar si se encontró un último registro
                if ($last_num) {
                    // Actualizar el último registro con el valor de ACTFISICA
                    $update_actfisica = $conn->prepare("UPDATE energnutri SET ACTFISICA = ? WHERE NumENERGNUTRI = ?");
                    $update_actfisica->bind_param("si", $actividad_fisica, $last_num);
                    $update_actfisica->execute();
                    $update_actfisica->close();
                }
                
                if ($result->num_rows > 0) {
                    // Si existe el registro, obtener los valores de GEB y ETA
                    $row = $result->fetch_assoc();
                    $geb = $row['GEB'];
                    $eta = $row['ETA'];
            
                    // Calcular el valor de AFFE
                    $affe = $geb * $factor_actividad;
            
                    // Calcular el valor de GETO (la suma de AFFE, GEB y ETA)
                    $geto = ($geb + $eta)*$factor_actividad;
            
                    // Actualizar la entidad AFFE y GETO en la tabla energnutri
                    $update_query = "UPDATE energnutri SET AFFE = ?, GETO = ? WHERE idPac = ?";
                    $update_stmt = $conn->prepare($update_query);
                    $update_stmt->bind_param("ddi", $affe, $geto, $idPac);
            
                    if ($update_stmt->execute()) {
                        // Opcionalmente puedes mostrar mensaje de éxito aquí
                        // echo "Los valores de AFFE y GETO se han actualizado correctamente.";
                    } else {
                        echo "Hubo un error al actualizar los valores de AFFE y GETO.";
                    }
            
                    $update_stmt->close();
                } else {
                    // Si no existe el registro, insertar un nuevo registro
                    $insert_query = "INSERT INTO energnutri (idPac, GEB, ETA, AFFE, GETO) VALUES (?, 0, 0, ?, ?)";
                    $insert_stmt = $conn->prepare($insert_query);
                    $insert_stmt->bind_param("idd", $idPac, $affe, $geto);
            
                    if ($insert_stmt->execute()) {
                        echo "Se ha creado un nuevo registro para el paciente y se han asignado los valores de AFFE y GETO.";
                    } else {
                        echo "Hubo un error al insertar el nuevo registro en la tabla energnutri.";
                    }
            
                    $insert_stmt->close();
                }
            
                $stmt->close();
                // NO cierres $conn aquí. PHP lo cerrará automáticamente al terminar el script.
                break;                              
                           
            default:
                break;
        }
    }
}
?>

</div>

<div class="container mt-4">
    <div class="container mt-4">
    <h2>Datos del paciente</h2>
    <h5><em>*No ingresar acentos</em></h5>
    <!-- Tabs -->
    <ul class="nav nav-tabs" id="datosTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="ibqm-tab" data-bs-toggle="tab" href="#ibqm" role="tab" aria-controls="ibqm" aria-selected="true">Indicadores Bioquímicos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="antro-tab" data-bs-toggle="tab" href="#antro" role="tab" aria-controls="antro" aria-selected="false">Evaluación Antropométrica</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="energnutri-tab" data-bs-toggle="tab" href="#energnutri" role="tab" aria-controls="energnutri" aria-selected="false">Necesidades energéticas y nutrimentales</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="macros-tab" data-bs-toggle="tab" href="#macros" role="tab" aria-controls="macros" aria-selected="false">Macronutrientes Esenciales</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="generall-tab" data-bs-toggle="tab" href="#generall" role="tab" aria-controls="generall" aria-selected="false">Observaciones Generales</a>
        </li>
    </ul>

    <div class="tab-content mt-3">
        <!-- IBQM -->
        <div class="tab-pane fade show active" id="ibqm" role="tabpanel" aria-labelledby="ibqm-tab">
            <form method="POST">
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="SIBQM" name="SIBQM">
                    <label class="form-check-label" for="SIBQM">¿Se solicitaron análisis Bioquímicos?</label>
                </div>

                <div class="form-group mt-2">
                    <label for="BQM">Datos relevantes:</label>
                    <input type="text" class="form-control" id="BQM" name="BQM">
                </div>

                <!-- Campo oculto para la fecha de consulta -->
                <?php if (isset($_SESSION['ConsDate'])): ?>
                    <input type="hidden" name="ConsDate" value="<?php echo htmlspecialchars($_SESSION['ConsDate']); ?>">
                <?php endif; ?>

                <input type="hidden" name="tabla" value="ibqm">
                <button type="submit" class="btn btn-primary mt-3" name="guardar_ibqm">Guardar</button>
            </form>
        </div>

        <!-- Antropometría -->
        <div class="tab-pane fade" id="antro" role="tabpanel" aria-labelledby="antro-tab">
            <form method="POST">
                <div class="row">
                <?php
                $campos = [
                    'PESOACT'=>'Peso Actual [Kg]', 'PESOHAB'=>'Peso Habitual [Kg]', 'ESTATURA'=>'Estatura [cm]', 'PCT'=>'Pliegue Cutáneo Tricipital [mm]',
                    'PCB'=>'Pliegue Cutáneo Bicipital [mm]', 'PCS'=>'Pliegue Cutáneo Subescapular [mm]', 'CB'=>'Circunferencia de Brazo [cm]', 'CCIN'=>'Circunferencia de Cintura [cm]', 'CCAD'=>'Circunferencia de Cadera [cm]', 'CABS'=>'Circunferencia abdominal [cm]',
                    'COMPLEX'=>'Complexión', 'GRASACORP'=>'% Grasa Corporal', 'MASALG'=>'% Masa libre de grasa', 'ICINCAD'=>'Índice Cintura-Cadera [cm]',
                    'AMUSCB'=>'Área Muscular del Brazo [Kg]', 'AGUACT'=>'Agua Corporal Total [Lt]'
                ];

                foreach ($campos as $name => $label) {
                    // Si el campo es COMPLEX, usar tipo texto, de lo contrario tipo número
                    $type = ($name == 'COMPLEX') ? 'text' : 'number';
                    $step = ($type == 'number') ? 'step="any"' : '';

                    echo '
                    <div class="col-md-4 mb-3">
                        <label for="'.$name.'">'.$label.':</label>
                        <input type="'.$type.'" '.$step.' class="form-control" name="'.$name.'" id="'.$name.'">
                    </div>';
                }
                ?>

                </div>

                <input type="hidden" name="tabla" value="antropometria">
                <button type="submit" class="btn btn-primary mt-3" name="guardar_antropometria">Guardar</button>
            </form>

            <!-- Mostrar el último registro de PESOIDEAL, IMC, PESOAJUST -->
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>PESO IDEAL [Kg]</th>
                        <th>IMC</th>
                        <th>PESO AJUSTADO [Kg]</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Obtener el último registro de antropometría
                    $sql = "SELECT PESOIDEAL, IMC, PESOAJUST FROM antropometria WHERE idPac = ? ORDER BY FECHAANTRO DESC LIMIT 1";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $idPac);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Verificar si se encontró el último registro
                    if ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['PESOIDEAL'] . ' Kg</td>';
                        echo '<td>' . $row['IMC'] . '</td>';
                        echo '<td>' . $row['PESOAJUST'] . ' Kg</td>';
                        echo '</tr>';
                    } else {
                        echo '<tr><td colspan="3" class="text-center">No hay datos disponibles</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Energía y Nutrición -->
        <div class="tab-pane fade" id="energnutri" role="tabpanel" aria-labelledby="energnutri-tab">
            <form method="POST">
                <div class="row">
                    <?php
                    // Obtención del idPac desde la URL
                    $idPac = isset($_GET['idPac']) ? $_GET['idPac'] : 0;

                    // Consulta para obtener el último registro de GEB, ETA, AFFE y GETO
                    $sql = "SELECT GEB, ETA, AFFE, GETO, FECHANEC,kcalprop,ACTFISICA 
                            FROM energnutri 
                            WHERE idPac = ? 
                            ORDER BY FECHANEC DESC 
                            LIMIT 1";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $idPac);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Verificamos si hay resultados
                    if ($result->num_rows > 0) {
                        echo '<div class="col-md-12">';
                        echo '<h5>Últimos Datos Energéticos</h5>';
                        echo '<table class="table table-bordered">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>Fecha de Registro</th>';
                        echo '<th>Gasto Energético Basal</th>';
                        echo '<th>Efecto Térmico de los Alimentos</th>';
                        echo '<th>Gasto Energético Total</th>';
                        echo '<th>Calorías propuestas</th>';
                        echo '<th>Actividad Física</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['FECHANEC'] . '</td>';
                            echo '<td>' . number_format($row['GEB'], 2) . '</td>';
                            echo '<td>' . number_format($row['ETA'], 2) . '</td>';
                            echo '<td>' . number_format($row['GETO'], 2) . '</td>';
                            echo '<td>' . number_format($row['kcalprop'], 2) . '</td>';
                            echo '<td>' . $row['ACTFISICA'] . '</td>';
                            echo '</tr>';
                        }
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                    } else {
                        echo "<div class='alert alert-warning mt-3'>No se encontraron registros energéticos para este paciente.</div>";
                    }
                    ?>
                </div>

            </form>
            <!-- Mostrar todos los datos de la tabla FAF -->
            <div class="col-md-12 mt-5">
                <h5>Factores de Actividad Física</h5>
                <?php
                // Consulta para obtener todos los registros de FAF
                $sqlFaf = "SELECT Factor, ACTIVIDAD, DEFINICION FROM faf";
                $resultFaf = $conn->query($sqlFaf);

                if ($resultFaf->num_rows > 0) {
                    echo '<div class="table-responsive">';
                    echo '<table class="table table-bordered">';
                    echo '<thead>';
                    echo '<tr>';
                    echo '<th>Factor</th>';
                    echo '<th>Actividad</th>';
                    echo '<th>Definición</th>';
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    while ($rowFaf = $resultFaf->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . number_format($rowFaf['Factor'], 2) . '</td>';
                        echo '<td>' . htmlspecialchars($rowFaf['ACTIVIDAD']) . '</td>';
                        echo '<td>' . htmlspecialchars($rowFaf['DEFINICION']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                } else {
                    echo "<div class='alert alert-warning'>No se encontraron registros en la tabla FAF.</div>";
                }
                ?>
            </div>
            
            <form method="POST">
                <label for="actividad_fisica">Selecciona tu actividad física:</label>
                <select name="actividad_fisica" id="actividad_fisica" class="form-control">
                    <option value="Sedentario">Sedentario</option>
                    <option value="Ligero">Ligero</option>
                    <option value="Activo">Activo</option>
                    <option value="Muy Activo">Muy Activo</option>
                    <option value="Extremadamente Activo">Extremadamente Activo</option>
                </select>

                <!-- Campo hidden para enviar el nombre de la tabla -->
                <input type="hidden" name="tabla" value="energnutri">

                <button type="submit" class="btn btn-primary mt-2">Calcular</button>
            </form>

            
        </div>

        <!--Macros-->
        <div class="tab-pane fade" id="macros" role="tabpanel" aria-labelledby="macros-tab">
            <form method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="KCALPROP">Kilocalorías Propuestas</label>
                        <input type="number" step="any" class="form-control" name="KCALPROP" id="KCALPROP">
                    </div>
                    <h4 class="mt-4">Hidratos de carbono</h4>
                    <div class="col-md-6 mb-3">
                        <label for="PERCENTCARBOS">Porcentaje [%]</label>   
                        <input type="number" step="any" class="form-control" name="PERCENTCARBOS" id="PERCENTCARBOS">
                    </div>

                    <h4 class="mt-4">Proteína</h4>
                    <div class="col-md-6 mb-3">
                        <label for="PERCENTPROT">Porcentaje [%]</label>
                        <input type="number" step="any" class="form-control" name="PERCENTPROT" id="PERCENTPROT">
                    </div>

                    <h4 class="mt-4">Lípidos</h4>
                    <div class="col-md-6 mb-3">
                        <label for="PERCENTLIP">Porcentaje [%]</label>
                        <input type="number" step="any" class="form-control" name="PERCENTLIP" id="PERCENTLIP">
                    </div>

                </div>


                <input type="hidden" name="tabla" value="macros">
                <button type="submit" class="btn btn-primary mt-3" name="MACROS">Guardar</button>
            </form>
                     
        </div>

        <!-- Observaciones Generales -->
        <div class="tab-pane fade" id="generall" role="tabpanel" aria-labelledby="generall-tab">
            <form method="POST">
                <div class="form-group">
                    <label for="OBS">Observaciones:</label>
                    <textarea class="form-control" id="OBS" name="OBS" rows="3"></textarea>
                </div>

                <div class="form-group mt-2">
                    <label for="DIAGN">Diagnóstico:</label>
                    <textarea class="form-control" id="DIAGN" name="DIAGN" rows="2"></textarea>
                </div>

                <div class="form-group mt-2">
                    <label for="TRATA">Tratamiento:</label>
                    <textarea class="form-control" id="TRATA" name="TRATA" rows="2"></textarea>
                </div>

                <input type="hidden" name="tabla" value="generall">
                <button type="submit" class="btn btn-primary mt-3" name="guardar_generall">Guardar</button>
            </form>
        </div>
    </div>
</div>

<?php include("template/pie.php"); ?>


<!-- Incluir el JS de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>