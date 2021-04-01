
<x-admin-master>
@section('content')
    <h1> View All Posts </h1>        
    @if(Session::has('deletemessage'))
    <div class="alert alert-danger"> {{Session::get('deletemessage')}} </div>
    @elseif(Session::has('createmessage'))
    <div class="alert alert-success"> {{session('createmessage')}} </div>
    @elseif(Session::has('updatemessage'))
    <div class="alert alert-success"> {{session('updatemessage')}} </div>
    @endif
    <!-- DataTables -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Posts Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Post Id#</th>
                            <th>By User</th>
                            <th>Title</th>
                            <th>Body</th>
                            <th>Image</th>
                            <th>Comments</th>
                            <th>Views</th>
                            <th>Likes</th>
                            <th>Date</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Post Id#</th>
                            <th>By User</th>
                            <th>Title</th>
                            <th>Body</th>
                            <th>Image</th>
                            <th>Comments</th>
                            <th>Views</th>
                            <th>Likes</th>
                            <th>Date</th>
                            <th>Delete</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td>{{$post->id}}</td>
                            <td>{{$post->user->name}}</td>
                            <td><a href="{{route('posts.edit',$post->id)}}">{{$post->title}}</a></td>
                            <td>{{Str::limit($post->body,20,'...')}}</td>
                            <td><img src="{{$post->post_image}}" height="50"></td>
                            <td>
                            @php
                            $count = count($post->comments);
                            foreach($post->comments as $comment){
                                $count = $count + count($comment->nestedcomments);
                            }
                            @endphp
                            <a href="">{{$count}}</a>
                            </td>
                            <td><a onclick="return confirm('You really want to reset the post views ?');" href="{{route('post.viewsdelete', $post->id)}}">{{$post->views}}</a></td>
                            <td>{{count($post->likes)}}</td>
                            <td>{{$post->created_at}}</td>
                            <td>
                                <form method="post" action="{{route('posts.destroy',$post->id)}}">
                                @csrf
                                @method('DELETE')    
                                <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
  <!-- Page level plugins -->
  <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <!-- Page level custom scripts -->
  <script src="{{asset('js/demo/datatables-demo.js')}}"></script>
@endsection

</x-admin-master>