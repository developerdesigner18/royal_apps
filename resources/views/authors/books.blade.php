@extends('layouts.user')
@section('title','Books')
@section('pagename','Books')
@section('body')
    <h4> Author Name : <span id="aName"></span> </h4>
    <h4> Geneder : <span id="aGender"></span> </h4>
    <h4> Birth Date : <span id="aBd"></span> </h4>
    <h4> Birth Place : <span id="aBp"></span> </h4>
    <h4> Biography : <span id="aBi"></span> </h4>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table align-middle table-nowrap w-100" id="userTable"></table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
{{-- data table --}}
    let dataTable = $("#userTable").DataTable({
        retrieve: false,
        processing: true,
        responsive: true,
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
@endsection
