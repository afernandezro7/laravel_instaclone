@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="data-user row mb-4">
                <div class="col-md-3">                   
                    @if ($user->image)
                    <div class="container-avatar">
                        <img class=" img-thumbnail rounded-circle" src="{{route('user.avatar',['filename'=>$user->image])}}" alt="avatar">
                    </div>
                    @endif
                </div>
                <div class="info col-md-9">
                    <h1>{{'@'.$user->nick}}</h1>
                    <h2>{{$user->name. ' ' .$user->surname}}</h2>
                    <p>Se unió: {{\FormatTime::LongTimeFilter($user->created_at)}}</p>
                </div>
            </div>
            <hr class="mb-4">
            @foreach ($user->images as $image )
                @include('includes.image',['image'=>$image])              
            @endforeach         
        </div>

    </div>
</div>
@endsection
