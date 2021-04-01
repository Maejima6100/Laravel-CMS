<x-admin-master>
@section('content')
    <h1> Roles </h1>   

<div class="row">    
    <!-- Create new role form --> 
    <div class="card shadow mb-4 col-md-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Permission id#{{$permission->id}}</h6>
        </div>
            <div class="card-body">
                <form action="{{route('permissions.update',$permission->id)}}" method="post">
                @csrf
                @method('PATCH')
                    <div class="form-group">
                        <label for="title">Permission Name</label>
                        <input type="text" class="form-control" name="name" value="{{$permission->name}}" required>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Update Permission">
                </form>
            </div>
    </div>
</div>
@endsection
</x-admin-master>