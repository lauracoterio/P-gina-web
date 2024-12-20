<?php
session_start();
include 'conexion.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si los campos están presentes
    if (isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['email']) && isset($_POST['password'])) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Encriptar la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Preparar la consulta para insertar el nuevo usuario
        $stmt = $conexion->prepare("INSERT INTO usuario (name, phone, email, password) VALUES (?, ?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("ssss", $name, $phone, $email, $hashed_password);

            if ($stmt->execute()) {
                // Redirigir a la página de inicio de compras después del registro exitoso
                header("Location: start_shopping.html");
                exit();
            } else {
                $response['success'] = false;
                $response['message'] = "Error al registrar usuario: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $response['success'] = false;
            $response['message'] = "Error en la preparación de la consulta: " . $conexion->error;
        }

        $conexion->close();
    } else {
        $response['success'] = false;
        $response['message'] = "Faltan campos obligatorios";
    }

    echo json_encode($response);
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="img/icon3.png" type="image/x-icon">
    <title>Sing Up</title>

    <style>

        body {
            margin: 0;
            padding: 0;
            background-color: #001529;
            font-family: 'Cormorant Garamond', serif;
            color: #fff02d;
        }

        /* Estilos para el navbar */
        .custom-navbar {
            background-color: #001529;
            margin-bottom: 20px;
            margin-top: -20px;
        }
        .span-navbar a {
            margin-left: 50px;
            margin-right: -10px;
        }
        .sh_bag {
            width: 35%;
            height: 35%;
            margin-top: -5px;
        }
        .navbar a {
            float: left;
            display: block;
            color: #fff02d;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            margin-left: 50px;
        }
        .navbar a:hover {
            background-color: #dddddd51;
            color: white;
        }


        /*ESTILOS PARA EL FORMULARIO */
        .border-box {
            border: 2px solid #f4d03f;
            padding: 30px;
            border-radius: 5px;
            width: 90%;
            max-width: 600px;
        }
        .container {
            margin-top: -80px;
        }
        .mb-4 {
            color: #001529;
        }
        .form-control {
            margin-top: -5px;
            margin-bottom: 10px;
        }
        .btn-primary {
            background-color: #001b44;
            border-color: #f4d03f;
            color: #f4d03f;
            margin-top: 10px;
        }
        .btn-primary:hover {
            background-color: #f4d03f;
            color: #001b44;
        }

       
/* ESTILOS PARA EL FOOTER */
footer {
    text-align: center;
    color: #333;
    margin-top: 10px;
}

/* Sección superior del footer */
.footer-top {
    background-color: #001529;
    padding: 20px;
    text-align: center;
}

.social-icons a {
    color: #fff02d;
    margin: 0 10px;
    font-size: 20px;
    
}

.social-icons a:hover {
    color: #000;
}

.p-foot{
  color: #fff02d;
}

/* Sección inferior del footer */
.footer-bottom {
    background-color: #001529;
    color: #fff02d;
    font-size: 14px;

}
.footer-bottom p {
    color: #fff02d;
}

.footer-bottom a {
    color: #fff02d;
}

.footer-bottom a:hover {
    color: #000000;
}


         /* ESTILOS PARA LA PANTALLA DE CARGA*/
         #loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 21, 41, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            animation: fadeOut 2s ease forwards;
        }
        #loading-screen img {
            width: 100px;
            animation: spin 1s infinite linear;
        }
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; visibility: hidden; }
        }
    </style>
</head>
<body class="p-3 m-0 border-0 bd-example m-0 border-0">

    <!-- Pantalla de carga -->
    <div id="loading-screen">
        <img src="img/img5.png" alt="Loading Logo">
    </div>

<!--BARRA DE NAVEGACION -->
<nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.html"><img src="img/img5 (3).png" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="start_shopping.html"><i>HOME</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="necklaces.html"><i>NECKLACES</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rings.html"><i>RINGS</i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about_us.html"><i>ABOUT US</i></a>
                </li>
            </ul>
            <span class="navbar-text span-navbar">
                <a class="nav-link" href="sing_up.html"><i>SIGN UP</i></a>
                <a class="nav-link" href="PA_inicio de sesion.html"><i>LOG IN</i></a>
                <a class="nav-link" href="#"><img src="img/sh_bag.png" alt="bag" class="sh_bag"></a>
            </span>
        </div>
    </div>
  </nav>


    <!-- Formulario de Sing Up -->
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="width: 22rem;">
            <h2 class="mb-4">Sign Up</h2>
            <form action="sign_up.php" method="post">
                <div class="form-group">
                    <label for="name" class="mb-4">Name</label>
                    <input type="name" class="form-control" id="name" name="name" placeholder="Full name" required>
                </div>
                <div class="form-group">
                    <label for="phone" class="mb-4">Phone Number</label>
                    <input type="phone" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
                </div>
                <div class="form-group">
                    <label for="email" class="mb-4">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password" class="mb-4">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Set your password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-top">
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
            <p class="p-foot"><i>ovejas++@asdi.com</i></p>
        </div>
        <div class="footer-bottom">
            <p>&copy; S M & L | Diseñador Web: Ovejas++ | <a href="#">Aviso legal</a> · <a href="#">Política de privacidad</a></p>
        </div>
    </footer>

    <!-- Scripts de Bootstrap 5 -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>