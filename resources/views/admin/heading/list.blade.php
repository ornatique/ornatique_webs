@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4 ">Heading List</h4>
                        <h4 class="card-title mb-4 ">
                            {{-- <a href="{{ url('admin/heading/add') }}">
                                <button class="btn btn-primary">
                                    <i class="bx bx-plus"></i>
                                    Add Category
                                </button>
                            </a> --}}
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
                        <table id="datatable__" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Heading One</th>
                                    <th>Heading Two</th>
                                    <th>Heading Three</th>
                                    <th>App Bar Color</th>
                                    <th>Bottom Bar Color</th>
                                    <th>Back Ground Color</th>
                                    <th>Edit</th>
                                    {{-- <th>Delete</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key)
                                    <tr id="tr{{ $key->id }}">
                                        <td>{{ $key->id }}</td>
                                        <td>{{ ucwords($key->heading_one) }}</td>
                                        <td>{{ ucwords($key->heading_two) }}</td>
                                        <td>{{ ucwords($key->heading_three) }}</td>
                                        <td>
                                            <span
                                                style="background-color: {{ $key->app_bar_color }}; color: #fff; padding: 4px 8px; border-radius: 4px;">
                                                {{ $key->app_bar_color ?: 'N/A' }}
                                            </span>
                                        </td>
                                        <td>

                                            <span
                                                style="background-color: {{ $key->bottom_bar_color }}; color: #fff; padding: 4px 8px; border-radius: 4px;">
                                                {{ $key->bottom_bar_color ?: 'N/A' }}
                                            </span>

                                        </td>
                                        <td>

                                            <span
                                                style="background-color: {{ $key->back_ground_color }}; color: #fff; padding: 4px 8px; border-radius: 4px;">
                                                {{ $key->back_ground_color ?: 'N/A' }}
                                            </span>
                                        </td>

                                        <td> <a href="{{ url('admin/heading/edit') . '/' . $key->id }}"
                                                class="btn btn-primary"> <i class="bx bx-pencil"></i>
                                                Edit</a>
                                        </td>
                                        {{-- <td>
                                            <a href="#"
                                                onClick="DeleteUser('{{ $key->id }}','tr{{ $key->id }}')"
                                                class="btn btn-danger">
                                                <i class="bx bx-trash-alt"></i>
                                                Delete
                                            </a>
                                        </td> --}}
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
                                <form class="user" action="{{ url('admin/cateheadinggory/delete') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" id="deleteid" />
                                    <div class="modal-body">Are you sure want to DELETE this recored?</div>
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
                    url: "{{ url('admin/heading/delete') }}",
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
