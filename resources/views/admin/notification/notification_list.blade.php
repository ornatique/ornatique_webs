@extends('admin.template')
@section('main')
    <div class="container-fluid">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-4 ">Notification List</h4>
                    </div>
                    <div class="card-header">
                        <!--<button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()"-->
                        <!--    class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>-->
                    </div>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Notification Type</th>
                                    <th>Product</th>
                                    <th>Estimate-Id</th>
                                    <th>User</th>
                                    <th>Message</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key)
                                    <tr>
                                        <td>{{ $key->id }}</td>
                                        <td>{{ $key->notification_type }}</td>
                                        <td>{{ $key->product_id }}</td>
                                        <td>{{ $key->order_id }}</td>
                                        <td>
                                            @if ($key->user)
                                                {{ ucwords($key->user->name) }}
                                            @endif
                                        </td>
                                        <td>{{ $key->message }}</td>
                                        <td>
                                            <a href="#" class="btn btn-danger"
                                                onclick="DeleteNotification('{{ $key->id }}','tr{{ $key->id }}')">
                                                <i class="bx bx-trash-alt"></i> Delete
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
                                    <h5 class="modal-title">Confirmation?</h5>
                                    <a style="cursor: pointer" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">X</span>
                                    </a>
                                </div>
                                <form class="user">
                                    @csrf
                                    <input type="hidden" name="id" id="deleteid" />
                                    <div class="modal-body">Are you sure you want to DELETE this record?</div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" type="button"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button class="btn btn-danger delete_button" type="button">Delete</button>
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

    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyBk55n64hvMv0C8IHlfKnqcAy5jXe4LBnU",
            authDomain: "golden-b7fb0.firebaseapp.com",
            projectId: "golden-b7fb0",
            storageBucket: "golden-b7fb0.appspot.com",
            messagingSenderId: "38557934447",
            appId: "1:38557934447:web:bf253c7b6904b4a9a83e9a",
            measurementId: "G-EVQHFWZEVV"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging.isSupported() ? firebase.messaging() : null;

        function initFirebaseMessagingRegistration() {
            messaging.requestPermission().then(function() {
                return messaging.getToken()
            }).then(function(token) {
                console.log(token);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route('save-token') }}',
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        token: token
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        alert('Token saved successfully.');
                    },
                    error: function(err) {
                        console.log('User Chat Token Error' + err);
                    },
                });
            }).catch(function(err) {
                console.log('User Chat Token Error' + err);
            });
        }

        messaging.onMessage(function(payload) {
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(noteTitle, noteOptions);
        });
    </script>

    <script>
        $(document).ready(function() {

            $(document).on('click', '.delete_button', function(e) {
                var id = $('#deleteid').val();
                var tr = $(this).attr('data-id');

                $.ajax({
                    method: 'POST',
                    url: "{{ url('admin/notificaiton/delete') }}",
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(data) {
                        alert(data.msg);
                        $('#' + tr).remove();
                        $('#DeletePopup').modal('hide');
                    },
                    error: function(err) {
                        alert('Something went wrong!');
                        console.log(err);
                    }
                });
            });
        });

        function DeleteNotification(id, tr) {
            $('#deleteid').val(id);
            $('.delete_button').attr('data-id', tr);
            $('#DeletePopup').modal('show');
        }
    </script>
@stop
