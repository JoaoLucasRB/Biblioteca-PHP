<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Biblioteca Cenep</title>
    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/shop-homepage.css" rel="stylesheet">
  </head>
  <body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="home.php">BIBLIOTECA CENEP  </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Div links -->
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <?php
        # Se o id do privilegio for diferente de 3 (ID de privilegio de usuario)
        if($controlador->privilegio() != 3){ ?>
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="home">Home ///
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="ebooks"> eBooks /// </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="categorias">Categorias /// </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="usuarios">Usuarios</a>
            </li>
          </ul>
        <?php } ?> 
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <!-- Div dropdown -->
            <div class="dropdown">
              <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?=$controlador->usuarioLogado()?>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <small class="dropdown-item text text-muted"><?=$controlador->emailLogado()?></small>
                <a class="dropdown-item" href="logout.php">Sair</a>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>