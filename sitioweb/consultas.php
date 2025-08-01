<?php include("template/cabecera.php"); ?>
<?php include("config/DB.php"); ?>

<div class="container mt-4">
    <h2 class="mb-4">Buscar Pacientes</h2>

    <!-- Formulario de búsqueda -->
    <form method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="buscar" placeholder="Escribe el nombre del paciente" value="<?= isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : '' ?>">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <!-- Tabla de resultados -->
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Edad</th>
                <th>Fecha de Nacimiento</th>
                <th>Teléfono</th>
                <th>Fecha de Consulta</th>
                <th>Motivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $filtro = isset($_GET['buscar']) ? mysqli_real_escape_string($conn, $_GET['buscar']) : '';
            $query = "SELECT * FROM pxreg";
            if (!empty($filtro)) {
                $query .= " WHERE name LIKE '%$filtro%'";
            }
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)):
            ?>
                <tr>
                    <td><?= $row['idPac'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['age'] ?></td>
                    <td><?= $row['Born'] ?></td>
                    <td><?= $row['TEL'] ?></td>
                    <td><?= $row['ConsDate'] ?></td>
                    <td><?= htmlspecialchars($row['consult']) ?></td>
                    <td>
                        <!-- Botón "Generar" -->
                        <a href="CONSPER.php?idPac=<?= $row['idPac'] ?>" class="btn btn-primary btn-sm">Generar</a>
                        <!-- Botón "Historial" -->
                        <a href="historial.php?idPac=<?= $row['idPac'] ?>" class="btn btn-info btn-sm">Historial</a>
                        <!--Boton de Dieta -->
                        <a href="https://nutre.in/" class="btn btn-warning btn-sm" role="button">Dieta</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include("template/pie.php"); ?>



