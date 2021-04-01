<div class="card mb-2">
                    
    <div class="card-header d-flex justify-content-between">
        <div class="d-inline-block">
            <a class="link_plane" href="{{route('user.profile',['user_id'=> $image->user_id])}}">
            @if ($image->user->image)
                <img class="rounded " width="35px" src="{{ route('user.avatar', ['filename'=>$image->user->image]) }}" alt="avatar">
            @endif
            <span class=" ml-1 d-inline-block">{{'@'.$image->user->nick}}</span>
            </a>
        </div> 
        <span class="d-inline-block text-secondary text-left">{{\FormatTime::LongTimeFilter($image->created_at)}}</span>
    </div>   

    <div class="card-body">   
        <a href="{{route('image.detail', ['id'=> $image->id ])}}">    
            <img 
                class="rounded img-fluid" 
                src="{{ route('image.file', ['filename'=>$image->image_path]) }}" 
                alt="{{$image->description}}"
            >
        </a>   
        <div class="description">
            <a class="link_plane" href="{{route('user.profile',['user_id'=> $image->user_id])}}">
                <span class=" badge badge-primary"><strong>{{'@'.$image->user->nick}}</strong></span>&nbsp;<span>{{$image->description}}</span>
            </a>    
        </div>
    </div>
    <div class="card-footer">
       
        @if (VerifyLike::verify($image->likes,Auth::user()->id))
            <a class="interactive_action" style="color: rgb(187, 81, 81)" href="{{route('like.like',['id'=>$image->id])}}"><i class="fas fa-heart" data-target="{{$image->id}}"></i><span> {{count($image->likes)}}</span></a>&nbsp;&nbsp;
        @else
            <a class="interactive_action" style="color: rgb(187, 81, 81)" href="{{route('like.like',['id'=>$image->id])}}"><i class="far fa-heart" data-target="{{$image->id}}"></i><span> {{count($image->likes)}}</span></a>&nbsp;&nbsp;
        @endif
        
        <a class="interactive_comments" href="{{route('image.detail', ['id'=> $image->id ])}}"><i class="far fa-comment-dots"></i> {{count($image->comments)}}</a>
    </div>
    
</div>