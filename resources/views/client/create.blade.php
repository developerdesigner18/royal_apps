@extends('layouts.user')
@section('title','DashBoard')
@section('pagename','DashBoard')
@section('body')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4 card-bg-fill">
                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Welcome Back !</h5>
                    </div>
                    <div class="p-2 mt-4">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">Email</label>
                                <input type="text" class="form-control" id="username" name="email" placeholder="Enter email">
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select name="roles[]" class="form-control multiplerole" id="role">
                                    <option value="ROLE_ADMIN" selected>ROLE_ADMIN</option>
                                    <option value="ROLE_ADMIN">ROLE_ADMIN</option>
                                    <option value="ROLE_ADMIN">ROLE_ADMIN</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Firstname</label>
                                <input type="text" class="form-control" id="firstname" name="first_name" placeholder="Enter firstname">
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Lastname</label>
                                <input type="text" class="form-control" id="lastname" name="last_name" placeholder="Enter firstname">
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" class="form-control multiplerole" id="gender">
                                    <option value="male" slected>Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password-input">Password</label>
                                <div class="position-relative auth-pass-inputgroup mb-3">
                                    <input type="password" class="form-control pe-5 password-input" name="password" placeholder="Enter password" id="password-input">
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary w-100" type="submit" id="loginBth">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $('.multiplerole').select2();
            $("#loginForm").validate({
                rules : {
                    email : { required : true, email : true },
                    first_name : { required : true,},
                    last_name : { required : true, },
                    password : { required : true ,minlength: 23}
                },
                messages : {
                    email : { required : "Please enter email address", email : "Please enter your email address properly" },
                    password : { required : "Please enter your password" },
                },
                errorClass: "text-danger",
                submitHandler : function (form,e){
                    e.preventDefault();
                    let data = new FormData(form);
                    let roles = data.getAll('roles[]');
                    data.delete('roles[]');
                    let plainFormData = Object.fromEntries(data.entries());
                    plainFormData.roles = roles;
                    plainFormData.active = true;
                    let jsonData = JSON.stringify(plainFormData);
                    $.ajax({
                        url : 'https://candidate-testing.api.royal-apps.io/api/v2/users',
                        type : "POST",
                        data : jsonData,
                        cache : false,
                        async : false,
                        processData: false,
                        contentType: 'application/json',
                        headers: {
                            "Authorization": "Bearer {{session('token')}}"
                        },
                        beforeSend : function (){
                            $("#loginBtn").attr('disabled','disabled');
                        },
                        success : function(data){
                            console.log(data);
                            if(data) {
                                Swal.fire({
                                    title: 'Success',
                                    text: data.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                                $("#loginForm").trigger('reset');
                                window.location.reload();
                            }
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
@endsection
