<?php

# Importacoes Necessarias
require_once("class/controlador.php");
$controlador = new Controlador();
$controlador->verificarAcesso();

if(($_POST['nomeUsuario'] != "") && ($_POST['emailUsuario'] != "") && ($_POST['senUsuario'] != "") && ($_POST['confSen'] != "")){
    if($_POST['senUsuario'] == $_POST['confSen']){
        $nome = $_POST['nomeUsuario'];
        $email = $_POST['emailUsuario'];
        $senha = $_POST['senUsuario'];
        $privilegio = $_POST['privUsuario'];
        $controlador->adicionarUsuario($nome, $email, $senha, $privilegio);
    } else {
        $_SESSION['warning'] = "As senhas nao coincidem, tente novamente.";
        header("Location: ../php/usuarios.php");
    }
} else {
    $_SESSION['warning'] = "Algum campo ficou em branco, tente novamente.";
    header("Location: ../php/usuarios.php");
}