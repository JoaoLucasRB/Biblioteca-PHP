<?php
session_start();
if(isset($_SESSION['success'])){ ?>
    <p class='alert alert-success'><?=$_SESSION['success']?></p>
    <?php session_destroy();
} else if (isset($_SESSION["warning"])){ ?>
    <p class='alert alert-warning'><?=$_SESSION['warning']?></p>
    <?php session_destroy();
} else if (isset($_SESSION["danger"])){ ?>
    <p class='alert alert-danger'><?=$_SESSION["danger"]?></p>
    <?php session_destroy();
}
?>
<html lang="pt-br">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Biblioteca Cenep</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/shop-homepage.css" rel="stylesheet">

</head>

<body>







  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">ACESSO DO ALUNO</h5>
			<div class="custom-control custom-checkbox mb-3"></div>
             <form enctype="multipart/form-data" action="php/login.php" method="post" class="form-signin">
              <div class="form-label-group">
                <input type="text" id="insEmail" class="form-control" name="login" placeholder="Email ou nome de usuário" required autofocus>
                <label for="instEmail"></label>
	
              </div>

              <div class="form-label-group">
                <input type="password" id="insSenha" name="senha" class="form-control" placeholder="Senha" required>
                <label for="insSenha"></label>

				
				
              </div>

              <div class="custom-control custom-checkbox mb-3">

              </div>
              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Entrar</button>
			  <div class="custom-control">
							<div class="ml-auto">
                                <a href="php/recuperacao.php">Esqueceu sua senha?</a>
                            </div>
              </div>
			  
			  			
			  
              <hr class="my-4">
			  
              <button class="btn btn-lg btn-google btn-block text-uppercase" type="submit"><i class="fab fa-google mr-2"></i><a href="php/cadastro.php">Cadastre-se!</a></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>










    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>