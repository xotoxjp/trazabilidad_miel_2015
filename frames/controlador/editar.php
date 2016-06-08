<?php
 session_start(); 
 require '../clases/usuario.php';
 $usuarioEspejo= new Usuario();
 $usuarioOtro = new Usuario();
 $usuarioOtro = $usuarioEspejo->buscarUsuario($_GET['id']); 
 $modo = $_GET['modo'];