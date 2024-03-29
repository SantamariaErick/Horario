<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login</title>
<link href="css/estiloIndex.css" rel="stylesheet" type="text/css">
<link href="css/estiloformindex.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
</head>
<?php
	
	include_once 'php/conexion.php';
	session_start();
	
	if(isset($_GET['cerrar_sesion'])){
        session_unset(); 

        // destroy the session 
        session_destroy(); 
    }
    
    if(isset($_SESSION['rol'])){
        switch($_SESSION['rol']){
            case 1:
				header('location: php/admin.php');
			break;

			case 2:
				header('location: php/supervisor.php');
			break;

			case 3:
				header('location: php/docente.php');
			break;

			case 4:
				header('location: php/alumno.php');
			break;

            default:
        }
    }
	
	$validar = true;

    if(isset($_POST['usuario']) && isset($_POST['password'])){
        $username = $_POST['usuario'];
        $password = $_POST['password'];
			
        $db = new Database();
        $query = $db->connect()->prepare("SELECT * FROM ho_usuarios WHERE usu_user = :username AND usu_clave = :password ");
        $query->execute(['username' => $username, 'password' => $password]);

        $row = $query->fetch(PDO::FETCH_NUM);
        $validar = true;
        if($row == true){
			
            $rol = $row[4];
            
            $_SESSION['rol'] = $rol;
            switch($rol){
                case 1:
                    header('location: php/admin.php');
                break;

                case 2:
                	header('location: php/supervisor.php');
                break;
				
				case 3:
                	header('location: php/docente.php');
                break;
				
				case 4:
                	header('location: php/alumno.php');
                break;

                default:
            }
        }else{
            // no existe el usuario
            $validar = false;
        }
        

    }
	
?>
<body>
	<div class="contenedor-logo">
		<img src="img/logo_login.svg" alt="logo" width="90%">
	</div>
	<div class="contenedor centrar">
		<form id="form1" name="form1" method="post" action="#">
		  <h1 class="titulo">Iniciar Sesión</h1>
		  <?php
			if(!$validar){
				?><p class="error margin-bottom"><i class="fas fa-times fa-fw"></i> El nombre de usuario o contraseña es incorrecto</p><?php
			}
		  ?>
		  <div><span class="icono-form" for="usuario"><i class="fas fa-user fa-fw"></i></span>
		  <input type="text" name="usuario" id="idusuario" placeholder="Usuario" required></div>
		  
		  <div><span class="icono-form" for="password"><i class="fas fa-key fa-fw"></i></span>
          <input type="password" name="password" id="idgpassword" placeholder="Contraseña" required></div>
          
		  <div class="margin-top">
		    <button type="submit" name="submit" id="idsubmit" value="Iniciar sesión"><i class="fas fa-sign-in-alt fa-fw"></i>&nbsp;&nbsp;Ingresar</button>
			<button type="reset" name="reset" id="idreset" value="limpiar"><i class="fas fa-times-circle fa-fw"></i></button>
		  </div>
		</form>
	</div>
</body>
</html>
