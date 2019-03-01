<?php
require_once("class/controlador.php");
$controlador = new Controlador();
$controlador->verificarAcesso();
# Include de arquivo com codigo do cabecalho/<head>
require_once("cabecalho.php");
?>

<?php
if(isset($_SESSION['success'])){ ?>
    <p class='alert alert-success'><?=$_SESSION['success']?></p>
    <?php unset($_SESSION['success']);
} else if (isset($_SESSION["warning"])){ ?>
    <p class='alert alert-warning'><?=$_SESSION['warning']?></p>
    <?php unset($_SESSION["warning"]);
} else if (isset($_SESSION["danger"])){ ?>
    <p class='alert alert-danger'><?=$_SESSION["danger"]?></p>
    <?php unset($_SESSION["danger"]);
} ?>


<!-- Div Conteudo -->
<div class="row">

    <!-- Coluna esqueda -->
    <div class="col-6">

        <!-- Div tabela grid -->
        <div class="row">
            <div class="col">
                <div class="row table-bordered">
                    <div class="col-1 table-bordered">
                        <p>Id</p>
                    </div>
                    <div class="col-5 table-bordered">
                        <p>Nome</p>
                    </div>
                    <div class="col-4 table-bordered">
                        <p>Data de criacao</p>
                    </div>
                </div>
                <?php
                if(isset($_GET['pagina'])){
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina = 1;
                }
                $ebooks = $controlador->getLivros($pagina, 15);
                foreach($ebooks as $ebook){ ?>
                    <div class="row">
                        <div class="col-1 table-bordered">
                            <p><?=$ebook->getId()?></p>
                        </div>
                        <div class="col-5 table-bordered">
                            <p><?=$ebook->getNome()?></p>
                        </div>
                        <div class="col-4 table-bordered">
                            <p><?php $date = new DateTime($ebook->getData()); echo $date->format('d/m/Y | H:i:s'); ?></p>
                        </div>
                        <div class="col-2 table-bordered">
                            <form enctype="multipart/form-data" action="ebooks.php" method="post">
                                <input type="hidden" name="idEbook" value="<?=$ebook->getId()?>" />
                                <input type="hidden" name="nomeEbook" value="<?=$ebook->getNome()?>" />
                                <input type="hidden" name="descEbook" value="<?=$ebook->getDescricao()?>" />
                                <input type="hidden" name="imgEbook" value="<?=$ebook->getImagem()?>" />
                                <input type="hidden" name="arqEbook" value="<?=$ebook->getArquivo()?>" />
                                <input type="hidden" name="editar" />
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>
                
            </div>
        </div>
        <!-- /tabela grid -->

        <!-- Div botao novo ebook | Paginacao -->
        <div class="row">

            <!-- Div botao -->
            <div class="col-6">
                <div align="center">
                    
                    <?php if($pagina != 1){ ?>
                        <a href="ebooks.php?pagina=<?=$pagina?>" class="btn btn-success" role="button">Novo eBook</a>
                    <?php } else { ?>
                        <a href="ebooks.php" class="btn btn-success" role="button">Novo eBook</a>
                    <?php } ?>
                </div>
            </div>
            <!-- /Div botao -->

            <!-- Div Paginacao -->
            <div class="col-6">
                <div align="center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            # Verifica se a variavel categoria foi passada como parametro
                            if(isset($_GET['categoria'])){
                                if($pagina > 1){ ?>
                                <li class="page-item"><a class="page-link" href="ebooks.php?pagina=<?=$controlador->anteriorPagina($pagina)?>&categoria=<?=$_GET['categoria']?>">Previous</a></li>
                                <?php } ?>
                            <li class="page-item"><a class="page-link"><?=$pagina?></a></li>
                            <?php if($pagina < $controlador->getPaginas()){ ?>
                                <li class="page-item"><a class="page-link" href="ebooks.php?pagina=<?=proximaPagina($pagina)?>&categoria=<?=$_GET['categoria']?>">Next</a></li>
                            <?php } ?>
                                
                            <?php } else { 
                                if($pagina > 1){ ?>
                                <li class="page-item"><a class="page-link" href="ebooks.php?pagina=<?=$controlador->anteriorPagina($pagina)?>">Anterior</a></li>
                                <?php } ?>
                                <li class="page-item"><a class="page-link" href="#"><?=$pagina?></a></li>
                                <?php if($pagina < $controlador->getPaginas()){ ?>
                                <li class="page-item"><a class="page-link" href="ebooks.php?pagina=<?=$controlador->proximaPagina($pagina)?>">Proxima</a></li>
                                <?php } 
                            } ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /Div Paginacao -->
                               
        </div>
        <!-- /Div Botao/Paginacao -->

    </div>
    <!-- /Coluna Esquerda -->
    
    <?php
    # Carregar form editar
    if(isset($_POST['editar'])){ ?>

    <!-- Coluna Direita -->
    <div class="col-6">
        <div class="row">
            <div class="col">
                <div align="center">
                    <h4>Editar eBook</h4>
                </div>
            </div>
        </div>

            <!-- Form Detalhes/Alterar/Deletar ebook -->
            <?php
            $idEbook = $_POST['idEbook'];
            $nomeEbook = $_POST['nomeEbook'];
            $descEbook = $_POST['descEbook'];
            $catEbook = $_POST['catEbook'];
            $imgEbook = $_POST['imgEbook'];
            $arqEbook = $_POST['arqEbook'];
            ?>
            <form enctype="multipart/form-data" action="livro-alt.php" method="post">

                <!-- Div do Nome do eBook -->
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="insNome">Nome</label>
                            <input type="text" class="form-control" id="insNome" name="nome" value="<?=$nomeEbook?>"/>
                        </div>
                    </div>
                </div>
                <!-- /Div do Nome do eBook -->

                <!-- Div da Descricao do eBook -->
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="insDesc">Descricao</label>
                            <textarea name="descricao" id="descricao" maxlength="220" class="form-control"><?=$descEbook?></textarea>
                        </div>
                    </div>
                </div>
                <!-- /Div da Descricao do eBook -->

                <!-- Div da categoria -->
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="selCategoria">Categoria</label>
                            <select class="form-control" id="selCategoria" name="categoria">
                                <?php
                                $categorias = $controlador->getCategorias();
                                foreach($categorias as $categoria){
                                    if($categoria->getNome() == $catEbook) {?>
                                        <option value="<?=$categoria->getId()?>" selected><?=$categoria->getNome()?></option>
                                    <?php } else { ?>
                                        <option value="<?=$categoria->getId()?>"><?=$categoria->getNome()?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /Div da categoria -->
                
                <!-- Div arquivo/imagem atual -->
                <div class="form-row">

                    <!-- Arquivo atual -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="arqAtual">Arquivo atual</label>
                            <input type="text" id="arqAtual" name="arqAtual"; class="form-control-plaintext" value="<?=$arqEbook?>"/>
                        </div>
                    </div>
                    <!-- /Arquivo atual -->

                    <!-- Imagem atual -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="imgAtual">Imagem atual</label>
                            <input type="text" id="imgAtual" name="imgAtual" class="form-control-plaintext" value="<?=$imgEbook?>" />
                        </div>
                    </div>
                    <!-- /Imagem atual -->

                </div>
                <!-- /Div arquivo/imagem atual -->

                <!-- Div inserir arquivo/ inserir imagem -->
                <div class="form-row">

                    <!-- Inserir arquivo -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="insArquivo">Novo arquivo</label>
                            <input id="insArquivo" name="arquivo" type="file" class="form-control-file"/>
                            <small class="form-text text-muted">Formatos aceitos: PDF</small>
                        </div>
                    </div>
                    <!-- /Inserir arquivo -->

                    <!-- Inserir imagem -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="insImagem">Nova imagem</label>
                            <input id="insImagem" name="imagem" type="file" class="form-control-file"/>
                            <small class="form-text text-muted">Formatos aceitos: JPEG, PNG</small>
                        </div>
                    </div>
                    <!-- /Inserir imagem -->

                </div>
                <!-- /Div inserir arquivo/ inserir imagem -->

                <!-- Input hidden id do ebook -->
                <input type="hidden" name="idEbook" value="<?=$idEbook?>" />

                <!-- Div alterar/deletar -->
                <div class="form-row">
                    <div class="col-6">
                        <div align="right">
                            <button type="submit" class="btn btn-warning">Alterar</button>
                        </div>
                    </div>
            </form>
            <!-- /Form Detalhes/Alterar ebook -->
                    <div class="col-6">
                        <div align="left">
                        
                            <!-- Form deletar ebook -->
                            <form enctype="multipart/form-data" action="livro-del.php" method="post">
                                <input type="hidden" name="idEbook" value="<?=$idEbook?>" />
                                <input type="hidden" name="imgEbook" value="<?=$imgEbook?>" />
                                <input type="hidden" name="arqEbook" value="<?=$arqEbook?>" />
                                <button type="submit" class="btn btn-danger">Remover</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Div alterar/deletar -->

            

        </div>
        <!-- Coluna Direita -->

    <!-- Carregar form novo -->
    <?php } else { ?>
        

        <div class="col-6">
            <div class="row">
                <div class="col">
                    <div align="center">
                        <h4>Cadastrar eBook</h4>
                    </div>
                </div>
            </div>
            <!-- Form upload -->
            <form enctype="multipart/form-data" action="livro-cad.php" method="POST">

                <!-- Div insercao do Nome do eBook -->
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="insNome">Nome</label>
                            <input type="text" class="form-control" id="insNome" name="nome" placeholder="Nome do eBook"/>
                        </div>
                    </div>
                </div>

                <!-- Div insercao da Descricao do eBook -->
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="insDesc">Descricao</label>
                            <textarea name="descricao" id="descricao" maxlength="220" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Div Selecao da categoria -->
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <label for="selCategoria">Categoria</label>
                            <select class="form-control" id="selCategoria" name="categoria">
                                <?php
                                $categorias = $controlador->getCategorias();
                                foreach($categorias as $categoria){ ?>
                                    <option value="<?=$categoria->getId()?>"><?=$categoria->getNome()?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>


                <!-- Div inserir arquivo/ inserir imagem -->
                <div class="form-row">
                    <!-- Inserir arquivo -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="insArquivo">Escolha um arquivo</label>
                            <input id="insArquivo" name="arquivo" type="file" class="form-control-file"/>
                            <small class="form-text text-muted">Formatos aceitos: PDF</small>
                        </div>
                    </div>
                    <!-- Inserir imagem -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="insImagem">Escolha uma imagem</label>
                            <input id="insImagem" name="imagem" type="file" class="form-control-file"/>
                            <small class="form-text text-muted">Formatos aceitos: JPEG, PNG</small>
                        </div>
                    </div>
                </div>

                <!-- botao Cadastrar eBook -->
                <div class="form-row">
                    <div class="col">
                        <div align="center">
                            <button type="submit" class="btn btn-success">Cadastrar</button>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
    <?php } ?>
    
</div>
<!-- Div Conteudo -->

<!-- Include contendo os codigos html do rodape -->
<?php include("rodape.php"); ?>