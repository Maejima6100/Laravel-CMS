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
            <h6 class="m-0 font-weight-bold text-primary">Create New Permission</h6>
        </div>
            <div class="card-body">
                <form action="{{route('permissions.store')}}" method="post">
                @csrf
                @method('POST')
                    <div class="form-group">
                        <label for="title">Permission Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Create Permission">
                </form>
            </div>
    </div>



    <!-- Roles Table -->
    <div class="card shadow col-md-10 mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Permissions Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Permission Id#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Role Count</th>
                            <th>Date</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Permission Id#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Role Count</th>
                            <th>Date</th>
                            <th>Delete</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{$permission->id}}</td>
                            <td><a href="{{route('permissions.edit',$permission->id)}}">{{$permission->name}}</a></td>
                            <td>{{$permission->slug}}</td>
                            <td>{{count($permission->roles)}}</td>
                            <td>{{$permission->created_at->format('d/m/Y')}}</td>
                            <td>
                                <form method="post" action="{{route('permissions.destroy',$permission->id)}}">
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