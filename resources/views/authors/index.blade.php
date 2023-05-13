@extends('layouts.user')
@section('title','Authors')
@section('pagename','Authors')
@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="col-sm">
                        <div class="d-flex justify-content-sm-end">
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
@endsection
@section('js')
    <script>
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
                {data: "first_name", title: "First Name", class: "text-center",},
                {data: "last_name", title: "Last Name", class: "text-center",},
                {data: "gender", title: "Gender", class: "text-center",},
                {data: "place_of_birth", title: "Birth Place", class: "text-center",},
                {data: "birthday", title: "Birthday", class: "text-center",},
                {
                    data: "id",
                    title: "action",
                    render: function (data) {
                        return '<a data-id="' + data + '" href="{{url('authors')}}/' + data + '" class="btnView"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18"><path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z" fill="rgba(0,7,253,1)"></path></svg></a><a data-id="' + data + '" href="javascript:void(0);" class="btnDelete"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18"><path d="M7 6V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7ZM9 4V6H15V4H9Z" fill="rgba(255,1,1,1)"></path></svg></a>';
                    }
                },
            ],
            ajax: {
                url: 'https://candidate-testing.api.royal-apps.io/api/v2/authors',
                dataType: "JSON",
                dataSrc: "items",
                headers: {
                    "Authorization": "Bearer {{session('token')}}"
                },
                error: function(error) {
                    Swal.fire({
                        title: 'Failed',
                        icon: 'warning',
                        text: error.detail,
                        timer: 2000,
                    })
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

        $(document).on('click', '.btnDelete', function () {
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
                        url: "{{route('check-books')}}",
                        method: "POST",
                        headers: {
                            "Authorization": "Bearer {{session('token')}}"
                        },
                        data: {
                            '_token': "{{csrf_token()}}",
                            "id": id,
                        },
                        success: function (data) {

                            if (data.status == 1) {
                                $.ajax({
                                    url: "https://candidate-testing.api.royal-apps.io/api/v2/authors/" + id,
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
                                            text: 'Author Deleted',
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
                                    text: data.message,
                                    icon: "error",
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    timer: 1500
                                });
                            }
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


