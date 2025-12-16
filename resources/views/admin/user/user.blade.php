@extends('admin.template')
@section('main')

    <div class="row">
        <div class="col-12 col-lg-12">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">User</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin_dashboard') }}"><i
                                        class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">User List</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <!-- Datatables -->
            <div class="card">
                <div class="card-body">
                    <div class="overflow-hidden card-title">
                        <span class="float-start fs-5 fw-bolder mb-0">User</span>
                        <a href="{{ route('admin_user_add') }}"><button type="button"
                                class="float-end btn btn-primary m-1 px-3"><i class="bx bx-plus pe-2"></i>Add
                                User</button></a>
                    </div>
                    @if (session('msg'))
                        <div id="successMessage"
                            class="alert alert-success border-0 bg-success alert-dismissible fade show">
                            <div class="text-white"> {{ session('msg') }}</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <div id="statusChange" style="display: none">
                        <div id="" class="alert alert-success border-0 bg-success alert-dismissible fade show">
                            <div class="text-white"> User Status Changed Successfully</div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Activies</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($data as $user)
                                        <td>{{ $user->id }}</td>
                                        <td>{{ ucfirst($user->name) }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->contact }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input active_status" data-model='User'
                                                    data-id="{{ $user->id }}" type="checkbox" role="switch"
                                                    {{ $user->status == 1 ? 'Checked' : '' }}>
                                                <label class="custom-control-label" for="customCheck">
                                                    {{ $user->status == 1 ? 'Active' : 'De-Active' }}
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/user/edit') . '/' . $user->id }}"
                                                class="btn btn-primary">Edit</a>
                                        </td>
                                        <td><a onClick="DeleteState('{{ $user->id }}')"
                                                class="btn btn-danger">Delete</a>
                                        </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Datatables -->
            <!-- Modal -->
            <div class="modal fade" id="areaDelete" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">User Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('admin_user_delete') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <div class="modal-body">Are you sure you want delete this User?</div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Remove</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
    </div>
    </div>
    <script src="{{ asset('public/assets/admin/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {})

        function DeleteState(id) {
            $('#id').val(id);
            $('#areaDelete').modal('show');
        }
        $("#successMessage").delay(3000).fadeOut(300);


        $('.active_status').on('change', function() {
            let id = $(this).attr('data-id');
            let model = $(this).attr('data-model');
            if ($(this).prop("checked") == true) {
                ajaxStatusChange(1, id, model);
                $(this).siblings('label').html('Active');
            } else {
                $(this).siblings('label').html('De-Active');
                ajaxStatusChange(0, id, model);
            }
        });

        function ajaxStatusChange(status, id, model) {
            $.ajax({
                method: 'POST',
                url: '{{ url('admin/ajaxStatusChange') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    status: status,
                    model: model,
                },
                success: function(data) {
                    $("#statusChange").show();
                    $("#statusChange").delay(3000).fadeOut(300);
                }
            });
        }
    </script>
@stop
