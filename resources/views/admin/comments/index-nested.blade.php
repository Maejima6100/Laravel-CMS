
<x-admin-master>
@section('content')
    <h1> View All Nested Comments </h1>        
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
                            <th>Response to comment</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Id#</th>
                            <th>By User</th>
                            <th>Response to comment</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Delete</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach($comments as $comment)
                        <tr>
                            <td>{{$comment->id}}</td>
                            <td>{{$comment->user->name}}</td>
                            <td><a href="{{route('comments.edit' , $comment->comment_id)}}">{{Str::limit($comment->comment->body,20,'...')}}</a></td>
                            <td><a href="{{route('nestedcomments.edit' , $comment->id)}}">{{Str::limit($comment->body,20,'...')}}</a></td>
                            <td>{{$comment->status}}</td>
                            <td>{{$comment->created_at}}</td>
                            <td>
                                <form method="post" action="{{route('nestedcomments.destroy',$comment->id)}}">
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