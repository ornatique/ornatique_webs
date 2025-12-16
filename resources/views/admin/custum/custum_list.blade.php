@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4 ">Custom Estimate List</h4>
                    </div>
                    <div class="toast fade bg-success top-right" id="toast-container-order" role="alert" aria-live="assertive"
                        aria-atomic="true">
                        <div class="toast-header">
                            <i class="mdi mdi-account me-1 text-primary"></i>
                            <strong class="me-auto">Ornatique</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                        <div class="toast-body text-white">
                            Estimate Status Change Successfulyy.
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTable-order" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Remarks</th>
                                    {{-- <th>Description</th> --}}
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Edit</th>
                                    <th>Print</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key)
                                    <tr id="tr{{ $key->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $key->user ? ucfirst($key->user->name) : '' }}</td>
                                        <td>
                                            <img width='80'
                                                src="{{ asset('public/assets/images/custom') . '/' . $key->image }}"
                                                alt="">
                                        </td>

                                        <td style="white-space: break-spaces">{{ ucwords($key->remarks) }}</td>
                                        {{-- <td> <?php echo htmlspecialchars_decode(ucfirst($key->description)); ?></td> --}}
                                        <td>
                                            <select name="status" data-id="{{ $key->id }}"
                                                class="form-select
                                                active_status"
                                                id="order_status" data-user_id="{{ $key->user_id }}">
                                                <option value="Pending" {{ $key->status == 'Pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="Approval" {{ $key->status == 'Approval' ? 'selected' : '' }}>
                                                    Approval</option>
                                                <option value="Making" {{ $key->status == 'Making' ? 'selected' : '' }}>
                                                    Making
                                                </option>
                                                <option value="Finishing"
                                                    {{ $key->status == 'Finishing' ? 'selected' : '' }}>
                                                    Finishing</option>
                                                <option value="Done" {{ $key->status == 'Done' ? 'selected' : '' }}>
                                                    Done</option>
                                            </select>
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($key->created_at)->isoFormat('MMM Do YYYY') }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($key->updated_at)->format('h:i A') }}</td>
                                        <td><a href="{{ url('admin/custum/edit') . '/' . $key->id }}"
                                                class="btn btn-primary">
                                                <i class="bx bx-pencil"></i>
                                                Edit</a>
                                        </td>
                                        <td><button class="btn btn-success print_order"
                                                data-order-id="{{ $key->id }}">Print</button></td>
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
                                <form class="user" action="{{ url('admin/custum/delete') }}" method="POST">
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

            $(document).on('click', '.print_order', function() {
                var order_id = ($(this).data('order-id'));
                window.open("{{ url('admin/custom-order/invoice') . '/' }}" + order_id, '_blank');
                return;
            })

            $(document).on('click', '.delete_button', function() {
                var id = $('#deleteid').val();
                var tr = $(this).attr('data-id');
                $.ajax({
                    method: 'POST',
                    url: "{{ url('admin/custum/delete') }}",
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        // alert(data.msg);
                        $('#' + tr).remove();
                        $('#DeletePopup').modal('hide');
                    }
                })
            })

            $('.active_status').on('change', function() {
                let id = $(this).attr('data-id');
                let user_id = $(this).attr('data-user_id');
                let val = $(this).val();
                $.ajax({
                    method: 'POST',
                    url: "{{ url('admin/orderStatusChange') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        status: val,
                        custom: 'Custom',
                        user_id: user_id,
                    },
                    success: function(data) {
                        $("#toast-container-order").removeClass('hide');
                        $("#toast-container-order").addClass('show');
                        $("#toast-container-order").show();
                        $("#toast-container-order").delay(3000).fadeOut('show');
                    }
                });
            });


            // var table = $('#dataTable-order').DataTable({
            //     responsive: true,
            //     order: [
            //         [1, "asc"]
            //     ],
            //     buttons: [
            //         'pdf', {
            //             extend: 'print',
            //             text: 'Print all (not just selected)',

            //             exportOptions: {
            //                 modifier: {
            //                     selected: null
            //                 }
            //             }
            //         }
            //     ],
            //     select: true

            // });
            var table = $('#dataTable-order').DataTable({
                responsive: true,
                order: [
                    [1, "asc"]
                ],
            });

            table.buttons().container()
                .appendTo('#dataTable-order_filter');

        })

        function DeleteUser(id, tr) {
            $('#deleteid').val(id);
            $('.delete_button').attr('data-id', tr);
            $('#DeletePopup').modal('show');

        }
    </script>
@stop
