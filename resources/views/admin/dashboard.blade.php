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
        </div>
    </div>
</div>
@endsection