<x-admin-master>
@section('content')
<div class="col-md-6">
    <h1> Edit Comment id#{{$comment->id}}</h1>
    <form action="{{route('comments.update', $comment->id)}}" method="post" >
    @csrf
    @method('PATCH')
        <div class="form-group">
            <label for="body">Comment</label>
            <textarea class="form-control {{$errors->has('body') ? 'is-invalid' : ''}}" name="body" cols="30" rows="6">{{$comment->body}}</textarea>
            @error('body')
                <div class="invalid-feedback">{{$message}}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control">
                <option class="form-control" value="Approved" {{($comment->status == 'Approved') ? 'selected' : ''}}>Approved</option>
                <option class="form-control" value="Unapproved" {{($comment->status == 'Unapproved') ? 'selected' : ''}}>Unapproved</option>
            </select>
        </div>
        <input type="submit" class="btn btn-primary" value="Update Comment">
    </form>
</div>

@endsection
</x-admin-master>