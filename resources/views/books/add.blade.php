@extends('layouts.user')
@section('title','Add Book')
@section('pagename','Add Book')
@section('body')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card mt-4 card-bg-fill">
                <div class="card-body p-4">
                    <div class="text-center mt-2">
                        <h5 class="text-primary">Add book!</h5>
                    </div>
                    <div class="p-2 mt-4">
                        <form id="loginForm">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">author</label>
                                <select name="author" class="form-control multiplerole" id="authors">
                                    @foreach($authersdata as $data)
                                        <option value="{{$data['id']}}">({{$data['id']}}) {{$data['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="release_date" class="form-label">release_date</label>
                                <input type="date" class="form-control" id="release_date" name="release_date">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">description</label>
                                <input type="text" class="form-control" id="description" name="description">
                            </div>
                            <div class="mb-3">
                                <label for="format" class="form-label">format</label>
                                <input type="text" class="form-control" id="format" name="format">
                            </div>
                            <div class="mb-3">
                                <label for="isbn" class="form-label">isbn</label>
                                <input type="text" class="form-control" id="isbn" name="isbn">
                            </div>
                            <div class="mb-3">

                                <label for="number_of_pages" class="form-label">number_of_pages</label>
                                <input type="text" class="form-control" id="number_of_pages" name="number_of_pages">
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary w-100" type="submit" id="loginBth">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $('.multiplerole').select2();
            $("#loginForm").validate({
                rules : {
                    title : { required : true},
                    author : { required : true},
                    release_date : { required : true},
                    description : { required : true},
                    format : { required : true},
                    isbn : { required : true},
                    number_of_pages : { required : true},
                },
                messages : {
                    title : { required : "Please enter title"},
                },
                errorClass: "text-danger",
                submitHandler : function (form,e){
                    e.preventDefault();
                    // data is our form
                    let data = new FormData(form);
                    let plainFormData = Object.fromEntries(data.entries());
                    plainFormData.number_of_pages = parseInt(plainFormData.number_of_pages);
                    plainFormData.author = {id: parseInt(plainFormData.author)};
                    let jsonData = JSON.stringify(plainFormData);
                    $.ajax({
                        url : 'https://candidate-testing.api.royal-apps.io/api/v2/books',
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
                            Swal.fire({
                                title: 'Success',
                                text: 'Book Added',
                                icon: 'success',
                                timer: 2000,
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            $("#loginForm").trigger('reset');
                            window.location.reload();
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

