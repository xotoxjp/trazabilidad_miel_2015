<!-- posible causa de error de cookie 20/09/2014 <?php include "frames/funciones.php"; ?>-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Bienvenid@</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <link rel="shortcut icon" href="frames/fotos/chmiel.ico"> 
	<link href="index.css" rel="stylesheet" type="text/css" />
</head>

<body onLoad='this.document.menu.logg.focus()'>

  <div class="container">    

  <div class="login">
    <h1>Iniciar Sesión</h1>
    <form name='menu' method="post" action="frames/wentro.php">
      <p><input type="text" name="logg" value="" placeholder="Nombre de Usuario"></p>
      <p><input type="password" name="pass" value="" placeholder="Password"></p>
      <p id="mensajefailsesion"> <?php echo $_SESSION["mensaje"];?></p>        
      <!--p class="remember_me">
      <label>
        <input type="checkbox" name="remember_me" id="remember_me">
        Recordarme en esta computadora
      </label>
      </p-->
      <p class="submit"><input type="submit" name="B2" value="Login"></p>
    <input name="flag" type="hidden" id="flag" value="1" size="15" />
    </form>
  </div> 
    
  <!--div class="login-help">
      <p>¿Olvidó su contraseña? <a href="#">Click aquí para resetearla</a>.</p>
  </div--> 

  </div>

</body>
</html>
