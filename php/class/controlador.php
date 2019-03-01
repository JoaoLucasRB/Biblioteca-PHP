<?php

# Importacoes necessarias
require_once("logica-usuario.php"); # Funcoes de gerenciamento do usuario (restricao de acesso a pagina)
require_once("livros.php"); # Classe de funcoes para o objeto LIVRO
require_once("../php/class/categorias.php"); # Classe de funcoes para o objeto CATEGORIA
require_once("../php/class/usuarios.php"); # Classe de funcoes para o objeto USUARIO
require_once("privilegios.php"); # Classe de funcoes para o objeto PRIVILEGIO
require_once("paginacao.php"); # Classe de funcoes para paginacao

class Controlador {

    # Funcao para cadastrar um eBook no sistema
    public function cadastrarLivro($nome, $descricao, $categoriaId, $imagem, $nomeImagem, $arquivo, $nomeArquivo){
        $livros = new Livros();
        $livros->cadastrarLivro($nome, $descricao, $categoriaId, $imagem, $nomeImagem, $arquivo, $nomeArquivo);
    }

    #Funcao para remover um eBook do sistema
    public function removerLivro($id, $nomeImagem, $nomeArquivo){
        $livros = new Livros();
        $livros->removerLivro($id, $nomeImagem, $nomeArquivo);
    }

    # Funcao para alterar um eBook do sistema
    public function alterarLivro($id, $nome, $descricao, $categoriaId, $imagem, $nomeImagem, $nomeImagemAntigo, $arquivo, $nomeArquivo, $nomeArquivoAntigo, $case){
        $livros = new Livros();
        $livros->alterarLivro($id, $nome, $descricao, $categoriaId, $imagem, $nomeImagem, $nomeImagemAntigo, $arquivo, $nomeArquivo, $nomeArquivoAntigo, $case);
    }

    # Funcao que retorna a lista de eBooks cadastrados no sistema
    public function getLivros($pagina, $quantidade){
        $livros = new Livros();
        return $livros->getLivros($pagina, $quantidade);
    }

    # Funcao que retorna a lista de eBooks cadastrados no sistema de acordo com o filtro de pesquisa
    public function getLivrosPesquisa($pagina, $quantidade, $ordem, $nomeRes, $categoria){
        $livros = new Livros();
        return $livros->getLivrosPesquisa($pagina, $quantidade, $ordem, $nomeRes, $categoria);
    }
    # Funcao para adicionar uma categoria no sistema
    public function adicionarCategoria($nome){
        $categorias = new Categorias();
        $categorias->adicionarCategoria($nome);
    }

    # Funcao para remover uma categoria do sistema
    public function removerCategoria($id){
        $categorias = new Categorias();
        $categorias->removerCategoria($id);
    }

    # Funcao para alterar uma categoria do sistema
    public function alterarCategoria($id, $nome){
        $categorias = new Categorias();
        $categorias->alterarCategoria($id, $nome);
    }

    # Funcao que retorna a lista de categorias de eBooks no sistema
    public function getCategorias(){
        $categorias = new Categorias();
        return $categorias->getCategorias();
    }

    # Funcao para adicioar um usuario no sistema
    public function adicionarUsuario($nomeUsuario, $email, $senha, $privilegio){
        $usuarios = new Usuarios();
        $usuarios->adicionarUsuario($nomeUsuario, $email, $senha, $privilegio);
    }

    # Funcao para remover um usuario do sistema
    public function removerUsuario($id){
        $usuarios = new Usuarios();
        $usuarios->removerUsuario($id);
    }

    # Funcao para alterar os dados de um usuario do sistema
    public function alterarUsuario($id, $nomeUsuario, $email, $privilegio, $alt){
        $usuarios = new Usuarios();
        $usuarios->alterarUsuario($id, $nomeUsuario, $email, $privilegio, $alt);
    }
    
    # Funcao que retorna a lista de usuarios do sistema
    public function getUsuarios($pagina){
        $usuarios = new Usuarios();
        return $usuarios->getUsuarios($pagina);
    }

    # Funcao que retorna os dados de um usuario do sistema
    public function buscarUsuario($login, $senha){
        $usuarios = new Usuarios();
        return $usuarios->buscarUsuario($login, $senha);
    }

    # Funcao para adicionar um usuario na lista de cadastro
    public function iniciarCadastro($nomeUsuario, $email, $senha, $privilegio){
        $usuarios = new Usuarios();
        $usuarios->iniciarCadastro($nomeUsuario, $email, $senha, $privilegio);
    }

    # Funcao que retorna os dados de um cadastro
    public function getCadastro($chaveReg){
        $usuarios = new Usuarios();
        return $usuarios->getCadastro($chaveReg);
    }

    # Funcao para finalizar um cadastro
    public function finalizarCadastro(Usuario $usuario, $chaveReg){
        $usuarios = new Usuarios();
        $usuarios->finalizarCadastro($usuario, $chaveReg);
    }

    # Funcao que inicia o processo de recuperacao de senha
    public function iniciarRecuperacao($email){
        $usuarios = new Usuarios();
        $usuarios->iniciarRecuperacao($email);
    }

    # Funcao que retorna os dados de uma recuperacao
    public function getRecuperacao($chaveRec){
        $usuarios = new Usuarios();
        return $usuarios->getRecuperacao($chaveRec);
    }

    # Funcao que altera a senha de um usuario do sistema
    public function alterarSenha($id, $senha){
        $usuarios = new Usuarios();
        $usuarios->alterarSenha($id, $senha);
    }
    
    # Funcao que retorna a lista de privilegios do sistema
    public function getPrivilegios(){
        $privilegios = new Privilegios();
        return $privilegios->getPrivilegios();
    }
    
    # Funcao que retorna o numero da pagina anterior
    public function anteriorPagina($pagina){
        $paginacao = new Paginacao();
        return $paginacao->anteriorPagina($pagina);
    }

    # Funcao que retorna o numero da proxima pagina
    public function proximaPagina($pagina){
        $paginacao = new Paginacao();
        return $paginacao->proximaPagina($pagina);
    }

    # Funcao que retorna a quantidade de paginas
    public function getPaginas(){
        $paginacao = new Paginacao();
        return $paginacao->getPaginas();
    }

    # Funcao para logar um usuario no sistema
    public function logarUsuario($email, $nomeUsuario, $privilegioId){
        $logicaUsuario = new LogicaUsuario();
        $logicaUsuario->logarUsuario($email, $nomeUsuario, $privilegioId);
    }

    # Funcao para deslogar um usuario no sistema
    public function logout(){
        $logicaUsuario = new LogicaUsuario();
        $logicaUsuario->logout();
    }
    # Funcao que retorna o nivel de privilegio do usuario
    public function privilegio(){
        $logicaUsuario = new LogicaUsuario();
        return $logicaUsuario->privilegio();
    }

    # Funcao que retorna o nome do usuario logado
    public function usuarioLogado(){
        $logicaUsuario = new LogicaUsuario();
        return $logicaUsuario->usuarioLogado();
    }

    # Funcao que retorna o email do usuario logado
    public function emailLogado(){
        $logicaUsuario = new LogicaUsuario();
        return $logicaUsuario->emailLogado();
    }

    # Funcao para fazer a verificacao de acesso a paginas
    public function verificarAcesso(){
        $logicaUsuario = new LogicaUsuario();
        $logicaUsuario->verificarUsuario();
        $logicaUsuario->verificarPrivilegioUsuario();
    }

    # Funcao para fazer a verificacao de acesso da pagina home
    public function verificarAcessoHome(){
        $logicaUsuario = new LogicaUsuario();
        $logicaUsuario->verificarUsuario();
    }
}