@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4 ">Media List Like</h4>
                        <h4 class="card-title mb-4 ">

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
                                    <th>Media Name</th>
                                    <th>Like Counts</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $i => $key)
                                    <tr id="tr{{ $key->id }}">
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $key->media ? ucwords($key->media->name) : '-' }}</td>
                                        <td>{{ $key->like_count }}</td>

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
                                <form class="user" action="{{ url('admin/media/delete') }}" method="POST">
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
                    url: "{{ url('admin/media/delete') }}",
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
