<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta a la base de datos para obtener los datos del usuario
    $stmt = $conexion->prepare('SELECT id, name, password FROM usuario WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $hashed_password);
        $stmt->fetch();

        // Verificar la contraseña
        if (password_verify($password, $hashed_password)) {
            $_SESSION['id'] = $id;
            $_SESSION['name'] = $name;
            header('Location: start_shopping.html'); // Redirigir a la página de inicio
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró un usuario con ese correo.";
    }

    $stmt->close();
}
$conexion->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="img/icon3.png" type="image/x-icon">
    <title>Iniciar sesión</title>

    <style>
        body {
            margin: 0; /*no espacio adicional de la margen*/
            padding: 0; /*no espacio adicional del interior*/
            background-color: #001529;
            font-family: 'Cormorant Garamond', serif;
            color: #fff02d;
        }

         /*ESTILOS PARA EL NAVBAR*/
         .custom-navbar {
             background-color:  #001529;
             margin-bottom: 20px;
             margin-top: -20px;
         }

         /*log in, sign up y la bolsa*/
         .span-navbar a {
          margin-left: 50px; /* Ajusta el valor según lo necesites */
          margin-right: -10px;
         }
         /*diseño de la bolsa*/
         .sh_bag{
          width:35%;
          height:35%;
          margin-top: -5px;
         }

         .navbar a {
             float: left; /*se alineas a la izquierda horizontalmente*/
             display: block; /*ocupan toda la línea*/
             color: #fff02d;
             text-align: center;
             padding: 14px 20px;/*Agrega un espacio de 14 píxeles arriba y abajo, y de 20 píxeles a la izquierda y derecha de los enlaces*/
             text-decoration: none;/* Elimina el subrayado predeterminado de los enlaces*/
             margin-left: 50px;/*Aplica un margen izquierdo de 50 píxeles, separando cada enlace de los demás*/
         }
         .navbar a:hover {
             background-color: #dddddd51;
             color: white;
         }


/*ESTILO PARA EL FORMULARIO*/
        .border-box {
    border: 2px solid #f4d03f; /* Amarillo dorado */
    padding: 30px;
    border-radius: 5px;
    width: 90%;
    max-width: 600px;
}
.container{
  margin-top: -80px;
}

.mb-4{
    color: #001529;
}

.form-control{
    margin-top: -5px;
    margin-bottom: 10px;
}

.custom-logo {
    font-size: 100px;
    font-family: 'Cursive', sans-serif; /* Fuente estilizada */
}

.name-text {
    font-size: 20px;
    margin-top: -20px;
}

.border-gold {
    border: 2px solid #001529;
    border-radius: 10px;
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
    margin-top: -35px;
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


     
        /*ESTILOS PARA LA PANTALLA DE CARGA */
        /*contenedor principal*/
        #loading-screen {
            position: fixed; /*cubre toda el área de la ventana.*/
            /* Asegura que la pantalla de carga comience en la esquina superior izquierda.*/
            top: 0;
            left: 0;
            /*Hace que la pantalla de carga ocupe todo el ancho y alto de la ventana.*/
            width: 100%;
            height: 100%;

            background-color: rgba(0, 21, 41, 0.9);/*oscurecer la pantalla*/
            /*Centra el contenido*/
            display: flex;
            align-items: center;
            justify-content: center;

            z-index: 1000;/*Coloca la pantalla de carga encima de otros elementos en la página.*/
            animation: fadeOut 2s ease forwards; /*Aplica una animación de desvanecimiento*/
        }

        /* se aplica a la imagen dentro del contenedor*/
        /*Aplica una animación de rotación a la imagen para que gire continuamente.*/
        #loading-screen img {
            width: 100px;
            animation: spin 1s infinite linear;/*se ejecuta en 1 segundo y se repite indefinidamente con una velocidad constante*/
        }

        /*Define la animación de rotación de la imagen*/
        @keyframes spin {
            from { transform: rotate(0deg); }/*Al inicio de la animación, la imagen no tiene rotación*/

            /*Este efecto se repite continuamente debido a infinite en animation: spin 1s infinite linear;*/
            to { transform: rotate(360deg); }/*la imagen rota 360 grados en el transcurso de la animación*/
        }

        /*Define la animación de desvanecimiento para ocultar la pantalla de carga*/
        @keyframes fadeOut {
            0% { opacity: 1; }/*Al inicio, el contenedor es completamente opaco*/

            /*La pantalla de carga se desvanece en 2 segundos debido a animation: fadeOut 2s ease forwards*/
            100% { opacity: 0; visibility: hidden; } /*Al final de la animación, el contenedor es completamente transparente y queda oculto*/
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
        <a class="navbar-brand" href="index.html"><img src="img5 (3).png" alt=""></a>
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
                <a class="nav-link" href="sign_up.php"><i>SIGN UP</i></a>
                <a class="nav-link" href="PA_inicio de sesion.php"><i>LOG IN</i></a>
                <a class="nav-link" href="#"><img src="img/sh_bag.png" alt="bag" class="sh_bag"></a>
            </span>
        </div>
    </div>
  </nav>


    
    <!-- Formulario de inicio de sesión -->
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="width: 22rem;">
            <h2 class="mb-4">Login</h2>
            <form action="PA_inicio de sesion.php" method="post">
                <div class="form-group">
                    <label for="email" class="mb-4">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password" class="mb-4">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Log In</button>
            </form>
            <div class="mt-3">
                <a href="#">Forgot your password?</a><br>
                <a href="sing_up.php">Don't have an account? Sign up</a>
            </div>
        </div>
    </div>




<!--FOOTER-->
<footer>
    <!-- Sección de iconos y correo electrónico -->
    <div class="footer-top">
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
  
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
        <p class="p-foot"><i>ovejas++@asdi.com</i></p>
    </div>
  
    <!-- Sección de copyright y enlaces legales -->
    <div class="footer-bottom">
        <p><i>&copy; S M & L | Diseñador Web: Ovejas++ | <a href="#">Aviso legal</a> · <a href="#">Política de privacidad</i></a></p>
    </div>
  </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
