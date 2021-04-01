@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card mb-2">
                @include('includes.msgflash')
                    
                <div class="card-header d-flex justify-content-between">
                    <div class="d-inline-block">
                        <a class="link_plane" href="{{route('user.profile',['user_id'=> $image->user_id])}}">
                        @if ($image->user->image)
                            <img class="rounded " width="35px" src="{{ route('user.avatar', ['filename'=>$image->user->image]) }}" alt="avatar">
                        @endif
                        </a>
                        <span class=" ml-1 d-inline-block">{{'@'.$image->user->nick}}</span>
                    </div> 
                    <span class="d-inline-block text-secondary text-left">
                        {{$image->created_at}}
                        
                        
                    </span>
                </div>  

                <div class="card-body">       
                    <img 
                        style="width: 100%"
                        class="rounded img-fluid" 
                        src="{{ route('image.file', ['filename'=>$image->image_path]) }}" 
                        alt="{{$image->description}}"
                    >
                </div>

                <div class="card-footer">
                        
                    @if (VerifyLike::verify($image->likes,Auth::user()->id))
                        <a class="interactive_action" style="color: rgb(187, 81, 81)" href="{{route('like.like',['id'=>$image->id])}}"><i class="fas fa-heart" data-target="{{$image->id}}"></i><span> {{count($image->likes)}}</span></a>&nbsp;&nbsp;
                    @else
                        <a class="interactive_action" style="color: rgb(187, 81, 81)" href="{{route('like.like',['id'=>$image->id])}}"><i class="far fa-heart" data-target="{{$image->id}}"></i><span> {{count($image->likes)}}</span></a>&nbsp;&nbsp;
                    @endif
                    
                    
                    <i class="far fa-comment-dots"></i> {{count($image->comments)}}

                    {{-- Edit and Delete buttons --}}                  
                    @if ($image->user->id==Auth::user()->id)
                                                                  
                        <a href="{{route('image.edit',['image_id'=>$image->id])}}" class="ml-2 mb-1 text-primary close">
                            <span aria-hidden="true"><i class="far fa-edit"></i></span>
                        </a> 
                        
                        <!-- Button trigger modal -->
                        <button type="button" class="ml-2 mb-1 text-danger close" data-toggle="modal" data-target="#deleteModal">
                            <i class="far fa-trash-alt"></i>
                        </button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Atención</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    Está seguro que desea eliminar esta imagen
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                
                                <a href="{{route('image.delete',['image_id'=>$image->id])}}" class="btn btn-danger">
                                    <span aria-hidden="true">Borrar</span>
                                </a> 
                                </div>
                            </div>
                            </div>
                        </div>
  
                    @endif
                
                </div>

                <div class="comments">
                    <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;scroll-behavior: smooth;overflow: auto;">                        
                        <div style="position: absolute; top: 5px; right: 10px;">
                    
                    
                            <div class="custom-scroll toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
                                <div class="toast-header">
                                    <img src="{{route('user.avatar',['filename'=> $image->user->image])}}" class="rounded mr-2" alt="avatar" style="width: 10%">
                                    <strong class="mr-auto">{{'@'.$image->user->nick}}</strong>
                                    <small class="text-muted">{{\FormatTime::LongTimeFilter($image->created_at)}}</small>
                                </div>
                                
                                <div class="toast-body">
                                    {{$image->description}}                           
                                </div>
                            </div>
                        
                            @foreach ( $image->comments as $index => $comment)
                                <div class="custom-scroll toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false">
                                    <div class="toast-header">
                                        <img src="{{route('user.avatar',['filename'=> $comment->user->image])}}" class="rounded mr-2" alt="avatar" style="width: 10%">
                                        <strong class="mr-auto">{{'@'.$comment->user->nick}}</strong>
                                        <small class="text-muted">{{\FormatTime::LongTimeFilter($comment->created_at)}}</small>
                                       
                                        @if ($comment->user->id==Auth::user()->id)
                                            <!-- Button trigger modal -->
                                            <button type="button" class="ml-2 mb-1  close" data-toggle="modal" data-target="#commentModal">
                                                </i><span aria-hidden="true">&times;</span>
                                            </button>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="commentModalLabel">Atención</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Está seguro que desea eliminar este comentario
                                                    </div>
                                                    <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    
                                                    <a href="{{route('comment.delete',['id'=>$comment->id])}}" class="btn btn-danger">
                                                        <span aria-hidden="true">Borrar</span>
                                                    </a> 
                                                    </div>
                                                </div>
                                                </div>
                                            </div>

                                                                                      
                                        @endif

                                    </div>
                                    <div class="toast-body">
                                        {{$comment->content}}
                                    </div>
                                </div>
                            @endforeach 
                            
                            
                        </div>
                    </div>
                    
                </div>
                <form method="POST" action="{{route('comment.create')}}">
                    @csrf
                    <div class="input-group">
                        <input type="hidden" name="image_id" value="{{$image->id}}" >
                        <input type="text" name="content" class="form-control" placeholder="Deja tu comentario" >
                        <div class="input-group-append">
                          <button class="btn btn-outline-primary" type="submit" id="button-addon2">Comenta</button>
                        </div>
                    </div>

                </form>
                    
            </div> 
        </div>
    </div>
</div>
<div class="scroll-end">

</div>
@endsection

@push('scripts')
<script type="text/javascript">
    window.onload = () => {
        var objDiv = document.querySelector(".custom-scroll:last-child");
        objDiv.scrollTop = objDiv.scrollIntoView({ behavior: "smooth", block: "end" });

        var objDiv = document.querySelector(".scroll-end");
        objDiv.scrollTop = objDiv.scrollIntoView({ behavior: "smooth", block: "end" });
    }
</script>
@endpush