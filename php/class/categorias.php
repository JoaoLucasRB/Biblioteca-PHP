<?php

# Importacoes necessarias
require_once("conector.php"); # Conexao ao BD
require_once("banco-categoria.php"); # Funcoes do banco de dados
require_once("categoria.php"); # Classe do Objeto

class Categorias {

    # Funcao para adicionar uma nova categoria no banco de dados
    public function adicionarCategoria($nome){
        $conector = new Conector();
        $banco = new BancoCategoria();
        try{
            if($banco->adicionarCategoria($conector->getConexao(), new Categoria(0, $nome))){
                $_SESSION['success'] = "Categoria criada com sucesso";
            } else {
                $_SESSION['danger'] = "Falha ao criar categoria, tente novamente.";
            }
        } catch (Exception $e) {
            $_SESSION['danger'] = "Falha ao criar categoria, tente novamente.";
        }
        header("Location: ../php/categorias.php");
    }

    # Funcao para remover uma categoria do banco de dados
    public function removerCategoria($id){
        $conector = new Conector();
        $banco = new BancoCategoria();
        try{
            if($banco->removerCategoria($conector->getConexao(), $id)){
                $_SESSION['success'] = "Categoria criada com sucesso";
            } else {
                $_SESSION['danger'] = "Falha ao criar categoria, tente novamente.";
            }
        } catch (Exception $e) {
            $_SESSION['danger'] = "Falha ao criar categoria, tente novamente.";
        }
        header("Location: ../php/categorias.php");
    }

    # Funcao para alterar uma categoria do banco de dados
    public function alterarCategoria($id, $nome){
        $conector = new Conector();
        $banco = new BancoCategoria();
        try{
            if($banco->alterarCategoria($conector->getConexao(), new Categoria($id, $nome))){
                $_SESSION['success'] = "Categoria criada com sucesso";
            } else {
                $_SESSION['danger'] = "Falha ao criar categoria, tente novamente.";
            }
        } catch (Exception $e) {
            $_SESSION['danger'] = "Falha ao criar categoria, tente novamente.";
        }
        header("Location: ../php/categorias.php");
    }
    # Funcao que retorna lista com todas as categorias no banco de dados
    function getCategorias(){
        $conector = new Conector();
        $banco = new BancoCategoria();
        return $banco->getCategorias($conector->getConexao());
    }
    
}