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
            {data: "first_name", title: "First Name", class: "text-center",},
            {data: "last_name", title: "Last Name", class: "text-center",},
            {data: "gender", title: "Gender", class: "text-center",},
            {data: "place_of_birth", title: "Birth Place", class: "text-center",},
            {data: "birthday", title: "Birthday", class: "text-center",},
            {
                data: "id",
                title: "action",
                render: function (data) {
                    return '<a data-id="'+data+'" href="{{url('authors')}}/'+data+'" class="btnView"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18"><path d="M1.18164 12C2.12215 6.87976 6.60812 3 12.0003 3C17.3924 3 21.8784 6.87976 22.8189 12C21.8784 17.1202 17.3924 21 12.0003 21C6.60812 21 2.12215 17.1202 1.18164 12ZM12.0003 17C14.7617 17 17.0003 14.7614 17.0003 12C17.0003 9.23858 14.7617 7 12.0003 7C9.23884 7 7.00026 9.23858 7.00026 12C7.00026 14.7614 9.23884 17 12.0003 17ZM12.0003 15C10.3434 15 9.00026 13.6569 9.00026 12C9.00026 10.3431 10.3434 9 12.0003 9C13.6571 9 15.0003 10.3431 15.0003 12C15.0003 13.6569 13.6571 15 12.0003 15Z" fill="rgba(0,7,253,1)"></path></svg></a>';
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
</script>
