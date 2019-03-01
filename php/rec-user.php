<?php

# Importacoes necessarias
require_once("class/controlador.php");
$controlador = new Controlador();

if($_POST['emailUsuario'] != "") {
    $controlador->iniciarRecuperacao($_POST['emailUsuario']);
} else {
    $_SESSION['warning'] = "Por favor informe um email.";
    header("Location: recuperacao.php");
}