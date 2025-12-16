@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4 ">Estimate List</h4>
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
                                    <th>Estimate ID</th>
                                    <th>User ID</th>
                                    <!-- <th>Product Name</th> -->
                                    <th>Weight</th>
                                    <th>Quantity</th>
                                    {{-- <th>Remarks</th> --}}
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Print</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key)
                                    <tr id="tr{{ $key->id }}">
                                        <td>{{ $key->id }}</td>
                                        <td style="white-space: break-spaces">{{ $key->order_id }}</td>
                                        <td>
                                            @if ($key->user)
                                                {{ ucfirst($key->user->name) }}
                                            @endif
                                        </td>
                                        <td>{{ $key->weight }}</td>
                                        <td>{{ $key->quantity }}</td>
                                        {{-- <td>{{ $key->remarks }}</td> --}}
                                        <td style="white-space: break-spaces">
                                            <select name="status" data-id="{{ $key->id }}" style="width: 150px"
                                                class="form-select active_status" id="order_status">
                                                <option value="Pending" {{ $key->status == 'Pending' ? 'selected' : '' }}>
                                                    Pending</option>
                                                <option value="Reject" {{ $key->status == 'Reject' ? 'selected' : '' }}>
                                                    Reject</option>
                                                <option value="Development"
                                                    {{ $key->status == 'Development' ? 'selected' : '' }}>Development
                                                </option>
                                                <option value="Delivery"
                                                    {{ $key->status == 'Delivery' ? 'selected' : '' }}>
                                                    Delivery</option>
                                                <option value="Success" {{ $key->status == 'Success' ? 'selected' : '' }}>
                                                    Success</option>
                                            </select>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($key->created_at)->isoFormat('MMM Do YYYY') }}</td>

                                        <td>{{ \Carbon\Carbon::parse($key->updated_at)->format('h:i:s') }}</td>

                                        </td>
                                        <td><button class="btn btn-success print_order"
                                                data-order-id="{{ $key->order_id }}">Print</button></td>
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
                    <!-- model -->


                    <!-- model -->

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
                                <form class="user" action="{{ url('admin/order/delete') }}" method="POST">
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
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.print_order', function() {
                var order_id = ($(this).data('order-id'));
                window.location = "{{ url('admin/order/invoice') . '/' }}" + order_id;
                return;
                $.ajax({
                    method: 'post',
                    url: "{{ url('admin/order/invoice') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        order_id: order_id,
                    },
                    success: function(data) {
                        alert(data);
                    }
                })
            })

            $(document).on('click', '.delete_button', function(e) {
                var id = $('#deleteid').val();
                var tr = $(this).attr('data-id');
                $.ajax({
                    method: 'POST',
                    url: "{{ url('admin/order/delete') }}",
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


            var table = $('#dataTable-order').DataTable({
                responsive: true,
                order: [
                    [1, "asc"]
                ],
                buttons: [
                    'print', {
                        extend: 'print',
                        text: 'Print all (not just selected)',
                        exportOptions: {
                            modifier: {
                                selected: null
                            }
                        }
                    }
                ],
                select: true
            });

            table.buttons().container()
                .appendTo('#dataTable-order_filter');


            $('.view_button').click(function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    'method': 'POST',
                    url: "{{ url('admin/order/detail') }}",
                    data: {
                        token: "{{ csrf_token() }}",
                        id: id,
                    },
                    success: function(data) {
                        $('#details').html(data);
                        $('#orderDetailModal').modal('show');
                    }
                });
            })

            $('.active_status').on('change', function() {
                let id = $(this).attr('data-id');
                let val = $(this).val();
                $.ajax({
                    method: 'POST',
                    url: "{{ url('admin/orderStatusChange') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        status: val,
                    },
                    success: function(data) {
                        $("#toast-container-order").removeClass('hide');
                        $("#toast-container-order").addClass('show');
                        $("#toast-container-order").show();
                        $("#toast-container-order").delay(3000).fadeOut('show');
                    }
                });
            });
        })

        function DeleteUser(id, tr) {
            $('#deleteid').val(id);
            $('.delete_button').attr('data-id', tr);
            $('#DeletePopup').modal('show');
        }

        // function imprimir() {
        //     var divToPrint = document.getElementById("ConsutaBPM");
        //     newWin = window.open("");
        //     newWin.document.write(divToPrint.outerHTML);
        //     newWin.print();
        //     newWin.close();
        // }
    </script>
    {{-- <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> --}}
    {{-- <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"> --}}

@stop
