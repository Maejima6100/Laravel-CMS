<x-admin-master>
@section('content')
<div class="col-md-6">
    <h1> Edit Post </h1>
    <form action="{{route('posts.update', $post->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
        <div class="form-group">
            <label for="title">Post Title</label>
            <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}" name="title" value="{{$post->title}}">
            @error('title')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="body">Post Content</label>
            <textarea class="form-control {{$errors->has('body') ? 'is-invalid' : ''}}" name="body" cols="30" rows="6">{{$post->body}}</textarea>
            @error('body')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="post_image">Post Image</label>
            <input type="file" class="form-control" name="post_image">
        </div>
        <div class="form-group">
            <label for="current-image">Current Image</label>
            <img style="display:block" id="curremt-image" src="{{$post->post_image}}" height="90">
        </div>
        <input type="submit" class="btn btn-primary" value="Update Post">
    </form>
</div>

@endsection
</x-admin-master>