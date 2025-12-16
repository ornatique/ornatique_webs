@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4 ">Product List</h4>
                        <h4 class="card-title mb-4 mr-2">
                            <form action="{{ url('admin/print/qrs') }}" target="_blank">
                                <input type="hidden" id="product_ids" name="product_ids">
                                <button id="harsh" class="btn btn-success">
                                    Print Selected QR Code
                                </button>
                            </form>
                        </h4>
                        <h4 class="card-title mb-4 ">
                            <a href="{{ url('admin/product/add') }}">
                                <button class="btn btn-primary">
                                    <i class="bx bx-plus"></i>
                                    Add Product
                                </button>
                            </a>
                        </h4>

                    </div>
                    @if (session('msg'))
                        <div class="toast fade show bg-success top-right" role="alert" aria-live="assertive"
                            aria-atomic="true">
                            <div class="toast-header">
                                <i class="mdi mdi-account me-1 text-primary"></i>
                                <strong class="me-auto">Ornatique</strong>
                                {{-- <small class="text-muted">11 mins ago</small> --}}
                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                            <div class="toast-body text-white">
                                {{ session('msg') }}
                            </div>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="" class="table table-bordered dt-responsive nowrap w-100 products_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Product QR</th>
                                    <th>Product Name</th>
                                    <th>Category Name</th>
                                    <th>Sub Category Name</th>
                                    <!-- <th>Number</th> -->
                                    <th>Size</th>
                                    <th>Hole Size</th>
                                    <th>Weight</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                        {{-- <table class="table table-bordered yajra-datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Phone</th>
                                    <th>DOB</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table> --}}

                    </div>
                    {{-- Delete Modal --}}
                    <div class="modal fade" id="DeletePopup" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirmation?</h5>
                                    <a class="" style="cursor: pointer" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">X</span>
                                    </a>
                                </div>
                                <form class="user" action="{{ url('admin/product/delete') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" id="deleteid" />
                                    <div class="modal-body">Are you sure want to DELETE this recored?</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="button" data-id="" class="btn btn-danger delete_button"
                                            type="submit">Delete</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- Delete Modal --}}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {

            var table = $('.products_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin_students_list') }}",
                columns: [{
                        data: 'index',
                        name: 'index'
                    },
                    {
                        data: 'image',
                        name: 'image'
                    },
                    {
                        data: 'product_qr',
                        name: 'product_qr'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'category_id',
                        name: 'category_id'
                    },
                    {
                        data: 'subcategory_id',
                        name: 'subcategory_id'
                    },
                    {
                        data: 'size',
                        name: 'size'
                    },
                    {
                        data: 'hole_size',
                        name: 'hole_size'
                    },
                    {
                        data: 'weight',
                        name: 'weight'
                    },
                    {
                        data: 'action',
                        name: 'action',
                    },
                    {
                        data: 'delete',
                        name: 'delete',
                    },
                ]
            });

        });
        // $(function() {

        //     var table = $('.yajra-datatable').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ajax: "{{ route('admin_students_list') }}",
        //         columns: [{
        //                 data: 'DT_RowIndex',
        //                 name: 'DT_RowIndex'
        //             },
        //             {
        //                 data: 'name',
        //                 name: 'name'
        //             },
        //             {
        //                 data: 'email',
        //                 name: 'email'
        //             },
        //             {
        //                 data: 'username',
        //                 name: 'username'
        //             },
        //             {
        //                 data: 'phone',
        //                 name: 'phone'
        //             },
        //             {
        //                 data: 'dob',
        //                 name: 'dob'
        //             },
        //             {
        //                 data: 'action',
        //                 name: 'action',
        //                 orderable: true,
        //                 searchable: true
        //             },
        //         ]
        //     });

        // });
        $(document).ready(function() {
            $(document).on('click', '.product_ids', function() {
                var yourArray = [];
                $("input:checkbox[name=product_id]:checked").each(function() {
                    yourArray.push($(this).val());
                });
                $('#product_ids').val(yourArray);
                // $.ajax({
                //     method: "POST",
                //     url: "{{ url('admin/print/qrs') }}",
                //     data: {
                //         '_token': "{{ csrf_token() }}",
                //         products: yourArray,
                //     },
                //     success: function() {

                //     }
                // })
            })
            $(document).on('click', '.print_qr', function() {
                var qr = ($(this).data('qr-name'));
                window.open("{{ url('admin/print/qr') . '/' }}" + qr, '_blank');
                return;
            })
            $(document).on('click', '.delete_button', function(e) {
                var id = $('#deleteid').val();
                var tr = $(this).attr('data-id');
                $.ajax({
                    method: 'POST',
                    url: "{{ url('admin/product/delete') }}",
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        alert(data.msg);
                        $('#' + tr).remove();
                        $('#DeletePopup').modal('hide');
                    }
                })
            })


        })

        function DeleteUser(id, tr) {
            $('#deleteid').val(id);
            $('.delete_button').attr('data-id', tr);
            $('#DeletePopup').modal('show');
        }
    </script>

@stop
