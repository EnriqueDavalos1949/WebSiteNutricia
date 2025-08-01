<!-- Incluir Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<?php
// Conexión a la base de datos
include("config/DB.php");

// Manejo de sesión si ya está iniciado
session_start();

// Verificar si hay cookies para autocompletar el formulario
if (isset($_COOKIE['user']) && isset($_COOKIE['password'])) {
    $_SESSION['user'] = $_COOKIE['user'];  // Establecer la sesión con el usuario guardado
    header("Location: index.php?IdUser=" . $_SESSION['user']); // Redirigir al index.php con el parámetro IdUser
    exit();
}

// Verificar si se ha enviado el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    // Recoger los datos del formulario
    $user = $_POST['user'];
    $password = $_POST['password'];

    // Consultar la base de datos para verificar el usuario y la contraseña
    $sql = "SELECT * FROM user WHERE USER = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si las credenciales son correctas, iniciar sesión
        $_SESSION['user'] = $user;

        // Obtener el IdUser de la base de datos
        $user_data = $result->fetch_assoc();
        $idUser = $user_data['IdUser']; // Asumiendo que 'IdUser' es el campo de la base de datos

        // Si el checkbox "recordarme" está marcado, guardar el USER y password en cookies
        if (isset($_POST['remember_me']) && $_POST['remember_me'] == 1) {
            setcookie('user', $user, time() + (86400 * 30), "/");  // La cookie expirará en 30 días
            setcookie('password', $password, time() + (86400 * 30), "/");
        }

        // Redirigir al usuario a index.php con el parámetro IdUser
        header("Location: index.php?IdUser=" . $idUser);
        exit();
    } else {
        // Mostrar un mensaje de error si el usuario o la contraseña son incorrectos
        $error_message = "Usuario o contraseña incorrectos.";
    }
}
?>

<!-- Mostrar Tabs -->
<div class="container mt-5">
    <ul class="nav nav-tabs" id="datosTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="register-tab" data-bs-toggle="tab" href="#register" role="tab">Registrar Usuario</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="login-tab" data-bs-toggle="tab" href="#login" role="tab">Iniciar Sesión</a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Formulario de Registro -->
        <div class="tab-pane fade show active" id="register" role="tabpanel">
            <h2>Registrar Usuario</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" class="form-control" name="NombreCompleto" required>
                </div>
                <div class="form-group">
                    <label for="user">Usuario (No repetido)</label>
                    <input type="text" class="form-control" name="user" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="form-group">
                    <label for="userborn">Fecha de Nacimiento</label>
                    <input type="date" class="form-control" name="userborn" required>
                </div>
                <button type="submit" name="register" class="btn btn-primary">Registrar</button>
            </form>
        </div>

        <!-- Formulario de Inicio de Sesión -->
        <div class="tab-pane fade" id="login" role="tabpanel">
            <h2>Iniciar Sesión</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="user">Usuario</label>
                    <input type="text" class="form-control" name="user" value="<?php echo isset($_COOKIE['user']) ? $_COOKIE['user'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" name="password" value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : ''; ?>" required>
                </div>

                <?php
                if (isset($error_message)) {
                    echo "<div class='alert alert-danger'>$error_message</div>";
                }
                ?>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" name="remember_me" value="1" <?php echo isset($_COOKIE['user']) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="remember_me">Recordarme</label>
                </div>

                <!-- Campo oculto para enviar IdUser -->
                <input type="hidden" name="IdUser" value="<?php echo isset($idUser) ? $idUser : ''; ?>">

                <button type="submit" name="login" class="btn btn-success">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</div>

<!-- Incluir Bootstrap JS, jQuery y Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Inicializar las pestañas de Bootstrap
    $(document).ready(function () {
        $('#datosTabs a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>



