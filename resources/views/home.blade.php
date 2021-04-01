

<x-home-master>
@section('content')

<h1 class="my-4">Page Heading
          <small>Secondary Text</small>
        </h1>

        @foreach($posts as $post)
        <!-- Blog Post -->
        <div class="card mb-4">
          <img class="card-img-top" src="{{$post->post_image}}" alt="Card image cap">
          <div class="card-body">
            <h2 class="card-title">{{$post->title}}</h2>
            <p class="card-text">{{Str::limit($post->body,90,'.....')}}</p>
            <a href="{{route('post', $post->id)}}" class="btn btn-primary">Read More &rarr;</a>
          </div>
          <div class="card-footer text-muted">
            Posted on {{$post->created_at}} by
            <a href="{{route('userposts', $post->user_id)}}">{{$post->user->name}}</a>
          </div>
        </div>

        @endforeach

        <!-- Pagination -->

        {{$posts->links('pagination::bootstrap-4')}}

@endsection
</x-home-master>
