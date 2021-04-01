<x-admin-master>
@section('content')

<div class="col-md-6">
    <h1>Profile for User id#{{$user->id}}</h1>

    @if(Session::has('updateusermessage'))
    <div class="alert alert-success"> {{session('updateusermessage')}} </div>
    @endif

    <form action="{{route('users.profile.update', $user->id)}}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control {{$errors->has('username') ? 'is-invalid' : ''}}" name="username" value="{{$user->username}}">
        @error('username')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
        </div>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control {{$errors->has('name') ? 'is-invalid' : ''}}" name="name" value="{{$user->name}}">
        @error('name')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}" name="email" value="{{$user->email}}">
        @error('email')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" name="password" value="{{$user->password}}">
        @error('password')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Password Confirmation</label>
            <input type="password" class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}" name="password_confirmation" value="{{$user->password}}">
        @error('password')
        <div class="invalid-feedback">{{$message}}</div>
        @enderror
        </div>
        <div class="form-group">
            <label for="role_id">Role</label>
            <select class="form-control" name="role_id">
                @foreach($roles as $role)
                <option class="form-control" value="{{$role->id}}" {{($role->id == $user->role_id)?'selected':''}}>{{$role->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="post_image">Avatar</label>
            <input type="file" class="form-control" name="avatar">
        </div>
        <div class="form-group">
            <label for="current-image">Current Avatar</label>
            <img style="display:block" id="current-image" src="{{$user->avatar}}" height="90">
        </div>
        <input type="submit" class="btn btn-primary" value="Update User Settings">
    </form>
</div>

 @endsection
</x-admin-master>