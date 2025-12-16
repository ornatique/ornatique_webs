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
                        <table id="datatable__" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    {{-- <th>Image</th> --}}
                                    <th>QR</th>
                                    <th>Product Name</th>
                                    <th>Category Name</th>
                                    <th>Sub Category Name</th>
                                    <!-- <th>Number</th> -->
                                    <th>Size</th>
                                    <th>Hole Size</th>
                                    <th>Weight</th>
                                    <th>BG Color</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <div class="row justify-content-between">
                                <div class="col-2">
                                    <form action="">
                                        <div class="col-4">
                                            <select name="pagination" onchange="this.form.submit();"
                                                class="form-select mb-2" id="">
                                                <option value="25" selected>25</option>
                                                <option value="50"
                                                    @isset($pagi)
                                                    {{ $pagi == '50' ? 'selected' : '' }}
                                                @endisset>
                                                    50</option>
                                                <option value="100"
                                                    @isset($pagi)
                                                    {{ $pagi == '100' ? 'selected' : '' }}
                                                @endisset>
                                                    100</option>
                                                <option value="150"
                                                    @isset($pagi)
                                                    {{ $pagi == '150' ? 'selected' : '' }}
                                                @endisset>
                                                    150</option>
                                            </select>
                                        </div>
                                        <input type="text" name="q" id="q" placeholder="Search Here"
                                            @isset($q) value="{{ $q }}" @endisset
                                            class="form-control mb-2">
                                        <button type="submit" class="btn btn-sm btn-primary me-2 mb-2">Search</button>
                                        <a href="{{ url('admin/product/list') }}">
                                            <button type="button" class="btn btn-sm btn-danger mb-2">Reset</button>
                                        </a>
                                    </form>
                                </div>
                                <div class="pagination-wrap col-5">
                                    <nav aria-label="Page navigation example">
                                        {{ $data->appends(Request::all())->links() }}
                                    </nav>
                                </div>
                            </div>
                            <tbody>
                                 @php
                                     @$i =1;
                                @endphp
                                @foreach ($data as $key)
                                    <tr id="tr{{ $key->id }}">
                                        <td>
                                            <input type="checkbox" name="product_id" value="{{ $key->id }}"
                                                class="product_ids">
                                                
                                           {{ $data->firstItem() + $loop->index }}
                                        </td>
                                        {{-- <td>
                                            <img width='80'
                                                src="{{ asset('public/assets/images/product') . '/' . $key->image }}"
                                                alt="">
                                        </td> --}}
                                        <td class="pb-5 px-5">
                                            <span class="me-5">
                                                {{-- <img src="data:image/png;base64, {!! base64_encode(\QrCode::format('png')->generate($key->name), 'QrCode.png', 'image/png') !!} "> --}}
                                                {{-- <img src="{!! embedData(\QrCode::format('png')->generate($key->name), 'QrCode.png', 'image/png') !!}"> --}}
                                                <a href="{{ route('download.image', $key->id) }}" target="_blank" download>
                                                    {{ \QrCode::size(50)->generate(ucfirst($key->id)) }} </a>
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
                                        <td>{{ $key->hole_size }}</td>
                                        <td>{{ $key->weight }}</td>
                                        <td>
                                            <span
                                                style="background-color: {{ $key->bg_color }}; color: white; padding: 4px 8px; border-radius: 4px;">
                                                {{ $key->bg_color ? $key->bg_color : 'N/A' }}
                                            </span>
                                        </td>
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
                        <div class="row justify-content-between">
                            <div class="col-4">
                                Viewing {{ $data->firstItem() }} - {{ $data->lastItem() }} of
                                {{ $data->total() }} entries
                            </div>
                            <div class="col-5">
                                <div class="pagination-wrap float-end">
                                    <nav aria-label="Page navigation example">
                                        {{ $data->appends(Request::all())->links() }}
                                    </nav>
                                </div>
                            </div>
                        </div>
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
//         $('#datatable__').DataTable({
//     ordering: false,
//     paging: false,   // Laravel already paginates
//     searching: false
// });

        $(document).ready(function() {
            $('.product_ids').click(function() {
                console.log("hii");
                var yourArray = [];
                $("input:checkbox[name=product_id]:checked").each(function() {
                    yourArray.push($(this).val());
                });
                console.log(yourArray);
                $('#product_ids').val(yourArray);

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
                        // location.reload();
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
