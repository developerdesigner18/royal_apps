<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="{{asset('js/jquery-3.6.0.js')}}"></script>
    <script src="{{asset('js/jquery.validate.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4 card-bg-fill">

            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Welcome Back !</h5>
                </div>
                <div class="p-2 mt-4">
                    <form id="loginForm">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Email</label>
                            <input type="text" class="form-control" id="username" name="email" placeholder="Enter email">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password-input">Password</label>
                            <div class="position-relative auth-pass-inputgroup mb-3">
                                <input type="password" class="form-control pe-5 password-input" name="password" placeholder="Enter password" id="password-input">
                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary w-100" type="submit" id="loginBth">Sign In</button>
                        </div>
                    </form>
                    <div>
                        <a href="{{url('/client/create')}}">Create</a>
                    </div>

                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
</div>
</body>
</html>
<script>
    $(document).ready(function(){
        $("#loginForm").validate({
            rules : {
                email : { required : true, email : true },
                password : { required : true }
            },
            messages : {
                email : { required : "Please enter email address", email : "Please enter your email address properly" },
                password : { required : "Please enter your password" },
            },
            errorClass: "text-danger",
            submitHandler : function (form,e){
                e.preventDefault();
                let data = new FormData(form);
                let plainFormData = Object.fromEntries(data.entries());
                let jsonData = JSON.stringify(plainFormData);
                $.ajax({
                    url : 'https://candidate-testing.api.royal-apps.io/api/v2/token',
                    type : "POST",
                    data : jsonData,
                    cache : false,
                    async : false,
                    processData: false,
                    contentType: 'application/json',
                    beforeSend : function (){
                        $("#loginBtn").attr('disabled','disabled');
                    },
                    success : function(data){
                        console.log(data);
                        if(data){
                            $.ajax({
                                url : '{{route('store-token')}}',
                                type : "POST",
                                data : {
                                    "remember_token" : data.token_key,
                                    "email" : data.user.email,
                                    "_token" : "{{ csrf_token() }}",
                                },
                                cache : false,
                                async : false,
                                success: function (datas){
                                    if(datas.status == 1){
                                        Swal.fire({
                                            title: 'Success',
                                            text: datas.message,
                                            icon: 'success',
                                            showConfirmButton: true
                                        });
                                    }
                                }
                            })
                        }

                           /* Swal.fire({
                                title: 'Success',
                                text: data.message,
                                icon: 'success',
                                timer: 2000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $("#loginForm").trigger('reset');
                            window.location.reload();*/
                    },
                    complete : function (){
                        $("#loginBtn").removeAttr('disabled');
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Failed',
                            icon: 'warning',
                            text: error.detail,
                            timer: 2000,
                        })
                    }
                });
            }
        })
    })

</script>
