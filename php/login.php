<?php

# Importacoes necessarias
require_once("class/controlador.php"); # Interface de comunicacao com o back-end
$controlador = new Controlador();
$controlador->verificarAcesso();

if(($_POST['login'] != "") && ($_POST['senha'] != "")){
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $usuario = $controlador->buscarUsuario($login, $senha);
    if($usuario->getId() == null){
        $_SESSION["danger"] = "Login ou senha invalidos.";
        header("Location: ../index.php");
    } else {
        $controlador->logarUsuario($usuario->getEmail(), $usuario->getNome(), $usuario->getPrivilegioId());
        header("Location: ../php/home.php");
    }
} else {
    $_SESSION['warning'] = "Algum campo ficou em branco. Tente novamente.";
    header("Location: ../index.php");
}
die();