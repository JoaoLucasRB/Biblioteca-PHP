<?php

# Importacoes necessaria
require_once("banco-usuario.php"); # Funcoes do banco de dados
require_once("conector.php"); # Conexao ao BD
require("../php/mailer/class.phpmailer.php");

class Usuarios {

    # Funcao para adicionar um usuario no banco de dados
    public function adicionarUsuario($nomeUsuario, $email, $senha, $privilegio){
        $conector = new Conector();
        $banco = new BancoUsuario();
        $usuario = new Usuario(0, $nomeUsuario, $email, $senha, new Privilegio($privilegio, ""), 0);
        $userEmp = $this->buscarUsuarioNome($nomeUsuario);
        $emailEmp = $this->buscarUsuarioEmail($email);
        if(empty($userEmp)){
            if(empty($emailEmp)){
                if($banco->adicionarUsuario($conector->getConexao(), $usuario)){
                    $_SESSION['success'] = "Usuario cadastrado com sucesso.";
                } else {
                    $_SESSION['danger'] = "Falha ao adicionar usuario, tente novamente.";
                }
            } else {
                $_SESSION['warning'] = "Email ja cadastrado, tente novamente.";
            }
        } else {
            $_SESSION['warning'] = "Nome de usuario ja existe, tente novamente.";
        }
        header("Location: ../php/usuarios.php");
    }

    # Funcao para remover um usuario do banco de dados
    public function removerUsuario($id){
        $conector = new Conector();
        $banco = new BancoUsuario();
        if($banco->removerUsuario($conector->getConexao(), $id)){
            $_SESSION['success'] = "Usuario removido com sucesso";
        } else {
            $_SESSION['danger'] = "Falha ao remover usuario, tente novamente.";
        }
        header("Location: ../php/usuarios.php");
    }

    # Funcao para alterar um usuario do banco de dados
    public function alterarUsuario($id, $nomeUsuario, $email, $privilegio, $alt){
        $conector = new Conector();
        $banco = new BancoUsuario();
        $usuario = new Usuario($id, $nomeUsuario, $email, 0, new Privilegio($privilegio, ""), 0);
        switch($alt){
            case 1: # Nenhuma alteracao
                if($banco->alterarUsuario($conector->getConexao(), $usuario)){
                    $_SESSION['success'] = "Usuario modificado com sucesso.";
                } else {
                    $_SESSION['danger'] = "Falha ao modificar usuario, tente novamente.";
                }
                break;
            case 2: # Usuario alterado
                $userEmp = $this->buscarUsuarioNome($usuario->getNome());
                if(empty($userEmp)){
                    if($banco->alterarUsuario($conector->getConexao(), $usuario)){
                        $_SESSION['success'] = "Usuario modificado com sucesso.";
                    } else {
                        $_SESSION['danger'] = "Falha ao modificar usuario, tente novamente.";
                    }
                } else {
                    $_SESSION['warning'] = "Usuario ja existente, tente novamente.";
                }
                break;
            case 3: # Email alterado
                $emailEmp = $this->buscarUsuarioEmail($usuario->getEmail());
                if(empty($emailEmp)){
                    if($banco->alterarUsuario($conector->getConexao(), $usuario)){
                        $_SESSION['success'] = "Usuario modificado com sucesso.";
                    } else {
                        $_SESSION['danger'] = "Falha ao modificar usuario, tente novamente.";
                    }
                } else {
                    $_SESSION['warning'] = "Email ja cadastrado, tente novamente.";
                }
                break;
            case 4: # Usuario e Email alterados
                $userEmp = $this->buscarUsuarioNome($usuario->getNome());
                $emailEmp = $this->buscarUsuarioEmail($usuario->getEmail());
                if(empty($userEmp)){
                    if(empty($emailEmp)){
                        if($banco->alterarUsuario($conector->getConexao(), $usuario)){
                            $_SESSION['success'] = "Usuario modificado com sucesso.";
                        } else {
                            $_SESSION['danger'] = "Falha ao modificar usuario, tente novamente.";
                        }
                    } else {
                        $_SESSION['warning'] = "Email ja cadastrado, tente novamente.";
                    }
                } else {
                    $_SESSION['warning'] = "Usuario ja existente, tente novamente.";
                }
                break;
        }
        header("Location: ../php/usuarios.php");
    }

    # Funcao que retorna uma lista com todos os usuarios do banco de dados
    public function getUsuarios($pagina){
        $conector = new Conector();
        $banco = new BancoUsuario();
        return $banco->getUsuarios($conector->getConexao(), $pagina);
    }

    # Funcao que retorna o objeto de um usuario do banco de dados
    public function buscarUsuario($login, $senha){
        $conector = new Conector();
        $banco = new BancoUsuario();
        return $banco->buscarUsuario($conector->getConexao(), $login, $senha);
    }

    # Funcao que verifica se um NOME DE USUARIO ja existe no banco de dados
    private function buscarUsuarioNome($nome){
        $conector = new Conector();
        $banco = new BancoUsuario(); 
        return $banco->buscarUsuarioNome($conector->getConexao(), $nome);
    }

    # Funcao que verifica se um NOME DE USUARIO ja existe no banco de dados
    private function buscarUsuarioNomeCad($nome){
        $conector = new Conector();
        $banco = new BancoUsuario(); 
        return $banco->buscarUsuarioNomeCad($conector->getConexao(), $nome);
    }

    # Funcao que verifica se um EMAIL ja existe no banco de dados
    private function buscarUsuarioEmail($email){
        $conector = new Conector();
        $banco = new BancoUsuario();
        return $banco->buscarUsuarioEmail($conector->getConexao(), $email);
    }

    # Funcao que verifica se um EMAIL ja existe no banco de dados
    private function buscarUsuarioEmailCad($email){
        $conector = new Conector();
        $banco = new BancoUsuario();
        return $banco->buscarUsuarioEmailCad($conector->getConexao(), $email);
    }

    # Funcao que verifica se um usuario ja esta na lista de cadastro do banco de dados
    private function buscarUsuarioCadastro($chaveReg){
        $conector = new Conector();
        $banco = new BancoUsuario();
        return $banco->buscarUsuarioCadastro($conector->getConexao(), $chaveReg);
    }

    # Funcao que adiciona um novo usuario a lista de cadastro
    public function iniciarCadastro($nomeUsuario, $email, $senha, $privilegio){
        $conector = new Conector();
        $banco = new BancoUsuario();
        $usuario = new Usuario(0, $nomeUsuario, $email, $senha, new Privilegio($privilegio, ""), 0);
        $userEmp = $this->buscarUsuarioNome($nomeUsuario);
        $userEmpCad =$this->buscarUsuarioNomeCad($nomeUsuario);
        $emailEmp = $this->buscarUsuarioEmail($email);
        $emailEmpCad = $this->buscarUsuarioEmailCad($email);
        $chaveReg = md5($usuario->getNome().$usuario->getEmail());
        $cadEmp = $this->buscarUsuarioCadastro($chaveReg);
        if(empty($userEmp) && empty($userEmpCad)){
            if(empty($emailEmp) && empty($emailEmpCad)){
                if(empty($cadEmp)){
                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->Host = "mail.cenep.com.br";
                    #$mail->Port = 465;
                    #$mail->SMTPSecure = 'ssl';
                    $mail->Port = 587;
                    $mail->SMTPAuth = true;
                    $mail->Username = "biblioteca@cenep.com.br";
                    $mail->Password = "lASv~2]d1K?i";
                    
                    $mail->setFrom("biblioteca@cenep.com.br", "Biblioteca Cenep");
                    $mail->addAddress("{$email}");
                    $mail->Subject = "Registro - Biblioteca Cenep";
                    $mail->msgHTML("<html>Ola {$nome}, clique nesse link para concluir seu cadastro: <br/> <a href='http://biblioteca.cenep.com.br/php/finalizar.php?chave={$chaveReg}'> Clique Aqui! </a>");
                    $mail->altBody = "Ola {$nome}, clique nesse link para concluir seu cadastro: http://biblioteca.cenep.com.br/php/finalizar.php?chave={$chaveReg}";
                    if($banco->iniciarCadastro($conector->getConexao(), $usuario) && $mail->send()){
                        $_SESSION['success'] = "Cadastrado efetuado com sucesso. Por favor verifique seu email";
                        header("Location: ../index.php");
                    } else {
                        $this->removerCadastro($chaveReg);
                        $_SESSION['danger'] = "Falha ao se cadastrar, tente novamente.";
                    }
                }
                
            } else {
                $_SESSION['warning'] = "Email ja cadastrado, tente novamente.";
            }
        } else {
            $_SESSION['warning'] = "Nome de usuario ja existe, tente novamente.";
        }
        header("Location: ../php/cadastro.php");
    }

    # Funcao que retorna os dados de um cadastro
    public function getCadastro($chaveReg){
        $conector = new Conector();
        $banco = new BancoUsuario();
        return $banco->getCadastro($conector->getConexao(), $chaveReg);
    }

    # Funcao para finalizar o cadastro de um usuario no banco de dados
    public function finalizarCadastro(Usuario $usuario, $chaveReg){
        $conector = new Conector();
        $banco = new BancoUsuario();
        if($banco->adicionarUsuarioCadastro($conector->getConexao(), $usuario)){
            $this->removerCadastro($chaveReg);
            $_SESSION['success'] = "Cadastro concluido.";
        } else {
            $_SESSION['danger'] = "Falha ao concluir cadastro, por favor tente novamente.";
            $this->removerCadastro($chaveReg);
        }
        header("Location: ../index.php");
    }

    # Funcao para remover um cadastro do banco de dados
    public function removerCadastro($chaveReg){
        $conector = new Conector();
        $banco = new BancoUsuario();
        $banco->removerCadastro($conector->getConexao(), $chaveReg);
    }

    # Funcao para iniciar o processo de recuperacao de senha de um usuarios
    public function iniciarRecuperacao($email){
        $conector = new Conector();
        $banco = new BancoUsuario();
        $id = $this->buscarUsuarioEmail($email);
        $emailMd5 = md5($email);
        if(!empty($id)){
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = "mail.cenep.com.br";
            #$mail->Port = 465;
            #$mail->SMTPSecure = 'ssl';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = "biblioteca@cenep.com.br";
            $mail->Password = "lASv~2]d1K?i";
            
            $mail->setFrom("biblioteca@cenep.com.br", "Cenep");
            $mail->addAddress("{$email}");
            $mail->Subject = "Recuperacao de Senha - Biblioteca Cenep";
            $mail->msgHTML("<html>Ola {$nome}, clique nesse link para recuperar sua senha: <br/> <a href='http://biblioteca.cenep.com.br/php/recuperar.php?chave={$emailMd5}'> Clique Aqui! </a>");
            $mail->altBody = "Ola {$nome}, clique nesse link para recuperar sua senha: http://biblioteca.cenep.com.br/php/recuperar.php?chave={$emailMd5}";
            if($banco->inicarRecuperacao($conector->getConexao(), $id, $emailMd5) && $mail->send()){
                $_SESSION['success'] = "Recuperacao de senha solicitada, por favor verifique seu email.";
            } else {
                $this->removerRecuperacao($id);
                $_SESSION['danger'] = "Falha ao solicitar recuperacao, tente novamente.";
            }
        } else {
            $_SESSION['warning'] = "Esse endereço de email nao esta cadastrado.";
            header("Location: ../php/recuperacao.php");
            die();
        }
        header("Location: ../index.php");
    }

    # Funcao que retorna os dados de uma recuperacao
    public function getRecuperacao($chaveRec){
        $conector = new Conector();
        $banco = new BancoUsuario();
        return $banco->getRecuperacao($conector->getConexao(), $chaveRec);
    }

    # Funcao para alterar senha de um usuario
    public function alterarSenha($id, $senha){
        $conector = new Conector();
        $banco = new BancoUsuario();
        if($banco->alterarSenha($conector->getConexao(), $id, $senha)){
            $_SESSION['success'] = "Senha alterado com sucesso.";
            $this->removerRecuperacao($id);
        } else {
            $_SESSION['danger'] = "Falha ao alterar senha, tente novamente";
            $this->removerRecuperacao($id);
        }
        header("Location: ../index.php");
    }

    # Funcao para remover uma solicitacao da lista de recuperacao
    public function removerRecuperacao($id){
        $conector = new Conector();
        $banco = new BancoUsuario();
        $banco->removerRecuperacao($conector->getConexao(), $id);
    }
}