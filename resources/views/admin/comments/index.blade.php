
<x-admin-master>
@section('content')
    <h1> View All Comments </h1>     
    <h5> Includes Nested Comments in Cyan rows </h5>   
    @if(Session::has('deletecommentmessage'))
    <div class="alert alert-danger"> {{Session::get('deletecommentmessage')}} </div>
    @elseif(Session::has('updatecommentmessage'))
    <div class="alert alert-success"> {{session('updatecommentmessage')}} </div>
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
                            <th>Id#</th>
                            <th>By User</th>
                            <th>For Post</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Has nested</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id#</th>
                            <th>By User</th>
                            <th>For Post</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Has nested</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Delete</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach($comments as $comment)
                        <tr>
                            <td>{{$comment->id}}</td>
                            <td>{{$comment->user->name}}</td>
                            <td><a href="{{route('posts.edit' , $comment->post_id)}}">{{$comment->post->title}}</a></td>
                            <td><a href="{{route('comments.edit' , $comment->id)}}">{{Str::limit($comment->body,20,'...')}}</a></td>
                            <td>{{$comment->status}}</td>
                            <td><a href="">{{count($comment->nestedcomments)}}</a></td>
                            <td>{{$comment->created_at}}</td>
                            <td>{{$comment->updated_at}}</td>
                            <td>
                                <form method="post" action="{{route('comments.destroy',$comment->id)}}">
                                @csrf
                                @method('DELETE')    
                                <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @if(count($comment->nestedcomments) > 0)
                            @foreach($comment->nestedcomments as $nestedcomment)
                            <tr style="background-color:lightcyan">
                                <td>{{$nestedcomment->id}}</td>
                                <td>{{$nestedcomment->user->name}}</td>
                                <td><a href="{{route('posts.edit' , $nestedcomment->comment->post_id)}}">{{$nestedcomment->comment->post->title}}</a></td>
                                <td><a href="{{route('nestedcomments.edit' , $nestedcomment->id)}}">{{Str::limit($nestedcomment->body,20,'...')}}</a></td>
                                <td>{{$nestedcomment->status}}</td>
                                <td><a href="">Nested</a></td>
                                <td>{{$nestedcomment->created_at}}</td>
                                <td>{{$nestedcomment->updated_at}}</td>
                                <td>
                                    <form method="post" action="{{route('nestedcomments.destroy',$nestedcomment->id)}}">
                                    @csrf
                                    @method('DELETE')    
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @endif    
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