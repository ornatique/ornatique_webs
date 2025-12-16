@extends('admin.template')
@section('main')
    {{-- <div class="container"> --}}
    @if (session('msg'))
        Notification Send
    @endif
    <div class="row justify-content-start">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()"
                        class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form action="{{ route('send.notification') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control" name="body"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Notification</button>
                    </form>

                </div>
            </div>
            {{-- </div> --}}
        </div>
    </div>
    <script src="{{ asset('public/assets/admin/libs/jquery/jquery.min.js') }}"></script>

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
        const messaging = firebase.messaging();

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
    {{-- <script>
        const firebaseConfig = {
            apiKey: "AIzaSyBk55n64hvMv0C8IHlfKnqcAy5jXe4LBnU",
            authDomain: "golden-b7fb0.firebaseapp.com",
            projectId: "golden-b7fb0",
            storageBucket: "golden-b7fb0.appspot.com",
            messagingSenderId: "38557934447",
            appId: "1:38557934447:web:bf253c7b6904b4a9a83e9a",
            measurementId: "G-EVQHFWZEVV"
        };

        // import {
        //     getMessaging,
        //     getToken
        // } from "firebase/messaging";

        // Get registration token. Initially this makes a network call, once retrieved
        // subsequent calls to getToken will return from cache.
        if ("serviceWorker" in navigator) {
            window.addEventListener("load", function() {
                // navigator.serviceWorker.register("/flutter_service_worker.js");
                navigator.serviceWorker.register("/firebase-messaging-sw.js");
            });
        }

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        // alert(messaging);
        // getToken(messaging, {
        //     vapidKey: 'BPvdKB5sL7PMnBadBMwOWwLcUvCGsJXZ4CMFOINbA9MRvzaGr7U7uXIvyhs8igF_rk54_ipFoQyNoO6jDSHcMzw'
        // }).then((currentToken) => {
        Notification.requestPermission().then((permission) => {
            if (permission === 'granted') {
                console.log('Notification permission granted.');
            }
        })
        var currentToken = messaging.getToken({
            vapidKey: "BPvdKB5sL7PMnBadBMwOWwLcUvCGsJXZ4CMFOINbA9MRvzaGr7U7uXIvyhs8igF_rk54_ipFoQyNoO6jDSHcMzw"
        });

        if (currentToken) {
            // Send the token to your server and update the UI if necessary
            // ...
            alert(currentToken);
        } else {
            // Show permission request UI
            console.log('No registration token available. Request permission to generate one.');
            // ...
        }


        // }).catch((err) => {
        //     console.log('An error occurred while retrieving token. ', err);
        //     // ...
        // });

        function initFirebaseMessagingRegistration() {
            messaging
                .requestPermission()
                .then(function() {
                    return messaging.getToken()
                })
                .then(function(token) {
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
    </script> --}}
@endsection
