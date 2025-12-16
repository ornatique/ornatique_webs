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
                                <input required type="text" class="d-none" id="product_ids" name="product_ids">
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
                                <strong class="me-auto">Ornatiques</strong>
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
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
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
                                @foreach ($data as $key)
                                    <tr id="tr{{ $key->id }}">
                                        <td>
                                            <input type="checkbox" name="product_id" value="{{ $key->id }}"
                                                class="product_ids">
                                            {{ $key->id }}
                                        </td>
                                        <td>
                                            <img width='80'
                                                src="{{ asset('public/assets/images/product') . '/' . $key->image }}"
                                                alt="">
                                        </td>
                                        <td class="pb-5 px-5">
                                            <span class="me-5">
                                                {{-- <img src="data:image/png;base64, {!! base64_encode(\QrCode::format('png')->generate($key->name), 'QrCode.png', 'image/png') !!} "> --}}
                                                {{-- <img src="{!! embedData(\QrCode::format('png')->generate($key->name), 'QrCode.png', 'image/png') !!}"> --}}
                                                <a href="{{ route('download.image', $key->id) }}" target="_blank" download>
                                                    {{ \QrCode::size(50)->generate($key->id) }} </a>
                                            </span>
                                            <button class="btn btn-success print_qr" data-qr-name="{{ $key->id }}">QR
                                            </button>
                                        </td>
                                        <td style="white-space: break-spaces">{{ ucwords($key->name) }}</td>
                                        <td>
                                            @if ($key->category)
                                                {{ $key->category->name }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($key->subcategory)
                                                {{ $key->subcategory->name }}
                                            @endif
                                        </td>
                                        <!-- <td>{{ $key->number }}</td> -->
                                        <td>{{ $key->size }}</td>
                                        <!--<td>{{ $key->hole_size }}</td>-->
                                        <td>{{ $key->hole_size }}</td>

                                        <td>{{ $key->weight }}</td>

                                        <td>
                                            <a href="{{ url('admin/product/edit') . '/' . $key->id }}"
                                                class="btn btn-primary">
                                                <i class="bx bx-pencil"></i>
                                                Edit</a>
                                        </td>
                                        <td>
                                            <a href="#"
                                                onClick="DeleteUser('{{ $key->id }}','tr{{ $key->id }}')"
                                                class="btn btn-danger">
                                                <i class="bx bx-trash-alt"></i>
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
        $(document).ready(function() {
            $('.product_ids').click(function() {
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
