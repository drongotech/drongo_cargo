<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Drongo Cargo - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Drongo Cargo Company - Tracking System " name="description" />
    <meta content="Drongo Technology" name="Drongo Technolgoy" />
    <!-- App favicon -->
    <link rel="shortcut icon" src="/assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="home-btn d-none d-sm-block">
        <a href="index.html" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-login text-center">
                            <div class="bg-login-overlay"></div>
                            <div class="position-relative">
                                <h5 class="text-white font-size-20">Welcome Back !</h5>
                                <p class="text-white-50 mb-0">Sign in to Drongo Cargo Tracking System</p>
                                <a href="index.html" class="logo logo-admin mt-4">
                                    <img src="/assets/images/drongoLogo.png" alt="" height="30">
                                </a>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="p-2">
                                <form class="form-horizontal" action="" method="POST">
                                    @csrf

                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        {{$errors->first()}}
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="username">Company Email</label>
                                        <input type="text" class="form-control" name="company_email" placeholder="Enter company email">
                                    </div>
                                    @error('company_email')
                                        {{$message}}
                                    @enderror

                                    <div class="form-group">
                                        <label for="userpassword">Pincode</label>
                                        <input type="password" class="form-control" name="company_pincode" placeholder="Enter pincode">
                                    </div>
                                    @error('company_pincode')
                                        {{$message}}
                                    @enderror


                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                                    </div>

                                    <div class="mt-4 text-center">
                                        <a href="/cargo/forgotpincode" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Forgot your pincode?</a>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <p>Don't have an account ? <a href="/cargo/register" class="font-weight-medium text-primary"> Register an account here </a> </p>
                        <p>© {{gmdate('Y', time())}} Crafted with <i class="mdi mdi-heart text-danger"></i> Drongo Technology</p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="/assets/libs/jquery/jquery.min.js"></script>
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>

    <script src="/assets/js/app.js"></script>

</body>

</html>