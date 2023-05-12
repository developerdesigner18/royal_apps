<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
            crossorigin="anonymous"></script>
    <script src="{{asset('js/jquery-3.6.0.js')}}"></script>
    <script src="{{asset('js/jquery.validate.js')}}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.11.2/js/jquery.dataTables.min.js"></script>
</head>
<body>

<h4> Author Name : <span id="aName"></span> </h4>
<h4> Geneder : <span id="aGender"></span> </h4>
<h4> Birth Date : <span id="aBd"></span> </h4>
<h4> Birth Place : <span id="aBp"></span> </h4>
<h4> Biography : <span id="aBi"></span> </h4>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="col-sm">
                    <div class="d-flex justify-content-sm-end">
                        <a href="{{url('add-book')}}" type="button" class="btn btn-primary add-btn" ><i class="ri-add-line align-bottom me-1"></i> Add Book</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table align-middle table-nowrap w-100" id="userTable"></table>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>
</body>
</html>

<script>
    let dataTable = $("#userTable").DataTable({
        retrieve: false,
        processing: true,
        responsive: true,
        serverSide: true,
        info: true,
        dom: "Bfrtip",
        lengthMenu: [
            [10, 25, 50, 75, -1],
            ["10 rows", "25 rows", "50 rows", "75 rows", "Show all"],
        ],
        columns: [
            {data: "id", title: "Id", class: "text-center",},
            {data: "title", title: "Title", class: "text-center",},
            {data: "number_of_pages", title: "Page Number", class: "text-center",},
            {data: "release_date", title: "Release", class: "text-center",},
            {data: "isbn", title: "isbn", class: "text-center",},
            {data: "format", title: "Format", class: "text-center",},
            {data: "description", title: "Description", class: "text-center",},
            {
                data: "id",
                title: "action",
                render: function (data) {
                    return '<a data-id="'+data+'" href="javascript:void(0);" class="btnDelete"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18"><path d="M7 6V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7ZM9 4V6H15V4H9Z" fill="rgba(255,1,1,1)"></path></svg></a>';
                }
            },
        ],
        ajax: {
            url: 'https://candidate-testing.api.royal-apps.io/api/v2/authors/{{$authors}}',
            dataType: "JSON",
            dataSrc: "books",
            headers: {
                "Authorization": "Bearer {{session('token')}}"
            },
            complete: function (datas){
                let responseJson = datas.responseJSON;
                $('#aName').html(responseJson.first_name+' '+responseJson.last_name);
                $('#aGender').html(responseJson.gender);
                $('#aBd').html(responseJson.birthday);
                $('#aBp').html(responseJson.place_of_birth);
                $('#aBi').html(responseJson.biography);
            },
        },
        buttons: ["pageLength"],
        responsive: {
            breakpoints: [
                {name: "desktop", width: Infinity},
                {name: "tablet", width: 1024},
                {name: "fablet", width: 768},
                {name: "phone", width: 480},
            ]
        },
    });


    $(document).on('click','.btnDelete',function (){
        let id = $(this).data('id');
        Swal.fire({
            title: "Are you sure?",
            text: "Are you sure you want to delete item?",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, sure",
            cancelButtonText: "No, cancel",
            confirmButtonClass: "btn btn-soft-danger me-2",
            cancelButtonClass: "btn btn-soft-success ms-2",
            buttonsStyling: !1,
        }).then(function (t) {
            if (t.value) {
                $.ajax({
                    url: "https://candidate-testing.api.royal-apps.io/api/v2/books/"+id,
                    method: "DELETE",
                    headers: {
                        "Authorization": "Bearer {{session('token')}}"
                    },
                    data: {
                        '_token': "{{csrf_token()}}",
                    },
                    success: function (data) {
                            Swal.fire({
                                title: "Success",
                                text: 'Book deleted',
                                icon: "success",
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 1500
                            });
                            dataTable.ajax.reload(null, false);
                    }
                });
            } else {
                Swal.fire({
                    title: "Canceled!",
                    text: "Your action has been canceled.",
                    icon: "error",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timer: 1500
                });
            }
        });
    });
</script>
