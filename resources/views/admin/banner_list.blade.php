@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4 ">Banner List</h4>

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
                    <div clas="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>Advertise Image</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <img width='80'
                                            src="{{ asset('public/assets/images/banners') . '/' . $data->gallery_adv }}"
                                            alt="">
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/banner') }}" class="btn btn-primary">
                                            <i class="bx bx-pencil"></i>
                                            Edit</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {})

        function DeleteUser(id) {
            $('#deleteid').val(id);
            $('#DeletePopup').modal('show');
        }
    </script>
@stop
