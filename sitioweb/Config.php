<?php 
include("template/cabecera.php"); 
include("config/DB.php"); 

// Guardar el tema seleccionado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tema'])) {
    $_SESSION['tema'] = $_POST['tema'];
}

// Definir el tema actual (por si es necesario después)
$temaActual = isset($_SESSION['tema']) ? $_SESSION['tema'] : '';
?>

<div class="container mt-5">
    <h1 class="display-4">Temas</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="temaSeleccionado" class="form-label">Selecciona un tema de color:</label>
            <select class="form-select" id="temaSeleccionado" name="tema">
                <option value="bg-primary" <?php echo ($temaActual == 'bg-primary') ? 'selected' : ''; ?>>Rosa</option>
                <option value="bg-secondary" <?php echo ($temaActual == 'bg-secondary') ? 'selected' : ''; ?>>Gris claro</option>
                <option value="bg-success" <?php echo ($temaActual == 'bg-success') ? 'selected' : ''; ?>>Verde</option>
                <option value="bg-danger" <?php echo ($temaActual == 'bg-danger') ? 'selected' : ''; ?>>Naranja</option>
                <option value="bg-warning" <?php echo ($temaActual == 'bg-warning') ? 'selected' : ''; ?>>Amarillo</option>
                <option value="bg-info" <?php echo ($temaActual == 'bg-info') ? 'selected' : ''; ?>>Azul</option>
                <option value="bg-dark" <?php echo ($temaActual == 'bg-dark') ? 'selected' : ''; ?>>Negro</option>
                <option value="bg-light" <?php echo ($temaActual == 'bg-light') ? 'selected' : ''; ?>>Blanco</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Aplicar Tema</button>
    </form>
</div>

<?php include("template/pie.php"); ?>



