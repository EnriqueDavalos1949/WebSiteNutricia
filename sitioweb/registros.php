<?php
include("config/DB.php");

// Procesar el formulario para agregar un nuevo paciente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'agregar') {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $age = mysqli_real_escape_string($conn, $_POST["age"]);
    $Born = mysqli_real_escape_string($conn, $_POST["Born"]);
    $TEL = mysqli_real_escape_string($conn, $_POST["TEL"]);
    $ConsDate = mysqli_real_escape_string($conn, $_POST["ConsDate"]);
    $consult = mysqli_real_escape_string($conn, $_POST["consult"]);
    $ocupacion = mysqli_real_escape_string($conn, $_POST["ocupacion"]);
    $sexo = mysqli_real_escape_string($conn, $_POST["sexo"]);

    // Insertar paciente
    $sql = "INSERT INTO pxreg (name, age, Born, TEL, ConsDate, consult, ocupacion, sexo) 
    VALUES ('$name', '$age', '$Born', '$TEL', '$ConsDate', '$consult', '$ocupacion', '$sexo')";
    if (mysqli_query($conn, $sql)) {
        $idPac = mysqli_insert_id($conn); // ID nuevo paciente

        // Insertar registros relacionados
        mysqli_query($conn, "INSERT INTO healthstate (idPac) VALUES ('$idPac')");
        mysqli_query($conn, "INSERT INTO ec (idPac) VALUES ('$idPac')");
        mysqli_query($conn, "INSERT INTO hf (idPac) VALUES ('$idPac')");
        mysqli_query($conn, "INSERT INTO med (idPac, medicamento, dosis, via, frecuencia) VALUES ('$idPac', '', '', '', '')");
        mysqli_query($conn, "INSERT INTO gral (idPac, DATA) VALUES ('$idPac', '')");

        echo "<div class='alert alert-success mt-4'>Paciente agregado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger mt-4'>Error al agregar paciente: " . mysqli_error($conn) . "</div>";
    }
}

// Eliminar paciente
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    mysqli_query($conn, "DELETE FROM healthstate WHERE idPac = '$id'");
    mysqli_query($conn, "DELETE FROM ec WHERE idPac = '$id'");
    mysqli_query($conn, "DELETE FROM hf WHERE idPac = '$id'");
    mysqli_query($conn, "DELETE FROM med WHERE idPac = '$id'");
    mysqli_query($conn, "DELETE FROM gral WHERE idPac = '$id'");
    mysqli_query($conn, "DELETE FROM nutricion WHERE idPac = '$id'");
    mysqli_query($conn, "DELETE FROM energnutri WHERE idPac = '$id'");
    mysqli_query($conn, "DELETE FROM antropometria WHERE idPac = '$id'");
    mysqli_query($conn, "DELETE FROM ibqm WHERE idPac = '$id'");
    mysqli_query($conn, "DELETE FROM generall WHERE idPac = '$id'");
    mysqli_query($conn, "DELETE FROM carbos WHERE idPac = '$id'");
    mysqli_query($conn, "DELETE FROM lipidos WHERE idPac = '$id'");
    mysqli_query($conn, "DELETE FROM proteina WHERE idPac = '$id'");
    mysqli_query($conn, "DELETE FROM KCAL WHERE idPac = '$id'");

    
    if (mysqli_query($conn, "DELETE FROM pxreg WHERE idPac = '$id'")) {/*En esta línea se encuentra el error*/
        echo "<div class='alert alert-success mt-4'>Paciente eliminado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger mt-4'>Error al eliminar paciente: " . mysqli_error($conn) . "</div>";
    }
    
}

// Editar paciente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'editar') {
    $id = $_POST["idPac"];
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $age = mysqli_real_escape_string($conn, $_POST["age"]);
    $Born = mysqli_real_escape_string($conn, $_POST["Born"]);
    $TEL = mysqli_real_escape_string($conn, $_POST["TEL"]);
    $ConsDate = mysqli_real_escape_string($conn, $_POST["ConsDate"]);
    $consult = mysqli_real_escape_string($conn, $_POST["consult"]);
    $ocupacion = mysqli_real_escape_string($conn, $_POST["ocupacion"]);
    $sexo = mysqli_real_escape_string($conn, $_POST["sexo"]);
    $sql = "UPDATE pxreg 
            SET name='$name', age='$age', Born='$Born', TEL='$TEL', ConsDate='$ConsDate', consult='$consult', ocupacion='$ocupacion', sexo='$sexo' 
            WHERE idPac='$id'";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success mt-4'>Paciente actualizado correctamente.</div>";
    } else {
        echo "<div class='alert alert-danger mt-4'>Error al actualizar paciente: " . mysqli_error($conn) . "</div>";
    }
}

// Obtener todos los registros
$sql = "SELECT * FROM pxreg";
$result = mysqli_query($conn, $sql);
?>

<?php include("template/cabecera.php"); ?>

<div class="container mt-4">
    <h1>Registros de Pacientes</h1>

    <!-- Botón para mostrar el formulario -->
    <button class="btn btn-success mb-3" id="agregarBtn">Agregar Paciente</button>

    <!-- Formulario para agregar o editar -->
    <div id="formulario" style="display: none;">
        <form action="registros.php" method="POST">
            <input type="hidden" name="action" value="agregar">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="age">Edad:</label>
                <input type="number" class="form-control" id="age" name="age" required>
            </div>
            <div class="form-group">
                <label for="Born">Fecha de Nacimiento:</label>
                <input type="date" class="form-control" id="Born" name="Born" required>
            </div>

            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <select class="form-control" id="sexo" name="sexo" required>
                    <option value="">Seleccione una opción</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>

            <div class="form-group">
                <label for="TEL">Teléfono:</label>
                <input type="text" class="form-control" id="TEL" name="TEL" required>
            </div>
            <div class="form-group">
                <label for="ocupacion">Ocupación:</label>
                <input type="text" class="form-control" id="ocupacion" name="ocupacion" required>
            </div>
            <div class="form-group">
                <label for="ConsDate">Fecha de registro:</label>
                <input type="date" class="form-control" id="ConsDate" name="ConsDate" required>
            </div>
            <div class="form-group">
                <label for="consult">Motivo de la consulta:</label>
                <textarea class="form-control" id="consult" name="consult" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

    <hr>

    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Fecha de Nacimiento</th>
                <th>Sexo</th>
                <th>Teléfono</th>
                <th>Ocupación</th>
                <th>Fecha de Consulta</th>
                <th>Consulta</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row["idPac"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["age"] . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($row["Born"])) . "</td>";
                    echo "<td>" . $row["sexo"] . "</td>";
                    echo "<td>" . $row["TEL"] . "</td>";
                    echo "<td>" . $row["ocupacion"] . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($row["ConsDate"])) . "</td>";
                    echo "<td>" . $row["consult"] . "</td>";
                    echo "<td>
                            <a href='personalData.php?idPac=" . $row["idPac"] . "' class='btn btn-info btn-sm'>Info</a>
                            <button class='btn btn-warning btn-sm' data-id='" . $row["idPac"] . "' data-name='" . $row["name"] . "' data-age='" . $row["age"] . "' data-born='" . $row["Born"] . "' data-tel='" . $row["TEL"] . "' data-consdate='" . $row["ConsDate"] . "' data-consult='" . $row["consult"] . "' data-ocupacion='" . $row["ocupacion"] . "' data-sexo='" . $row["sexo"] . "' onclick='editarPaciente(this)'>Editar</button>
                            <a href='?eliminar=" . $row["idPac"] . "' class='btn btn-danger btn-sm'>Eliminar</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No se encontraron registros.</td></tr>";
            }
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>

<?php include("template/pie.php"); ?>

<!-- Script para mostrar/ocultar formulario y cargar datos para editar -->
<script>
    document.getElementById("agregarBtn").addEventListener("click", function () {
        const form = document.getElementById("formulario");
        form.style.display = form.style.display === "none" ? "block" : "none";
        form.querySelector("form").reset();
        form.querySelector("input[name='action']").value = "agregar";
        form.querySelector("input[name='idPac']")?.remove(); // quitar input oculto si existe
    });

    function editarPaciente(button) {
        const form = document.getElementById("formulario");
        form.style.display = "block";

        document.getElementById("name").value = button.getAttribute("data-name");
        document.getElementById("age").value = button.getAttribute("data-age");
        document.getElementById("Born").value = button.getAttribute("data-born");
        document.getElementById("TEL").value = button.getAttribute("data-tel");
        document.getElementById("ConsDate").value = button.getAttribute("data-consdate");
        document.getElementById("consult").value = button.getAttribute("data-consult");
        document.getElementById("ocupacion").value = button.getAttribute("data-ocupacion");
        document.getElementById("sexo").value = button.getAttribute("data-sexo");

        const formEl = form.querySelector("form");
        formEl.querySelector("input[name='action']").value = "editar";

        if (!formEl.querySelector("input[name='idPac']")) {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "idPac";
            input.value = button.getAttribute("data-id");
            formEl.appendChild(input);
        } else {
            formEl.querySelector("input[name='idPac']").value = button.getAttribute("data-id");
        }
    }
</script>

