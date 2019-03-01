<?php

# Importacoes necessarias
require_once("class/controlador.php");
$controlador = new Controlador();

if(($_POST['nomeUsuario'] != "") && ($_POST['emailUsuario'] != "") && ($_POST['senUsuario'] != "") && ($_POST['confSen'] != "")){
    if($_POST['senUsuario'] == $_POST['confSen']){
        $privilegio = $_POST['privUsuario'];
        $nome = $_POST['nomeUsuario'];
        $email = $_POST['emailUsuario'];
        $senha = $_POST['senUsuario'];
        $controlador->iniciarCadastro($nome, $email, $senha, $privilegio);
    } else {
        $_SESSION['warning'] = "Os campos SENHA e CONFIRMAR SENHA nao coincidem. Tente novamente";
        header("Location: cadastro.php");
    }
} else {
    $_SESSION['warning'] = "Algum campo importante ficou em branco. Tente novamente";
    header("Location: cadastro.php");
}
