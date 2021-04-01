<x-admin-master>
@section('content')
<h1> View All Users </h1>        
    @if(Session::has('deleteusermessage'))
    <div class="alert alert-danger"> {{Session::get('deleteusermessage')}} </div>
    @elseif(Session::has('createmessage'))
    <div class="alert alert-success"> {{session('createmessage')}} </div>
    @elseif(Session::has('updatemessage'))
    <div class="alert alert-success"> {{session('updatemessage')}} </div>
    @endif
    <!-- DataTables -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Users Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>User Id#</th>
                            <th>Avatar</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>User Id#</th>
                            <th>Avatar</th>
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date</th>
                            <th>Delete</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td><img src="{{$user->avatar}}" height="40"></td>
                            <td><a href="{{route('users.profile.edit', $user->id)}}">{{$user->username}}</a></td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                            @foreach($user->roles as $role)
                               {{$role->name}} 
                            @endforeach
                            </td>
                            <td>{{$user->created_at}}</td>
                            <td>
                                <form method="post" action="{{route('users.destroy',$user->id)}}">
                                @csrf
                                @method('DELETE')    
                                <button type="submit" class="btn btn-danger"
                                @if(auth()->user()->id == $user->id)
                                disabled
                                @endif
                                >Delete</button>
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