<?php

require_once("usuario.php");
require_once("privilegio.php");

class BancoUsuario {

    # Funcao para adicionar um usuario no banco dados
    public function adicionarUsuario($conexaoBD, Usuario $usuario){
        $nome = $conexaoBD->real_escape_string($usuario->getNome());
        $email = $conexaoBD->real_escape_string($usuario->getEmail());
        $senha = $conexaoBD->real_escape_string(md5($usuario->getSenha()));
        $privilegio = $conexaoBD->real_escape_string($usuario->getPrivilegioId());
        $query = "insert into usuario (nome_usuario, email, senha, privilegio_id) values ('{$nome}', '{$email}', '{$senha}', {$privilegio})";
        return $conexaoBD->query($query);
    }

    # Funcao para adicionar um usuario atraves do cadastro no banco dados
    public function adicionarUsuarioCadastro($conexaoBD, Usuario $usuario){
        $nome = $conexaoBD->real_escape_string($usuario->getNome());
        $email = $conexaoBD->real_escape_string($usuario->getEmail());
        $senha = $conexaoBD->real_escape_string($usuario->getSenha());
        $privilegio = $conexaoBD->real_escape_string($usuario->getPrivilegioId());
        $query = "insert into usuario (nome_usuario, email, senha, privilegio_id) values ('{$nome}', '{$email}', '{$senha}', {$privilegio})";
        return $conexaoBD->query($query);
    }
    # Funcao para remover um usuario do banco de dados
    public function removerUsuario($conexaoBD, $id){
        $id = $conexaoBD->real_escape_string($id);
        $query = "delete from usuario where id={$id}";
        return $conexaoBD->query($query);
    }

    # Funcao para alterar os dados de um usuario no banco de dados
    public function alterarUsuario($conexaoBD, Usuario $usuario){
        $id = $conexaoBD->real_escape_string($usuario->getId());
        $nome = $conexaoBD->real_escape_string($usuario->getNome());
        $email = $conexaoBD->real_escape_string($usuario->getEmail());
        $privilegio = $conexaoBD->real_escape_string($usuario->getPrivilegioId());
        $query = "update usuario set nome_usuario='{$nome}', email='{$email}', privilegio_id={$privilegio} where id={$id}";
        return $conexaoBD->query($query);
    }

    # Funcao que retorna uma lista com todos os usuarios do banco de dados
    public function getUsuarios($conexaoBD, $pagina){
        $quantidade = 15;
        $inicio = 0 + ($quantidade * ($pagina - 1));
        $query = "select u.id, u.email, u.nome_usuario, u.datauser, u.privilegio_id, p.nome from usuario u join
                privilegio p on u.privilegio_id = p.id limit {$inicio},{$quantidade}";
        $resultado = $conexaoBD->query($query);
        $usuarios = array();
        while($usuario = $resultado->fetch_assoc()){
            array_push($usuarios, new Usuario($usuario['id'], $usuario['nome_usuario'], $usuario['email'], 0, new Privilegio($usuario['privilegio_id'], $usuario['nome']), $usuario['datauser']));
        }
        return $usuarios;
    }

    # Funcao que retorna o objeto de um usuario do banco de dados
    public function buscarUsuario($conexaoBD, $login, $senha){
        $login = $conexaoBD->real_escape_string($login);
        $senha= md5($senha);
        $senha = $conexaoBD->real_escape_string($senha);
        $query = "select u.id, u.nome_usuario, u.email, u.privilegio_id, u.datauser, p.nome from usuario u join privilegio p on p.id = u.privilegio_id where (nome_usuario='{$login}' or email='{$login}') and senha='{$senha}'";
        $resultado = $conexaoBD->query($query);
        $dados = $resultado->fetch_assoc();
        return $usuario = new Usuario($dados['id'], $dados['nome_usuario'], $dados['email'], 0, new Privilegio($dados['privilegio_id'], $dados['nome']), $dados['datauser']);
    }

    # Funcao que verifica se um NOME DE USUARIO ja existe no banco de dados
    public function buscarUsuarioNome($conexaoBD, $nome){
        $nome = $conexaoBD->real_escape_string($nome);
        $query = "select id from usuario where nome_usuario='{$nome}'";
        $resultado = $conexaoBD->query($query);
        return $usuario = $resultado->fetch_assoc();
    }

    # Funcao que verifica se um NOME DE USUARIO ja existe no banco de dados
    public function buscarUsuarioNomeCad($conexaoBD, $nome){
        $nome = $conexaoBD->real_escape_string($nome);
        $query = "select id from cadastro where nomeCad='{$nome}'";
        $resultado = $conexaoBD->query($query);
        return $usuario = $resultado->fetch_assoc();
    }

    # Funcao que verifica se um EMAIL ja existe no banco de dados
    public function buscarUsuarioEmail($conexaoBD, $email){
        $email = $conexaoBD->real_escape_string($email);
        $query = "select id from usuario where email='{$email}'";
        $resultado = $conexaoBD->query($query);
        $usuario = $resultado->fetch_assoc();
        return $usuario['id'];
    }

    # Funcao que verifica se um EMAIL ja existe no banco de dados
    public function buscarUsuarioEmailCad($conexaoBD, $email){
        $email = $conexaoBD->real_escape_string($email);
        $query = "select id from cadastro where emailCad='{$email}'";
        $resultado = $conexaoBD->query($query);
        return $usuario = $resultado->fetch_assoc();
    }

    # Funcao que verifica se um usuario ja esta na lista de cadastro
    public function buscarUsuarioCadastro($conexaoBD, $chaveReg){
        $chaveReg = $conexaoBD->real_escape_string($chaveReg);
        $query = "select id from cadastro where chaveReg='{$chaveReg}'";
        $resultado = $conexaoBD->query($query);
        return $replica = $resultado->fetch_assoc();
    }

    # Funcao que adiciona um usuario a lista de cadastro
    public function iniciarCadastro($conexaoBD, Usuario $usuario){
        $nomeUsuario = $conexaoBD->real_escape_string($usuario->getNome());
        $email = $conexaoBD->real_escape_string($usuario->getEmail());
        $senha = $conexaoBD->real_escape_string(md5($usuario->getSenha()));
        $chaveReg = md5($usuario->getNome().$usuario->getEmail());
        $chaveReg = $conexaoBD->real_escape_string($chaveReg);
        $privilegio = $conexaoBD->real_escape_string($usuario->getPrivilegioId());
        $query = "insert into cadastro(nomeCad, emailCad, senCad, priv, chaveReg) values ('{$nomeUsuario}','{$email}','{$senha}',{$privilegio},'{$chaveReg}')";
        return $conexaoBD->query($query);
    }

    # Funcao que remove um cadastro em caso de erro
    public function removerCadastro($conexaoBD, $chaveReg){
        $chaveReg = $conexaoBD->real_escape_string($chaveReg);
        $query = "delete from cadastro where chaveReg='{$chaveReg}'";
        $conexaoBD->query($query);
    }

    # Funcao que retorna os dados de um cadastro
    public function getCadastro($conexaoBD, $chaveReg){
        $chaveReg = $conexaoBD->real_escape_string($chaveReg);
        $query = "select * from cadastro where chaveReg='{$chaveReg}'";
        $resultado =  $conexaoBD->query($query);
        $dados = $resultado->fetch_assoc();
        $cadastro = new Usuario(0, $dados['nomeCad'], $dados['emailCad'], $dados['senCad'], new Privilegio($dados['priv'], ""), 0);
        return $cadastro;
    }

    # Funcao para iniciar a recuperacao da senha de um usuario pela pagina recuperacao.php | tabela recuperacao
    public function inicarRecuperacao($conexaoBD, $id, $chaveRec){
        $id = $conexaoBD->real_escape_string($id);
        $chaveRec = $conexaoBD->real_escape_string($chaveRec);
        $query = "insert into recuperacao (chaveRec, idRec) values ('{$chaveRec}', {$id})";
        return $conexaoBD->query($query);
    }

    # Funcao que retorna os dados de uma recupercao
    public function getRecuperacao($conexaoBD, $chaveRec){
        $chaveRec = $conexaoBD->real_escape_string($chaveRec);
        $query = "select * from recuperacao where chaveRec='{$chaveRec}'";
        $resultado = $conexaoBD->query($query);
        return $resultado->fetch_assoc();
    }

    # Funcao que altera a senha de um usuario no banco de dados
    public function alterarSenha($conexaoBD, $id, $senha){
        $id = $conexaoBD->real_escape_string($id);
        $senha = md5($senha);
        $senha = $conexaoBD->real_escape_string($senha);
        $query = "update usuario set senha='{$senha}' where id={$id}";
        return $conexaoBD->query($query);
    }

    # Funcao para remover uma solicitacao da lista de recuperacao
    public function removerRecuperacao($conexaoBD, $id){
        $id = $conexaoBD->real_escape_string($id);
        $query = "delete from recuperacao where idRec={$id}";
        $conexaoBD->query($query);
    }
}