<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="img/logoA.png" type="image/x-icon">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="Library/fontawesome-free/css/all.min.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <link rel="stylesheet" href="css/spinner.css">

</head>

<body class="bg-gradient-info">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">CASAPA</h1>
                                        <h1 class="h4 text-gray-900 mb-4">¡BIENVENIDOS!</h1>
                                    </div>
                                    <div class="text-center">
                                        <span id="Alert_Login" class="text-danger"></span>
                                    </div>
                                    <form class="user" id="formLogin" name="formLogin">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" id="User" name="User" placeholder="Usuario" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="Password" name="Password" placeholder="Contraseña" required>
                                        </div>

                                        <button type="submit" class=" btn btn-primary btn-user btn-block">
                                            Login <i class="fas fa-sign-in-alt"></i>
                                        </button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script src="Library/jquery/jquery-3.6.3.min.js"></script>
    <script src="Library/Popper/popper.min.js"></script>
    <script src="Library/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="Library/jquery-easing/jquery.easing.min.js"></script>
    <script src="Library/js/sb-admin-2.js"></script>
    <script src="Library/bootstrap/js/bootstrap-select.min.js"></script>
    <script src="Library/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="Library/datatables/js/datatables.min.js"></script>
    <script src="Library/jquery/jquery.blockUI.min.js"></script>
    <script src="Library/js/globalFuntion.js"></script>
    <script src="js/index.js"></script>
</body>

</html>