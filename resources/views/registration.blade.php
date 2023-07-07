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

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href=""><b>Admin</b>Training</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>
                <form type="POST" enctype="multipart/form-data" id="registerUser">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Email" name="email" id="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <span class="text-danger form-validate" id="emailError"></span>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password"
                            id="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <span class="text-danger form-validate" id="passwordError"></span>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Retype password" name="repassword"
                            id="repassword">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <span class="text-danger form-validate" id="rePasswordError"></span>
                    <div class="row">
                        <div class="col-8">
                            &nbsp;
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

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
            $('#registerUser').on('submit', function(e) {
                e.preventDefault();
                var email = $("#email").val();
                var password = $("#password").val();
                var repassword = $("#repassword").val();
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
                //repassword validation
                if (password !== repassword) {
                    $('#rePasswordError').text("Retype Password must be the same as the Password");
                    $('#repassword').addClass('form-error');
                } else {
                    $('#rePasswordError').text("");
                    $('#repassword').removeClass('form-error');
                }

                //validation errors
                if (validation > 0) {
                    return false;
                }
                $.ajax({
                    url: "{{ route('register.action') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    dataType: "JSON",
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Register Success...',
                                text: 'User has been registered successfully',
                            }).then(function() {
                                window.location.href = "{{ route('login') }}";
                            });
                        } else if (response.status == 202) {
                            $('#emailError').text(response.message);
                            $('#email').addClass('form-error');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Register Failed...',
                                text: response.message
                            })
                            // .then(function() {
                            //     window.location.href = "{{ route('login')";
                            // });
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
