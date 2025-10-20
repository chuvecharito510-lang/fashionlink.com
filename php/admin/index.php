<?php
require_once("auth.php");

if (isAdminLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (loginAdmin($username, $password)) {
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - FashionLink</title>
    <link rel="stylesheet" href="../../style.css"> <!-- Link to main style.css -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            padding: 20px;
        }

        .login-container {
            background-color: #fff;
            padding: 50px 40px;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 440px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 40px;
            color: #1a1a1a;
            font-size: 2em;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .login-container label {
            display: block;
            text-align: left;
            margin-bottom: 10px;
            font-weight: 600;
            color: #1a1a1a;
            font-size: 0.95em;
            letter-spacing: 0.3px;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 24px;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            font-size: 1em;
            background: #fafafa;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .login-container input:focus {
            border: 2px solid #1a1a1a;
            outline: none;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(26, 26, 26, 0.05);
        }

        .login-container button {
            background-color: #1a1a1a;
            color: #fff;
            border: none;
            padding: 16px 24px;
            cursor: pointer;
            border-radius: 8px;
            font-size: 1.1em;
            width: 100%;
            font-weight: 600;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
        }

        .login-container button:hover {
            background-color: #000;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .login-container a.btn {
            display: inline-block;
            background: transparent;
            color: #666;
            border: 1px solid rgba(0, 0, 0, 0.15);
            padding: 14px 24px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            box-sizing: border-box;
        }

        .login-container a.btn:hover {
            background: #f5f5f5;
            border-color: #1a1a1a;
            color: #1a1a1a;
        }

        .error-message {
            background: #fee;
            color: #c00;
            padding: 12px;
            border-radius: 8px;
            margin-top: 16px;
            font-size: 0.95em;
            border: 1px solid #fcc;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>ACCESO DE ADMINISTRADOR</h2>
        <form action="index.php" method="POST">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Iniciar Sesión</button>
        </form>
        <?php if ($error): ?>
            <p class="error-message"><?php echo $error; ?></p>
        <?php endif; ?>
        <a href="../../index.html" class="btn">Volver a la Tienda</a>
    </div>
</body>
</html>