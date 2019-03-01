<?php

class BancoPaginacao {

    # Funcao que retorna a quantidade de paginas
    public function getPaginas($conexaoBD){
        $query = "select id from produto";
        $resultado = $conexaoBD->query($query);
        $qtdP = 0;
        while($produto = $resultado->fetch_assoc()){
            $qtdP = $qtdP + 1;
        }
        $qtdP = $qtdP / 15;
        return ceil($qtdP);
    }

}