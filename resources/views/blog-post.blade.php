<x-home-master>

@section('content')
      <!-- Updating the Post Views -->
      @php
      $post->views++;
      $post->save();
      @endphp


      <!-- Post Content Column -->
      <div class="col-lg-10">

        <!-- Title -->
        <h1 class="mt-4">{{$post->title}}</h1>

        <!-- Author -->
        <p class="lead"> by <a href="{{route('userposts', $post->user->id)}}">{{$user}} </a> </p>
        <hr>

        <!-- Date/Time -->
        <p>Posted on {{$post->created_at}}</p>
        <hr>

        <!-- Preview Image -->
        <img class="img-fluid rounded" src="{{$post->post_image}}" alt="" style="max-height:600px">
        <hr>

        <!-- Post Content -->
        <p class="lead">{{$post->body}} </p>
        <hr>
        <p style="color:darkgrey;display:inline-block">Likes: {{count($post->likes)}} </p>
        @if(Auth::check())
          <a class="float-right" href="{{route('like.create',$post->id)}}">{{auth()->user()->userHasLiked($post) ? 'Unlike' : 'Like'}}</a>
        @endif
        <hr>

        <!-- Comments -->
        @if(Auth::check())
          <!-- Comments Form -->
          <div class="card my-3">
            <h5 class="card-header">Leave a Comment:</h5>
            <div class="card-body">
              <form action="{{route('comment.store',$post->id)}}" method="post">
              @csrf
                <div class="form-group">
                  <textarea class="form-control" rows="3" name="body"></textarea>
                </div>
                <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                @if(Session::has('submitcommentmessage'))
                  <div class="alert alert-success ml-4" style="display:inline-block;line-height:0.85em"> {{session('submitcommentmessage')}} </div>
                @endif
                </div>
              </form>
            </div>
          </div>
        @endif

        @if(count($post->comments) > 0)
          @foreach($post->comments as $comment)
          @if($comment->status == 'Approved')
          <!-- Single Comment -->
          <div class="media mb-4">
            <img class="d-flex mr-3 rounded-circle" src="{{$comment->user->avatar}}" height="50px">
            <div class="media-body">
              <h5 class="mt-0 mb-0">{{$comment->user->name}}</h5> <p><small style="color:darkgrey"> {{$comment->created_at}}</small></p>
              <p class="mt-0 mb-3">{{$comment->body}}</p>
              
              @if(Auth::check())
                <!-- Nested Comment Form -->
                <form action="{{route('nestedcomment.store', $comment->id)}}" method="post">
                  @csrf
                  <div class="form-group">
                    <textarea class="form-control" rows="1" name="body"></textarea>
                    <input type="submit" class="btn btn-primary btn-sm mt-2" value="Comment">
                  </div>
                </form>
              @endif
              
              <!--Nested comment-->
              @if(count($comment->nestedcomments) > 0)
                @foreach($comment->nestedcomments as $nestedcomment)
                @if($nestedcomment->status == 'Approved')
                <div class="media mb-4">
                  <img class="d-flex mr-3 rounded-circle" src="{{$nestedcomment->user->avatar}}" height="50px">
                  <div class="media-body">
                    <h5 class="mt-0 mb-0">{{$nestedcomment->user->name}}</h5> <p><small style="color:darkgrey"> {{$nestedcomment->created_at}}</small></p>
                    <p class="mt-0 mb-3">{{$nestedcomment->body}}</p>
                  </div>
                </div>
                @endif
                @endforeach
              @endif 
            </div>
          </div>
          @endif  
          @endforeach
        @endif  
        <hr>

      </div>

@endsection

</x-home-master>