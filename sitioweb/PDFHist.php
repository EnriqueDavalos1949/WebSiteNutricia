<?php
require('fpdf.php');
include("config/DB.php");

$idPac = isset($_GET['idPac']) ? intval($_GET['idPac']) : 0;
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : date("Y-m-d");

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Titulo principal centrado con la fecha seleccionada
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode("Historia clinica $fecha"), 0, 1, 'C');
$pdf->Ln(1);

// Nombre Nutriolog@ centrado con la fecha seleccionada
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode("L.N. Metzli Citlali Vargas Castro"), 0, 1, 'C');
$pdf->Ln(1);

// Subtitulo
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Informacion de registro', 0, 1, 'L');
$pdf->Ln(3);

// Estilo tabla
$pdf->SetFont('Arial', '', 12);
$pdf->SetFillColor(255, 192, 203); // Rosa pastel
$pdf->SetTextColor(0); // Texto negro

if ($idPac > 0) {
    $stmt = $conn->prepare("SELECT name, age, Born, TEL, ConsDate, consult FROM pxreg WHERE idPac = ?");
    $stmt->bind_param("i", $idPac);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        $pdf->Cell(60, 10, 'Nombre', 1, 0, 'L', true);
        $pdf->Cell(130, 10, utf8_decode($fila['name']), 1, 1);

        $pdf->Cell(60, 10, 'Edad', 1, 0, 'L', true);
        $pdf->Cell(130, 10, $fila['age'], 1, 1);

        $pdf->Cell(60, 10, 'Fecha de nacimiento', 1, 0, 'L', true);
        $pdf->Cell(130, 10, $fila['Born'], 1, 1);

        $pdf->Cell(60, 10, 'Telefono', 1, 0, 'L', true);
        $pdf->Cell(130, 10, $fila['TEL'], 1, 1);

        $pdf->Cell(60, 10, 'Fecha de consulta', 1, 0, 'L', true);
        $pdf->Cell(130, 10, $fila['ConsDate'], 1, 1);

        $pdf->Cell(60, 10, 'Motivo del registro', 1, 0, 'L', true);
        $pdf->MultiCell(130, 10, utf8_decode($fila['consult']), 1);
    } else {
        $pdf->Cell(0, 10, 'No se encontro informacion del paciente.', 0, 1);
    }

    $stmt->close();
} else {
    $pdf->Cell(0, 10, 'ID de paciente invalido.', 0, 1);
}
// Espacio y subtitulo
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Indicadores Bioquimicos', 0, 1, 'L');
$pdf->Ln(3);

// Buscar IBQM segun idPac y fecha
$stmt = $conn->prepare("SELECT SIBQM, BQM FROM ibqm WHERE idPac = ? AND FECHAIBQM = ?");
$stmt->bind_param("is", $idPac, $fecha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 192, 203); // Rosa pastel

    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(70, 10, 'Se solicitaron analisis bioquimicos', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['SIBQM'] ? 'Si' : 'No', 1, 1);

        $pdf->Cell(60, 10, 'Observaciones', 1, 0, 'L', true);
        $pdf->Cell(130, 10, utf8_decode($row['BQM']), 1, 1);

        $pdf->Ln(5); // Espacio entre registros
    }
} else {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Aun no hay registros de Indicadores Bioquimicos solicitados', 0, 1);
}

$stmt->close();

// Espacio y subtitulo
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Antropometria', 0, 1, 'L');
$pdf->Ln(3);

// Buscar datos de antropometría según idPac y fecha
$stmt = $conn->prepare("SELECT * FROM antropometria WHERE idPac = ? AND FECHAANTRO = ?");
$stmt->bind_param("is", $idPac, $fecha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 192, 203); // Rosa pastel

    // Recorrer todos los registros
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(75, 10, 'Fecha', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['FECHAANTRO'], 1, 1);

        $pdf->Cell(75, 10, 'Peso Actual [Kg]', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['PESOACT'], 1, 1);

        $pdf->Cell(75, 10, 'Peso Habitual [Kg] (Ultimos 6 meses)', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['PESOHAB'], 1, 1);

        $pdf->Cell(75, 10, 'Estatura [cm]', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['ESTATURA'], 1, 1);

        $pdf->Cell(75, 10, 'Pliego Cutaneo Tricipital [mm]', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['PCT'], 1, 1);

        $pdf->Cell(75, 10, 'Pliegue Cutaneo Bicipital [mm]', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['PCB'], 1, 1);

        $pdf->Cell(75, 10, 'Pliegiue Cutaneo Subescapular [mm]', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['PCS'], 1, 1);

        $pdf->Cell(75, 10, 'Circunferencia del Brazo [cm]', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['CB'], 1, 1);

        $pdf->Cell(75, 10, 'Circunferencia de la Cintura [cm]', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['CCIN'], 1, 1);

        $pdf->Cell(75, 10, 'Circunferencia de la Cadera [cm]', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['CCAD'], 1, 1);

        $pdf->Cell(75, 10, 'Circunferencia de la cadera [cm]', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['CABS'], 1, 1);

        $pdf->Cell(75, 10, 'Complexion', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['COMPLEX'], 1, 1);

        $pdf->Cell(75, 10, 'Peso Ideal', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['PESOIDEAL'], 1, 1);

        $pdf->Cell(75, 10, 'IMC', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['IMC'], 1, 1);

        $pdf->Cell(75, 10, 'Peso Ajustado', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['PESOAJUST'], 1, 1);

        $pdf->Cell(75, 10, '% Grasa Corporal', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['GRASACORP'], 1, 1);

        $pdf->Cell(75, 10, '% Masa Magra', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['MASALG'], 1, 1);

        $pdf->Cell(75, 10, 'Indice Cintura-Cadera[cm]', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['ICINCAD'], 1, 1);

        $pdf->Cell(75, 10, 'Area Muscular del Brazo [Kg]', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['AMUSCB'], 1, 1);

        $pdf->Cell(75, 10, 'Agua Corporal Total [Lt]', 1, 0, 'L', true);
        $pdf->Cell(115, 10, $row['AGUACT'], 1, 1);

        $pdf->Ln(5); // Espacio entre registros
    }
} else {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Aun no hay registros de Antropometria para esta fecha.', 0, 1);
}

$stmt->close();

// Espacio y subtitulo
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Necesidades Energeticas y Nutrimentales', 0, 1, 'L');
$pdf->Ln(3);

// Buscar datos de energnutri según idPac y fecha
$stmt = $conn->prepare("SELECT * FROM energnutri WHERE idPac = ? AND FECHANEC = ?");
$stmt->bind_param("is", $idPac, $fecha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 192, 203); // Rosa pastel

    // Recorrer todos los registros
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(70, 10, 'Fecha', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['FECHANEC'], 1, 1);

        $pdf->Cell(70, 10, 'Gasto Energetico Basal', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['GEB'], 1, 1);

        $pdf->Cell(70, 10, 'Efecto Termico de los alimentos', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['ETA'], 1, 1);

        $pdf->Cell(70, 10, 'Factor de Ejercicio', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['AFFE'], 1, 1);

        $pdf->Cell(70, 10, 'Gasto Energetico Total', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['GETO'], 1, 1);

        $pdf->Ln(5); // Espacio entre registros
    }
} else {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Aun no hay registros de Energia y Nutricion para esta fecha.', 0, 1);
}

$stmt->close();
// Espacio y subtitulo
$pdf->Ln(25);
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Macronutrientes', 0, 1, 'L');
$pdf->Ln(3);
// Espacio y subtitulo
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Kcal Propuestas', 0, 1, 'L');
$pdf->Ln(3);
// Buscar datos de energnutri según idPac y fecha
$stmt = $conn->prepare("SELECT * FROM energnutri WHERE idPac = ? AND FECHANEC = ?");
$stmt->bind_param("is", $idPac, $fecha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 192, 203); // Rosa pastel

    // Recorrer todos los registros
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(70, 10, 'kcalprop', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['kcalprop'], 1, 1);

        $pdf->Ln(5); // Espacio entre registros
    }
} else {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Aun no hay registros de Energia y Nutricion para esta fecha.', 0, 1);
}

$stmt->close();

// Espacio y subtitulo
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Carbohidratos', 0, 1, 'L');
$pdf->Ln(3);

// Buscar datos de carbos según idPac y fecha
$stmt = $conn->prepare("SELECT * FROM carbos WHERE idPac = ? AND FECHACARBOS = ?");
$stmt->bind_param("is", $idPac, $fecha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 192, 203); // Rosa pastel

    // Recorrer todos los registros
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(70, 10, 'Fecha', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['FECHACARBOS'], 1, 1);

        $pdf->Cell(70, 10, 'Porcentaje [%]', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['PERCENT'], 1, 1);

        $pdf->Cell(70, 10, 'Kilocalorias', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['KCAL'], 1, 1);

        $pdf->Cell(70, 10, 'Gramos [g]', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['GRS'], 1, 1);

        $pdf->Ln(5); // Espacio entre registros
    }
} else {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Aun no hay registros de Carbohidratos para esta fecha.', 0, 1);
}

$stmt->close();

// Espacio y subtitulo
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Lipidos', 0, 1, 'L');
$pdf->Ln(3);

// Buscar datos de lipidos según idPac y fecha
$stmt = $conn->prepare("SELECT * FROM lipidos WHERE idPac = ? AND FECHALIPIDOS = ?");
$stmt->bind_param("is", $idPac, $fecha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 192, 203); // Rosa pastel

    // Recorrer todos los registros
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(70, 10, 'Fecha', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['FECHALIPIDOS'], 1, 1);

        $pdf->Cell(70, 10, 'Porcentaje [%]', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['PERCENT'], 1, 1);

        $pdf->Cell(70, 10, 'Kilocalorias', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['KCAL'], 1, 1);

        $pdf->Cell(70, 10, 'Gramos [g]', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['GRS'], 1, 1);

        $pdf->Ln(5); // Espacio entre registros
    }
} else {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Aun no hay registros de Lipidos para esta fecha.', 0, 1);
}

$stmt->close();
// Espacio y subtitulo
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Proteina', 0, 1, 'L');
$pdf->Ln(3);

// Buscar datos de proteina según idPac y fecha
$stmt = $conn->prepare("SELECT * FROM proteina WHERE idPac = ? AND FECHAPROTE = ?");
$stmt->bind_param("is", $idPac, $fecha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 192, 203); // Rosa pastel

    // Recorrer todos los registros
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(70, 10, 'Fecha', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['FECHAPROTE'], 1, 1);

        $pdf->Cell(70, 10, 'Porcentaje [%]', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['PERCENT'], 1, 1);

        $pdf->Cell(70, 10, 'Kilocalorias', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['KCAL'], 1, 1);

        $pdf->Cell(70, 10, 'Gramos [g]', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['GRS'], 1, 1);

        $pdf->Ln(5); // Espacio entre registros
    }
} else {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Aun no hay registros de Proteina para esta fecha.', 0, 1);
}

$stmt->close();
// Espacio y subtitulo
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Observaciones Generales', 0, 1, 'L');
$pdf->Ln(3);

// Buscar datos de generall según idPac y fecha
$stmt = $conn->prepare("SELECT * FROM generall WHERE idPac = ? AND FECHAGRAL = ?");
$stmt->bind_param("is", $idPac, $fecha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(255, 192, 203); // Rosa pastel

    // Recorrer todos los registros
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(70, 10, 'Fecha', 1, 0, 'L', true);
        $pdf->Cell(120, 10, $row['FECHAGRAL'], 1, 1);

        $pdf->Cell(70, 10, 'Observaciones P/ Consulta', 1, 0, 'L', true);
        $pdf->MultiCell(120, 10, $row['OBS'], 1, 'L');

        $pdf->Cell(70, 10, 'Diagnostico nutricional', 1, 0, 'L', true);
        $pdf->MultiCell(120, 10, $row['DIAGN'], 1, 'L');

        $pdf->Cell(70, 10, 'Tratamiento nutricional', 1, 0, 'L', true);
        $pdf->MultiCell(120, 10, $row['TRATA'], 1, 'L');

        $pdf->Ln(5); // Espacio entre registros
    }
} else {
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'Aun no hay registros generales para esta fecha.', 0, 1);
}

$stmt->close();


$pdf->Output();
?>














