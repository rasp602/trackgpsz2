<?php include_once 'header.php'; ?>
<?php include_once '../../bd/conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Sistema GPS</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    margin:0;
    height:100vh;
    background:#2f3e75;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:'Segoe UI',sans-serif;
}

/* CUADRO PRINCIPAL MAS GRANDE */

.login-wrapper{
    width:95%;
    max-width:1300px;
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 25px 70px rgba(0,0,0,.35);
}

/* LADO LOGIN */

.login-left{
    padding:70px 60px;
    text-align:center;
}

/* LOGO */

.logo img{
    width:140px;
    margin-bottom:30px;
}

/* ICONO USUARIO */

.user-icon{

    width:90px;
    height:90px;
    border-radius:50%;

    background:#2f3e75;

    display:flex;
    align-items:center;
    justify-content:center;

    margin:auto;
    margin-bottom:30px;

}

/* ICONO BLANCO */

.user-icon svg{
    width:45px;
    fill:white;
}

/* INPUTS */

.form-control{
    border-radius:30px;
    padding:14px 20px;
    font-size:16px;
}

/* BOTON */

.btn-login{
    background:#2f3e75;
    border:none;
    border-radius:30px;
    padding:14px;
    font-weight:600;
}

.btn-login:hover{
    background:#1f2c5a;
}

/* LADO DERECHO */

.login-right{

    background:linear-gradient(120deg,#1e3c72,#2a5298);

    color:white;

    display:flex;
    align-items:center;
    justify-content:center;

    text-align:center;
    padding:100px;

}

.login-right h1{
    font-size:60px;
    font-weight:700;
}

.login-right p{
    font-size:18px;
    opacity:.9;
}

/* RESPONSIVE */

@media(max-width:900px){

.login-right{
display:none;
}

}

</style>

</head>

<body>

<div class="login-wrapper">

<div class="row g-0">

<!-- PANEL LOGIN -->

<div class="col-md-4 login-left">

<div class="logo">
<img src="../../img/logogps.jpg">
</div>

<div class="user-icon">

<!-- ICONO USUARIO BLANCO -->

<svg viewBox="0 0 24 24">
<path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 
2.3-5 5 2.3 5 5 5zm0 2c-3.3 
0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>
</svg>

</div>

<form action="../../handler.php" method="POST">

<div class="mb-3">

<input
type="text"
name="txtUsuario"
class="form-control"
placeholder="Usuario o correo"
required>

</div>

<div class="mb-3">

<input
type="password"
name="txtPassword"
class="form-control"
placeholder="Contraseña"
required>

</div>

<div class="d-grid">

<button class="btn btn-login text-white">
LOGIN
</button>

</div>

<?php
if(isset($_GET["error"])){

echo '<div class="text-danger mt-3">
Usuario o contraseña incorrecta
</div>';

}
?>

<input type="hidden" name="c" value="login">
<input type="hidden" name="a" value="Procesar">

</form>

</div>

<!-- PANEL DERECHO -->

<div class="col-md-8 login-right">

<div>

<h1>Welcome</h1>

<p>
Plataforma de monitoreo GPS en tiempo real.<br>
Controla vehículos, rutas y ubicaciones desde un solo sistema.
</p>

</div>

</div>

</div>

</div>

</body>
</html>