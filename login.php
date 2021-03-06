<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Done: Coding Dojo</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/login.css" rel="stylesheet">


    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
      }
    </style>

 

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Done: Coding Dojo</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="about.html">Sobre o Coding Dojo</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-center">
                <img src="dojo.png" width="300">
                <div class="login-page">
                <div class="form">
                <form class="register-form" method="POST" action="create-user.php" id="new-user">
                <input type="text" placeholder="email" name="email" id="email"/>
                <input type="text" placeholder="nome" name="username" id="username"/>
                <input type="password" placeholder="senha" name="senha" id="senha"/>
                 <input type="submit" name="submit" id="submit" value="Criar"/>
                 <p class="message">Já é Registrado? <a href="#">Login</a></p>
                </form>
                <form method="POST" action="login-processa.php" class="login-form" id="user">
                 <input type="text" placeholder="email" name="email" id="email"/>
                 <input type="password" placeholder="senha" name="senha" id="senha"/>
                 <input type="submit" name="submit" id="submit" value="Login"/>
                 <p class="message">Não é Registrado? <a href="#">Criar Conta</a></p>
                </form>
                </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/login.js"></script>

</body>

</html>
