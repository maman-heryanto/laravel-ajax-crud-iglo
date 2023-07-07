<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <style>
        .text-danger {
            color: red;
        }

        .form-error {
            border: 2px solid red;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('login') }}"><b>Admin</b>Training</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                {{-- <form action="index3.html" method="post"> --}}
                <form type="POST" enctype="multipart/form-data" id="formLogin">
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Email" name="email"
                                id="email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <span class="text-danger form-validate" id="emailError"></span>
                    </div>
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control" placeholder="Password" name="password"
                                id="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <span class="text-danger form-validate" id="passwordError"></span>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <div id="buttonLogin">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                            <div id="buttonLoginLoading" style="display: none;">
                                <button type="submit" class="btn btn-primary btn-block" disabled><i
                                        class="fa fa-spinner fa-spin">Process</i></button>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                {{-- <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div> --}}
                <!-- /.social-auth-links -->

                {{-- <p class="mb-1">
                    <a href="forgot-password.html">I forgot my password</a>
                </p> --}}
                <p class="mb-0">
                    <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#formLogin').on('submit', function(e) {
                e.preventDefault();
                document.getElementById("buttonLogin").style
                    .display = "block";
                document.getElementById("buttonLoginLoading").style
                    .display = "none";
                var email = $("#email").val();
                var password = $("#password").val();
                var token = $("meta[name='csrf-token']").attr("content");
                let validation = 0;

                //validation
                if (email.length == 0 || email == "") {
                    $('#emailError').text("email is required");
                    $('#email').addClass('form-error');
                    validation++
                } else {
                    if (!email.toString().toLowerCase().match(
                            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                        )) {
                        $('#emailError').text("Plase check the email format");
                        $('#email').addClass('form-error');
                        validation++;
                    } else {
                        $('#emailError').text("");
                        $('#email').removeClass('form-error');
                    }
                }
                //password validation
                if (password.length == 0 || password == "") {
                    $('#passwordError').text("Password is required");
                    $('#password').addClass('form-error');
                } else {
                    $('#passwordError').text("");
                    $('#password').removeClass('form-error');
                }
                //validation lebih dari 0
                if (validation > 0) {
                    document.getElementById("buttonLogin").style
                        .display = "block";
                    document.getElementById("buttonLoginLoading").style
                        .display = "none";
                    return false;
                }

                $.ajax({
                    url: "{{ route('login.action') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        "email": email,
                        "password": password,
                        "_token": token
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            Swal.fire({
                                    icon: 'success',
                                    title: 'Login Success...',
                                    text: 'You will redirected into system 3 second',
                                    timer: 3000,
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                })
                                .then(function() {
                                    // window.location.href = "{{ route('product') }}";
                                    window.location.href = response.data.url_redirect;
                                });
                        } else {
                            Swal.fire({
                                    icon: 'error',
                                    title: 'Login Failed...',
                                    text: response.message,
                                })
                                .then(function() {
                                    document.getElementById("buttonLogin").style
                                        .display = "block";
                                    document.getElementById("buttonLoginLoading").style
                                        .display = "none";
                                });
                        }
                    },
                    error: function(response) {
                        Swal.fire({
                            type: 'error',
                            title: 'Opps!',
                            text: response.message
                        }).then(function() {
                            document.getElementById("buttonRegisterUser").style
                                .display = "block";
                            document.getElementById("buttonRegisterUserLoading").style
                                .display = "none";
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>
