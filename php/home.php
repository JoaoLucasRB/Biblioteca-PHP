<?php
require_once("class/controlador.php");
$controlador = new Controlador();
$controlador->verificarAcessoHome();
# Include de arquivo com codigo do cabecalho/<head>
require_once("cabecalho.php");
if(isset($_SESSION['success'])){ ?>
    <p class='alert alert-success'><?=$_SESSION['success']?></p>
    <?php session_destroy(); ?>
<?php } else if (isset($_SESSION["warning"])){ ?>
    <p class='alert alert-warning'><?=$_SESSION['warning']?></p>
    <?php unset($_SESSION["warning"]);
} else if (isset($_SESSION["danger"])){ ?>
    <p class='alert alert-danger'><?=$_SESSION["danger"]?></p>
    <?php unset($_SESSION["danger"]);
}

# Verifica se a variavel pagina foi passada como parametro
if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];
} else {
    $pagina = 1;
}
#Verifica se variavel quantidade foi passada como parametro
if(isset($_POST['qtdRes'])){
    $quantidade = $_POST['qtdRes'];
} else {
    $quantidade = 15;
}
# Verifica se a variavel ordem foi passada como parametro
if(isset($_POST['orderRes'])){
    $ordem = $_POST['orderRes'];
} else {
    $ordem = 1;
}
# Verifica se a variavel nome foi passada como parametro
if(isset($_POST['nomeRes'])){
    $nomeRes = $_POST['nomeRes'];
} else {
    $nomeRes = "";
}
# Verifica se a variavel categoria foi passada como parametro
if(isset($_GET['categoria'])){
    $categoria = $_GET['categoria'];
    $link = "home.php?categoria={$categoria}";
    $produtos = $controlador->getLivrosPesquisa($pagina, $quantidade, $ordem, $nomeRes, $categoria);
} else {
    $link = "home.php";
    $produtos = $controlador->getLivrosPesquisa($pagina, $quantidade, $ordem, $nomeRes, 0);
}
?>

<!-- Page Content -->
<div class="container">
    <div class="row">
    <div class="col-lg-3">

        <!-- Div Categorias -->
        <h1 class="my-4">Categorias</h1>
        <div class="list-group">
        <?php
        $categorias = $controlador->getCategorias();
        foreach($categorias as $categoria){ ?>
            <a href="home.php?categoria=<?=$categoria->getId()?>" class="list-group-item list-group-item-action"><?=$categoria->getNome()?></a>
        <?php } ?>
        </div>

    </div>
    <!-- /.col-lg-3 -->


    <div class="col-lg-9">
        <form enctype="multidata/form-data" action="<?=$link?>" method="post">
            <div class="form-row">
                <div class="col-3">
                    <label for="orderRes">Ordem:</label>
                    <select id="orderRes" name="orderRes" class="form-control">
                        <?php if($ordem == 1){ ?>
                            <option value="1" selected>Data de Upload</option>
                        <?php } else { ?>
                            <option value="1">Data de Upload</option>
                        <?php }
                        if ($ordem == 2){ ?>
                            <option value="2" selected>Alfabetica</option>
                        <?php } else { ?>
                            <option value="2">Alfabetica</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-3">
                    <label for="qtdRes">Quantidade:</label>
                    <select id="qtdRes" name="qtdRes" class="form-control">
                        <?php if($quantidade == 15) { ?>
                            <option value="15" selected>15</option>
                        <?php } else { ?>
                            <option value="15">15</option>
                        <?php } 
                        if($quantidade == 30) { ?>
                            <option value="30" selected>30</option>
                        <?php } else { ?>
                            <option value="30">30</option>
                        <?php }
                        if($quantidade == 45) { ?>
                            <option value="45" selected>45</option>
                        <?php } else { ?>
                            <option value="45">45</option>
                        <?php }
                        if($quantidade == 60) { ?>
                            <option value="60" selected>60</option>
                        <?php } else { ?>
                            <option value="60">60</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-4">
                    <label for="nomeRes">Nome:</label>
                    <?php if($nomeRes != "") { ?>
                        <input type="text" id="nomeRes" name="nomeRes" class="form-control" value="<?=$nomeRes?>">
                    <?php } else { ?>
                        <input type="text" id="nomeRes" name="nomeRes" class="form-control">
                    <?php } ?>
                    
                </div>
                <div class="col-2">
                    <div align="center">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
        <!-- Listagem dos eBooks -->
        <?php
        # Itera a lista de produtos listando cada elemento
        foreach($produtos as $produto){ ?> 
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-70">
                    <a href="../imgUp/<?=$produto->getImagem()?>"><img class="card-img-top" src="../imgUp/<?=$produto->getImagem()?>" width="200" height="200"></a>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="../arqUp/<?=$produto->getArquivo()?>" download><?=$produto->getNome()?></a>
                        </h4>
                        <small class="text text-muted">Adicionado em: <?php $date = new DateTime($produto->getData()); echo $date->format('d/m/Y'); ?></small>
                        <p class="card-text"><?=$produto->getDescricao()?></p>
                    </div>
                    <div class="card-footer">
					<button class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i class="fab fa-google mr-2"></i><a href="../arqUp/<?=$produto->getArquivo()?>">Download</a></button>
                        <!--<a href="../arqUp/<?=$produto->getArquivo()?>" class="btn-primary" download>Download</small> -->
                    </div>
                </div>
            </div>
        <?php } ?>
        </div>
    
    <!-- Div paginacao -->
    <div align="center">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
                # Verifica se a variavel categoria foi passada como parametro
                if(isset($_GET['categoria'])){
                    if($pagina > 1){ ?>
                    <li class="page-item"><a class="page-link" href="home.php?pagina=<?=$controlador->anteriorPagina($pagina)?>&categoria=<?=$_GET['categoria']?>">Anterior</a></li>
                    <?php } ?>
                <li class="page-item"><a class="page-link"><?=$pagina?></a></li>
                <?php if($pagina < $controlador->getPaginas()){ ?>
                    <li class="page-item"><a class="page-link" href="home.php?pagina=<?=$controlador->proximaPagina($pagina)?>&categoria=<?=$_GET['categoria']?>">Próximo</a></li>
                <?php } ?>
                    
                <?php } else { 
                    if($pagina > 1){ ?>
                    <li class="page-item"><a class="page-link" href="home.php?pagina=<?=$controlador->anteriorPagina($pagina)?>">Anterior</a></li>
                    <?php } ?>
                    <li class="page-item"><a class="page-link" href="#"><?=$pagina?></a></li>
                    <?php if($pagina < $controlador->getPaginas()){ ?>
                    <li class="page-item"><a class="page-link" href="home.php?pagina=<?=$controlador->proximaPagina($pagina)?>">Proxima</a></li>
                    <?php } 
                } ?>
            </ul>
        </nav>
    </div>
        <!-- /.row -->

    </div>
    <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
<?php include("rodape.php"); ?>