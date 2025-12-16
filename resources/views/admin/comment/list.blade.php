@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4">Media List Comments</h4>
                    </div>

                    @if (session('msg'))
                        <div class="toast fade show bg-success top-right" role="alert" aria-live="assertive"
                            aria-atomic="true">
                            <div class="toast-header">
                                <i class="mdi mdi-account me-1 text-primary"></i>
                                <strong class="me-auto">Ornatique</strong>
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
                                    <th>Media Name</th>
                                    <th>Comment</th>
                                    <th>User Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $i => $key)
                                    <tr id="tr{{ $key->id }}">
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $key->media ? ucwords($key->media->name) : '-' }}</td>
                                        <td id="comment_text_{{ $key->id }}">{{ ucfirst($key->comment) }}</td>
                                        <td>{{ $key->user ? ucwords($key->user->name) : '-' }}</td>
                                        <td>
                                            <a href="#" onclick="EditUser('{{ $key->id }}')"
                                                class="btn btn-primary">
                                                <i class="bx bx-edit"></i> Edit
                                            </a>
                                            <a href="#"
                                                onclick="DeleteUser('{{ $key->id }}','tr{{ $key->id }}')"
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
                    <div class="modal fade" id="DeletePopup" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmation?</h5>
                                    <a style="cursor: pointer" data-bs-dismiss="modal">X</a>
                                </div>
                                <div class="modal-body">Are you sure want to DELETE this record?</div>
                                <div class="modal-footer">
                                    <input type="hidden" id="deleteid" />
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button data-id="" class="btn btn-danger delete_button"
                                        type="button">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Delete Modal --}}

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="EditPopup" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Comment</h5>
                                    <a style="cursor: pointer" data-bs-dismiss="modal">X</a>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="editid" />
                                    <div class="form-group">
                                        <label for="editcomment">Comment</label>
                                        <textarea id="editcomment" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-success update_button" type="button">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Edit Modal --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#datatable__').DataTable({
                "aaSorting": []
            });

            // Delete confirm
            $(document).on('click', '.delete_button', function() {
                let id = $('#deleteid').val();
                let tr = $(this).attr('data-id');
                $.ajax({
                    method: 'POST',
                    url: "{{ url('admin/comment/delete') }}",
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#' + tr).remove();
                        $('#DeletePopup').modal('hide');
                        toastr.success(data.msg);
                    }
                });
            });

            // Update confirm
            $(document).on('click', '.update_button', function() {
                let id = $('#editid').val();
                let comment = $('#editcomment').val();
                $.ajax({
                    method: 'POST',
                    url: "{{ url('admin/comment/update') }}",
                    data: {
                        id: id,
                        comment: comment,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('#comment_text_' + id).text(comment);
                        $('#EditPopup').modal('hide');
                        toastr.success(data.msg);
                    }
                });
            });
        });

        // Open Delete Modal
        function DeleteUser(id, tr) {
            $('#deleteid').val(id);
            $('.delete_button').attr('data-id', tr);
            $('#DeletePopup').modal('show');
        }

        // Open Edit Modal
        function EditUser(id) {
            let currentComment = $('#comment_text_' + id).text();
            $('#editid').val(id);
            $('#editcomment').val(currentComment);
            $('#EditPopup').modal('show');
        }
    </script>
@stop
