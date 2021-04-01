<x-admin-master>
@section('content')
    <h1> Roles </h1>   
    <!-- Display Notifications --> 
    @if(Session::has('deleterolemessage'))
    <div class="alert alert-danger"> {{Session::get('deleterolemessage')}} </div>
    @elseif(Session::has('createrolemessage'))
    <div class="alert alert-success"> {{session('createrolemessage')}} </div>
    @elseif(Session::has('updaterolemessage'))
    <div class="alert alert-success"> {{session('updaterolemessage')}} </div>
    @endif
<div class="row">    
    <!-- Create new role form --> 
    <div class="card shadow mb-4 col-md-2">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Create New Role</h6>
        </div>
            <div class="card-body">
                <form action="{{route('roles.store')}}" method="post">
                @csrf
                @method('POST')
                    <div class="form-group">
                        <label for="title">Role Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <label for="" class="font-weight-bold text-primary" >Assign Permissions</label>
                    <div class="form-group">
                        @foreach($permissions=App\Models\Permission::all() as $permission)
                        <label for="permission{{$permission->id}}">{{$permission->name}}</label>
                        <input type="checkbox" name="permission{{$permission->id}}" value="{{$permission->id}}">
                        <br>
                        @endforeach
                    </div>
                    <input type="submit" class="btn btn-primary" value="Create Role">
                </form>
            </div>
    </div>



    <!-- Roles Table -->
    <div class="card shadow col-md-10 mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Roles Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Role Id#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Permissions</th>
                            <th>Count</th>
                            <th>Date</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Role Id#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Permissions</th>
                            <th>Count</th>
                            <th>Date</th>
                            <th>Delete</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td><a href="{{route('roles.edit',$role->id)}}">{{$role->name}}</a></td>
                            <td>{{$role->slug}}</td>
                            <td>
                            @foreach($role->permissions as $permission)
                            # {{$permission->name}}
                            @endforeach
                            </td>
                            <td>{{count($role->users)}}</td>
                            <td>{{$role->created_at->format('d/m/Y')}}</td>
                            <td>
                                <form method="post" action="{{route('roles.destroy',$role->id)}}">
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