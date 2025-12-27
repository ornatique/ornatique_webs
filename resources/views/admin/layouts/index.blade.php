@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4 ">Layouts List</h4>
                        <h4 class="card-title mb-4 ">
                            <a href="{{ url('admin/layouts/add') }}">
                                <button class="btn btn-primary">
                                    <i class="bx bx-plus"></i> Add Layout
                                </button>
                            </a>
                        </h4>
                    </div>

                    @if (session('msg'))
                        <div class="toast fade show bg-success top-right" role="alert" aria-live="assertive"
                            aria-atomic="true">
                            <div class="toast-header">
                                <i class="mdi mdi-palette me-1 text-primary"></i>
                                <strong class="me-auto">Ornatique</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast"
                                    aria-label="Close"></button>
                            </div>
                            <div class="toast-body text-white">{{ session('msg') }}</div>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="datatable__" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Color</th>
                                    <th>Shape</th>
                                    <th>Category</th>
                                    <th>Sub Category</th>
                                    <th>Product</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($layouts as $layout)
                                    <tr id="tr{{ $layout->id }}">
                                       <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($layout->image)
                                                <img width="80"
                                                    src="{{ asset('public/assets/images/layouts/' . $layout->image) }}"
                                                    alt="">
                                            @endif
                                        </td>
                                        <td>{{ ucfirst($layout->name) }}</td>
                                        <td>
                                            <span
                                                style="background-color: {{ $layout->color }}; color: white; padding: 4px 8px; border-radius: 4px;">
                                                {{ $layout->color ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td>{{ ucfirst($layout->shape) }}</td>
                                        <td>
                                            @if ($layout->category)
                                                {{ ucfirst($layout->category->name) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($layout->subcategory)
                                                {{ ucfirst($layout->subcategory->name) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($layout->product)
                                                {{ ucfirst($layout->product->name) }}
                                            @endif
                                        </td>

                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status_layout" type="checkbox"
                                                    data-id="{{ $layout->id }}"
                                                    {{ $layout->status == 1 ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/layouts/edit/' . $layout->id) }}"
                                                class="btn btn-primary">
                                                <i class="bx bx-pencil"></i> Edit
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#"
                                                onClick="DeleteLayout('{{ $layout->id }}','tr{{ $layout->id }}')"
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
                    <div class="modal fade" id="DeletePopup" tabindex="-1" role="dialog" aria-labelledby="DeleteLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmation?</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ url('admin/layouts/delete') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" id="deleteid" />
                                    <div class="modal-body">Are you sure want to DELETE this layout?</div>
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

            // Toggle status
            $('.active_status_layout').on('change', function() {
                let id = $(this).data('id');
                let status = $(this).prop('checked') ? 1 : 0;
                $.ajax({
                    url: "{{ url('admin/layouts/status') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        status: status
                    },
                    success: function(data) {
                        alert('Layout status updated successfully!');
                    },
                    error: function() {
                        alert('Something went wrong!');
                    }
                });
            });

            // Delete layout
            $(document).on('click', '.delete_button', function() {
                var id = $('#deleteid').val();
                var tr = $(this).attr('data-id');
                $.ajax({
                    method: 'POST',
                    url: "{{ url('admin/layouts/delete') }}",
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

        function DeleteLayout(id, tr) {
            $('#deleteid').val(id);
            $('.delete_button').attr('data-id', tr);
            $('#DeletePopup').modal('show');
        }
    </script>
@stop
