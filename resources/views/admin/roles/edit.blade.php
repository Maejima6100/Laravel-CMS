<x-admin-master>
@section('content')
    <h1> Roles </h1>   
    <!-- Display Notifications --> 
    @if(Session::has('deleterolemessage'))
    <div class="alert alert-danger"> {{Session::get('deleterolemessage')}} </div>
    @elseif(Session::has('createrolemessage'))
    <div class="alert alert-success"> {{session('createrolemessage')}} </div>
    @elseif(Session::has('updatemessage'))
    <div class="alert alert-success"> {{session('updatemessage')}} </div>
    @endif
<div class="row">    
    <!-- Create new role form --> 
    <div class="card shadow mb-4 col-md-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Role id#{{$role->id}}</h6>
        </div>
            <div class="card-body">
                <form action="{{route('roles.update',$role->id)}}" method="post">
                @csrf
                @method('PATCH')
                    <div class="form-group">
                        <label for="title">Role Name</label>
                        <input type="text" class="form-control" name="name" value="{{$role->name}}" required>
                    </div>
                    <label for="" class="font-weight-bold text-primary">Assigned Permissions</label>
                    <div class="form-group">
                        @foreach($permissions=App\Models\Permission::all() as $permission)
                        <label for="permission{{$permission->id}}">{{$permission->name}}</label>
                        <input type="checkbox" name="permission{{$permission->id}}" value="{{$permission->id}}"
                            @foreach($role->permissions as $assigned)
                                @if($assigned->id == $permission->id)
                                checked
                                @endif
                            @endforeach    
                        >
                        <br>
                        @endforeach
                    </div>
                    <input type="submit" class="btn btn-primary" value="Update Role">
                </form>
            </div>
    </div>
</div>
@endsection
</x-admin-master>