@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}

                    @foreach(auth()->user()->unreadnotifications as $notification)
                    <div class="bg-blue-300 p-3 m-2">
                        <b>{{$notification->data['name']}} </b>New User Registered !!!
                        <a href="{{route('admin.ReadNotification',$notification->id)}}">Mark as read</a>
                    </div>
                    @endforeach
                </div>
            </div>


            <div class="col-md-8">
                <button onclick="startFCM()" class="btn btn-danger btn-flat">Allow notification
                </button>
                <div class="card mt-3">
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        
                            <a href="{{ route('admin.send.web-notification') }}"><button type="button" class="btn btn-success btn-block">Test Notification</button></a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyA4Ge5dtO15F8mmD5tPIK_V7QspM01qGoQ",
        authDomain: "puch-notification-d468e.firebaseapp.com",
        projectId: "puch-notification-d468e",
        storageBucket: "puch-notification-d468e.appspot.com",
        messagingSenderId: "778819694326",
        appId: "1:778819694326:web:4ad0f3bc62f96d9bc086d7",
        measurementId: "G-8JHSB8KZY2"


    };
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function startFCM() {
        // alert(123);
        messaging
            .requestPermission()
            .then(function() {
                return messaging.getToken()
            })
            .then(function(response) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{ route("admin.store.token") }}',
                    type: 'POST',
                    data: {
                        token: response
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        alert('Token stored.');
                    },
                    error: function(error) {
                        alert(error);
                    },
                });
            }).catch(function(error) {
                alert(error);
            });
    }
    messaging.onMessage(function(payload) {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(title, options);
    });
</script>


@endsection