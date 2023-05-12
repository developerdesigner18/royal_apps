<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Add</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="{{asset('js/jquery-3.6.0.js')}}"></script>
    <script src="{{asset('js/jquery.validate.js')}}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
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
</body>
</html>
<script>
    $(document).ready(function(){
        $('.multiplerole').select2();
        $("#loginForm").validate({
            rules : {
                title : { required : true},
            },
            messages : {
                title : { required : "Please enter title"},
            },
            errorClass: "text-danger",
            submitHandler : function (form,e){
                e.preventDefault();
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
