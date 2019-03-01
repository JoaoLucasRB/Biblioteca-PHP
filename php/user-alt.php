<?php

# Importacoes necessarias
require_once("class/controlador.php");
$controlador = new Controlador();
$controlador->verificarAcesso();

$idUser = $_POST['idUser'];
$privId = $_POST['privUser'];
if(($_POST['nomeUsuario'] != "") && ($_POST['emailUsuario'] != "")){
    $email = $_POST['emailUsuario'];
    $nome = $_POST['nomeUsuario'];
    $emailAntigo = $_POST['emailUsuarioAntigo'];
    $nomeAntigo = $_POST['nomeUsuarioAntigo'];
    if($nome == $nomeAntigo){
        $nomeAlt = 0;
    } else {
        $nomeAlt = 1;
    }
    if($email == $emailAntigo){
        $emailAlt = 0;
    } else {
        $emailAlt = 1;
    }
    if(($nomeAlt == 0) && ($emailAlt == 0)){
        $controlador->alterarUsuario($idUser, $nome, $email, $privId, 1);
    } else if(($nomeAlt == 1) && ($emailAlt == 0)){
        $controlador->alterarUsuario($idUser, $nome, $email, $privId, 2);
    } else if(($nomeAlt == 0) && ($emailAlt == 1)){
        $controlador->alterarUsuario($idUser, $nome, $email, $privId, 3);
    } else if(($nomeAlt == 1) && ($emailAlt == 1)){
        $controlador->alterarUsuario($idUser, $nome, $email, $privId, 4);
    }
} else {
    $_SESSION['warning'] = "Algum campo ficou em branco, tente novamente.";
    header("Location: usuarios.php");
}
    