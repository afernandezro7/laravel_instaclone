@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Editar Imagen</div>

                @include('includes.msgflash')

                <div class="card-body">
                    <form method="POST" action="{{ route('image.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            @if ($image->image_path)
                                <div class="avatar">
                                    <img class="rounded mx-auto d-block" src="{{ route('image.file', ['filename'=>$image->image_path]) }}" alt="{{$image->description}}">
                                </div>
                            @endif
                        </div>

                        <div class="form-group row">

                            <label for="image_path" class="col-md-4 col-form-label text-md-right">{{ __('Imagen') }}</label>

                            <div class="col-md-6">
                                <input id="image_path_file" type="file" max-file-size="1024" class="form-control{{ $errors->has('image_path') ? ' is-invalid' : '' }}" name="image_path" >

                                @if ($errors->has('image_path'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image_path') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Descripción</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control" name="description" required autofocus>{{$image->description}}</textarea>
                            </div>

                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>

                        <input type="hidden" name="image_id" value="{{$image->id}}">
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Editar Imagen
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-script')

@endsection

@push('scripts')
<script>
    window.onload = () => {

        var uploadField = document.getElementById("image_path_file");
    
        uploadField.addEventListener('change', function (e) {
            if(this.files[0].size > 7097152){
                alert("El archivo es muy grande!");
                this.value = "";           
            };
        })
    }
</script>
@endpush