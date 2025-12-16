@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4">Inside App Layout List</h4>
                        <h4 class="card-title mb-4">
                            <a href="{{ url('admin/layout-names/add') }}">
                                <button class="btn btn-primary">
                                    <i class="bx bx-plus"></i> Add Inside App Layout
                                </button>
                            </a>
                        </h4>
                    </div>

                    {{-- Success Toast --}}
                    @if (session('msg'))
                        <div class="toast fade show bg-success top-right" role="alert" aria-live="assertive"
                            aria-atomic="true">
                            <div class="toast-header">
                                <i class="mdi mdi-account me-1 text-primary"></i>
                                <strong class="me-auto">Admin</strong>
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
                                    <th>Name</th>
                                    <th>Border Color</th>
                                    <th>Shape</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Product</th>
                                    <th>Created At</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($layout_names as $layout)
                                    <tr id="tr{{ $layout->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $layout->layout?->name ?? '-' }}</td>
                                        <td>
                                            <span
                                                style="background-color: {{ $layout->border_color ?? '#000' }}; color: #fff; padding: 4px 8px; border-radius: 4px;">
                                                {{ $layout->border_color ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ ucfirst($layout->shape ?? '-') }}</td>
                                        <td>{{ $layout->category?->name ?? '-' }}</td>
                                        <td>{{ $layout->subcategory?->name ?? '-' }}</td>
                                        <td>{{ $layout->product?->name ?? '-' }}</td>
                                        <td>{{ $layout->created_at?->format('d M Y') }}</td>
                                        <td>
                                            <a href="{{ url('admin/layout-names/edit', $layout->id) }}"
                                                class="btn btn-primary">
                                                <i class="bx bx-pencil"></i> Edit
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#"
                                                onClick="DeleteLayoutName('{{ $layout->id }}','tr{{ $layout->id }}')"
                                                class="btn btn-danger">
                                                <i class="bx bx-trash-alt"></i> Delete
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
                                    <a style="cursor: pointer" data-bs-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">X</span></a>
                                </div>
                                <form class="user">
                                    @csrf
                                    <input type="hidden" name="id" id="deleteid" />
                                    <div class="modal-body">Are you sure want to DELETE this record?</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button data-id="" class="btn btn-danger delete_button"
                                            type="button">Delete</button>
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
            $('#datatable__').DataTable({
                "aaSorting": []
            });

            $(document).on('click', '.delete_button', function(e) {
                var id = $('#deleteid').val();
                var tr = $(this).attr('data-id');
                $.ajax({
                    method: 'POST',
                    url: "{{ url('admin/layout-names/delete') }}",
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        alert(data.msg);
                        $('#' + tr).remove();
                        $('#DeletePopup').modal('hide');
                    }
                });
            });
        });

        function DeleteLayoutName(id, tr) {
            $('#deleteid').val(id);
            $('.delete_button').attr('data-id', tr);
            $('#DeletePopup').modal('show');
        }
    </script>
@stop
