@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 mx-0 col-sm-12 order-2 order-md-1" >

            @foreach ($users as $user )               
                <div class="data-user row mb-4">
                    <div class="col-md-3 col-3">                   
                        @if ($user->image)
                        <div class="container-avatar">
                            <img class=" img-thumbnail rounded-circle" src="{{route('user.avatar',['filename'=>$user->image])}}" alt="avatar">
                        </div>
                        @else
                        <div class="container-avatar">
                            <img class=" img-thumbnail rounded-circle" src="{{ asset('img/no-image.png') }}" alt="avatar">
                        </div>
                        @endif
                    </div>
                    <div class="info col-md-9 col-9">
                        <h1>{{'@'.$user->nick}}</h1>
                        <h2>{{$user->name. ' ' .$user->surname}}</h2>
                        <p>Se unió: {{\FormatTime::LongTimeFilter($user->created_at)}}</p>
                        <div>
                            <a class="ml-2 d-inline-block btn btn-outline-success" href="{{route('user.profile',['user_id'=>$user->id])}}">Ver perfil</a>
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
            @endforeach
           
        </div>

        <div class="col-sm-12 col-md-3 mx-0 order-1 order-md-2">
            <form id="search-user" class="m-auto" action="{{route('user.users')}}" method="get">
                <div class="form-group row justify-content-end">                  
                    <div class="col-8 mx-0 px-0">                        
                        <input type="text" id="search" class="form-control">
                    </div>                    
                    <div class="col-3 mx-0 px-0">
                        <button type="submit" class="btn  btn-outline-info" >
                            <i class="fas fa-search"></i>
                        </button>   
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row justify-content-center">

        {{-- Paginación --}}
        {{$users->links()}}
    </div>
</div>
@endsection