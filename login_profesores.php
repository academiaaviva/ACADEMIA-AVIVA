<?php
// =========================================================
// ARCHIVO: login_profesores.php
// Lógica de validación de credenciales para el rol de Profesor/Director.
// =========================================================

// Inicia la sesión. Es crucial para manejar el estado de login y los mensajes de error.
session_start();

// ===========================================
// 1. CREDENCIALES CONFIGURADAS
// ===========================================

// Usuario y contraseña fijos para el director.
$usuario_valido = 'Director';
$contrasena_valida = 'd1234'; 

// URLs de destino
$pagina_destino_exito = 'administracion.html';
$pagina_destino_error = 'maestros.html';

// ===========================================
// 2. PROCESAR SOLICITUD POST
// ===========================================

// Verifica que el método de la solicitud sea POST (es decir, que venga de un formulario)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtener y limpiar (trim) los datos ingresados por el usuario
    // Nota: En un sistema real, aquí se usaría mysqli_real_escape_string o consultas preparadas.
    $usuario_ingresado = trim($_POST['usuario']);
    $contrasena_ingresada = trim($_POST['password']);

    // ===========================================
    // 3. PROCESO DE VALIDACIÓN DE CREDENCIALES
    // ===========================================

    // A. Comparación de Usuario (usamos strcasecmp para ignorar mayúsculas/minúsculas)
    // strcasecmp devuelve 0 si las cadenas son iguales (case-insensitive).
    if (strcasecmp($usuario_ingresado, $usuario_valido) == 0) {
        
        // B. Comparación de Contraseña (también ignorando mayúsculas/minúsculas)
        if (strcasecmp($contrasena_ingresada, $contrasena_valida) == 0) {
            
            // ÉXITO: Credenciales correctas
            
            // Guardamos el estado de login en la sesión
            $_SESSION['maestro_logeado'] = $usuario_valido;
            unset($_SESSION['error_login']); // Limpiamos cualquier error anterior
            
            // Redirección al panel de administración
            header("Location: $pagina_destino_exito");
            exit; // Es crucial salir del script después de la redirección
            
        } else {
            // ERROR: Contraseña incorrecta
            $_SESSION['error_login'] = "Contraseña incorrecta. Inténtalo de nuevo.";
            header("Location: $pagina_destino_error");
            exit;
        }
        
    } else {
        // ERROR: Usuario incorrecto
        $_SESSION['error_login'] = "Usuario no encontrado. Verifica tus credenciales.";
        header("Location: $pagina_destino_error");
        exit;
    }
} else {
    // Si se intenta acceder al archivo PHP directamente (no por el formulario POST), redirigir al login.
    header("Location: $pagina_destino_error");
    exit;
}
?>
