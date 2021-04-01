@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.msgflash')
            
            @foreach ($images as $image )               
                @include('includes.image',['image'=>$image])
            @endforeach
           
        </div>

    </div>
    <div class="row justify-content-center">

        {{-- Paginación --}}
        {{$images->links()}}
    </div>
</div>
@endsection
