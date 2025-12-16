@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4 ">Custom Notification</h4>
                        <h4 class="card-title mb-4 ">
                            <a href="{{ url('admin/custom/add') }}">
                                <button class="btn btn-primary">
                                    <i class="bx bx-plus"></i>
                                    Add Custom Notification
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
                        <table id="datatable__" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Image</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    <th>Resend</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key)
                                    <tr id="tr{{ $key->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $key->title }}</td>
                                        <td>{{ $key->description }}</td>
                                        <td>{{ $key->category ? ucfirst($key->category->name) : 'N/A' }}</td>
                                        <td>{{ $key->subcategory ? ucfirst($key->subcategory->name) : 'N/A' }}</td>
                                        <td>
                                            <img width='80'
                                                src="{{ asset('public/assets/images/notification/' . $key->image) }}"
                                                alt="">
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/custom/edit/' . $key->id) }}" class="btn btn-primary">
                                                <i class="bx bx-pencil"></i> Edit
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#"
                                                onClick="DeleteUser('{{ $key->id }}','tr{{ $key->id }}')"
                                                class="btn btn-danger">
                                                <i class="bx bx-trash-alt"></i> Delete
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin_task.resend', $key->id) }}" class="btn btn-warning">
                                                <i class="bx bx-target"></i> Resend
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
                                <form class="user" action="{{ url('admin/custom/delete') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" id="deleteid" />
                                    <div class="modal-body">Are you sure want to DELETE this recored?</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button data-id="" class="btn btn-danger delete_button"
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
            $('#datatable__').DataTable({
                "aaSorting": []
            });
            $(document).on('click', '.delete_button', function(e) {
                var id = $('#deleteid').val();
                var tr = $(this).attr('data-id');
                $.ajax({
                    method: 'POST',
                    url: "{{ url('admin/custom/delete') }}",
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
            // alert();

            $('#deleteid').val(id);
            $('.delete_button').attr('data-id', tr);
            $('#DeletePopup').modal('show');
        }
    </script>
@stop
