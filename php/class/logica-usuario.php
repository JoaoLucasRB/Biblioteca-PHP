<?php
# Inicia a sessao do usuario
session_start();

class LogicaUsuario {

    # Funcao que efetua a criacao dos cookies de login do usuario
    public function logarUsuario($email, $nome_usuario, $privilegio){
        $_SESSION["email_logado"] = $email;
        $_SESSION["usuario_logado"] = $nome_usuario;
        $_SESSION["privilegio"] = $privilegio;
    }
    # Funcao que retornam as informacoes do usuario logado
    public function emailLogado(){
        return $_SESSION["email_logado"];
    }
    public function usuarioLogado(){
        return $_SESSION["usuario_logado"];
    }
    public function privilegio(){
        return $_SESSION["privilegio"];
    }
    # Funcoes que retornam se o cookie da sessao existe
    public function emailEstaLogado(){
        return isset($_SESSION["email_logado"]);
    }
    public function usuarioEstaLogado(){
        return isset($_SESSION["usuario_logado"]);
    }
    # Funcao para verificar se o usuario esta logado
    public function verificarUsuario(){
        if(!$this->emailEstaLogado()){
            $_SESSION["danger"] = "Por favor efetue o login primeiro.";
            header("Location: ../index.php");
        }
    }
    # Funcao para verificar o nivel de privilegio
    public function verificarPrivilegioUsuario(){
        if($this->privilegio() == 3){
            $_SESSION['warning'] = "Voce nao tem acesso a essa pagina";
            header("Location: home.php");
        }
    }
    # Funcao para encerrar a sessao do usuario
    public function logout(){
        session_destroy();
        session_start();
        $_SESSION['success'] = "Deslogado com sucesso.";
        header("Location: ../index.php");
    }

}
