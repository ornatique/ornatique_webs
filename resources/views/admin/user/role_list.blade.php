@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4 ">User Role List</h4>

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
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Dashboard</th>
                                    <!-- <th>Category Permission</th> -->
                                    <th>User Track </th>
                                    <th>User </th>
                                    <th>User Role</th>
                                    <th>Estimate </th>
                                    <th>Customize Estimate </th>
                                    <th>Category </th>
                                    <th>Subcategory </th>
                                    <th>Product </th>
                                    <th>Customer </th>
                                    <th>New Ad</th>
                                    <th>Product Ad</th>
                                    <th>Social</th>
                                    <th>Custom Notifications</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key)
                                    <tr>
                                        <td>{{ $key->id }}</td>
                                        <td>
                                            @if ($key->user)
                                                {{ ucfirst($key->user->name) }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='dashboard'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->dashboard == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>
                                        <!-- <td>
                                                                        <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                                            <input class="form-check-input active_status" type="checkbox"
                                                                                id="SwitchCheckSizelg" data-model='category_permission'
                                                                                data-id="{{ $key->id }}"
                                                                                {{ $key->category_permission == '1' ? 'Checked' : '' }}>
                                                                        </div>
                                                                    </td> -->
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='user_tracking'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->user_tracking == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='user_list'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->user_list == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='user_role'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->user_role == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='order_list'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->order_list == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='customize_order'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->customize_order == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='category_list'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->category_list == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='subcategory_list'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->subcategory_list == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='products_list'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->products_list == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='customers_list'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->customers_list == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='new_advertisment'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->new_advertisment == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='product_advertisment'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->product_advertisment == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='social'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->social == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch form-switch-lg mb-lg-3" dir="ltr">
                                                <input class="form-check-input active_status" type="checkbox"
                                                    id="SwitchCheckSizelg" data-model='custom_notification'
                                                    data-id="{{ $key->id }}"
                                                    {{ $key->custom_notification == '1' ? 'Checked' : '' }}>
                                            </div>
                                        </td>

                                        {{-- <td> <a href="{{ url('admin/user/edit') . '/' . $key->id }}" class="btn
                                btn-primary">
                                <i class="bx bx-pencil"></i>
                                Edit</a>
                                </td>
                                <td>
                                    <a href="#" onClick="DeleteUser('{{ $key->id }}')" class="btn btn-danger">
                                        <i class="bx bx-trash-alt"></i>
                                        Delete
                                    </a>
                                </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $(document).on('change', ".active_status", function() {
                // $('.active_status').on('change', function() {
                let id = $(this).attr('data-id');
                let model = $(this).attr('data-model');
                if ($(this).prop("checked") == true) {
                    ajaxStatusChange('1', id, model);
                    // $(this).siblings('label').html('0');
                } else {
                    ajaxStatusChange('0', id, model);
                    // $(this).siblings('label').html('1');
                }
            });

        })

        function ajaxStatusChange(status, id, model) {
            $.ajax({
                method: 'POST',
                url: "{{ url('admin/user_role') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id,
                    status: status,
                    model: model,
                },
                success: function(data) {
                    $('#toast-message').text('Order Status Change Successfully...');
                    $("#toast-container").show();
                    $("#toast-container").delay(3000).fadeOut(300);
                }
            });
        }



        // function DeleteUser(id) {
        //     $('#deleteid').val(id);
        //     $('#DeletePopup').modal('show');

        // }
    </script>
@stop
