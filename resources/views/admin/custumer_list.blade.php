@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4 ">Customer List</h4>
                        <h4 class="card-title mb-4 ">
                            <a href="{{ url('admin/user/add?type=customer') }}">
                                <button class="btn btn-primary">
                                    <i class="bx bx-plus"></i>
                                    Add Customer
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
                    <div class="mb-3">
                        <form method="GET" action="{{ url('admin/custumer/new-list') }}">
                            <div class="d-flex align-items-center">
                                <label class="me-2">Filter:</label>
                                <select name="filter" class="form-select w-auto me-2" onchange="this.form.submit()">
                                    <option value="">All</option>
                                    <option value="last_10_days"
                                        {{ request('filter') == 'last_10_days' ? 'selected' : '' }}>Last 10 Days</option>
                                    <option value="last_15_days"
                                        {{ request('filter') == 'last_15_days' ? 'selected' : '' }}>Last 15 Days</option>
                                    <option value="last_month" {{ request('filter') == 'last_month' ? 'selected' : '' }}>
                                        Last Month</option>
                                    <option value="last_3_months"
                                        {{ request('filter') == 'last_3_months' ? 'selected' : '' }}>Last 3 Months</option>
                                    <option value="last_6_months"
                                        {{ request('filter') == 'last_6_months' ? 'selected' : '' }}>Last 6 Months</option>

                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Image</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Register Timestamp</th>
                                    <th>Status</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                  @php
                                     @$j =1;
                                @endphp
                                @foreach ($data as $i => $key)
                                    <tr id="tr{{ $key->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ ucfirst($key->name) }}</td>
                                        <td><img width='80'
                                                src="{{ asset('public/assets/images/users') . '/' . $key->image }}"
                                                alt=""></td>
                                        <td>{{ $key->email }}</td>
                                        <td>{{ ucwords($key->number) }}</td>
                                        <td>{{ $key->state ? ucfirst($key->state) : 'N/A' }}</td>
                                        <td>{{ $key->city ? ucfirst($key->city) : 'N/A' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($key->created_at)->format('jS F Y, h:i A') }}</td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='User' data-id="{{ $key->id }}"
                                                    {{ $key->status == '1' ? 'Checked' : '' }}>
                                                <label for=""></label>
                                            </div>

                                        </td>
                                        <!-- <td> <a href="{{ url('admin/user/edit') . '/' . $key->id }}"
                                                class="btn btn-primary">
                                                <i class="bx bx-pencil"></i>
                                                Edit</a>
                                        </td> -->
                                         <td> <a href="{{ url('admin/user/edit/' . $key->id) . '?type=customer' }}"
                                                class="btn btn-primary">
                                                <i class="bx bx-pencil"></i>
                                                Edit
                                            </a>

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
                                <form class="user" action="{{ url('admin/user/delete') }}" method="POST">
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
            $(document).on('click', '.delete_button', function() {
                var id = $('#deleteid').val();
                var tr = $(this).attr('data-id');
                $.ajax({
                    method: 'POST',
                    url: "{{ url('admin/user/delete') }}",
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
            $('.active_status').on('change', function() {
                let id = $(this).attr('data-id');
                let model = $(this).attr('data-model');
                if ($(this).prop("checked") == true) {
                    ajaxStatusChange('1', id, model);
                    // $(this).siblings('label').html('De-active');
                } else {
                    ajaxStatusChange('0', id, model);
                    // $(this).siblings('label').html('Active');
                }
            });
        })

        function ajaxStatusChange(status, id, model) {
            $.ajax({
                method: 'POST',
                url: "{{ url('admin/ajaxStatusChange') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    status: status,
                    model: model,
                },
                success: function(data) {
                    $('#toast-message').text('Estimate Status Change Successfully...');
                    $("#toast-container").show();
                    $("#toast-container").delay(3000).fadeOut(300);
                }
            });
        }

        function DeleteUser(id, tr) {
            $('#deleteid').val(id);
            $('.delete_button').attr('data-id', tr)
            $('#DeletePopup').modal('show');

        }
    </script>
@stop
