<form method="post" action="{{ route('billing-update', $data->id) }}">
@csrf
    <div class="form-group ">
    <label for="name">Username</label>
        <input class="form-control" name="username" type="text" placeholder="Required" value="{{$data->username}}" id="username">
    </div>

    <div class="form-group ">
    <label for="name">Name</label>
        <input class="form-control" name="name" type="text" value="{{$data->name}}" id="name">
    </div>
    <div class="form-group ">
    <label for="name">Email</label>
        <input class="form-control" name="email" type="email" value="{{$data->email}}" id="email">
    </div>
    <div class="form-group ">
    <label for="name">Contact Person</label>
        <input class="form-control" name="contact_person" type="text" placeholder="Required" value="{{$data->contact_person}}" id="contact_person">
    </div>
    <div class="form-group ">
    <label for="name">Password</label>
        <input class="form-control" name="password" type="password" value="{{$data->password}}" id="password">
    </div>
    <div class="form-group ">
    <label for="name">Address</label>
        <textarea class="form-control" name="address" placeholder="Required">{{$data->address}}</textarea>

    </div>
    <div class="form-group ">
        <label for="name">Status</label>
        <input type="text" class="form-control">
    </div>
</form>
