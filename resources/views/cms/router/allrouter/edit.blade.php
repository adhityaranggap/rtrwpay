<form method="post" action="{{ route('all-router-update',  $data->id) }}">
@csrf
    <div class="form-group ">
    <label for="router_name">Router Name</label>
        <input class="form-control" name="router_name" type="text" placeholder="Required" value="{{$data->router_name}}" id="router_name">
    </div>

    <div class="form-group ">
    <label for="host">Host</label>
        <input class="form-control" name="host" type="text" value="{{$data->host}}" id="host">
    </div>
    <div class="form-group ">
    <label for="port">Port</label>
        <input class="form-control" name="port" type="integer" value="{{$data->port}}" id="port">
    </div>
    <div class="form-group ">
    <label for="user">User</label>
    <input class="form-control" name="user" type="text" placeholder="Required" value="{{$data->user}}" id="user">
    </div>
    <div class="form-group ">
    <label for="password">Password</label>
        <input class="form-control" name="password" type="password" placeholder="Required" value="" id="password">
    </div>
    <div class="form-group ">
    <label for="name">Address</label>
    <input class="form-control" name="address" type="text" placeholder="" value="{{$data->address}}" id="address">

    </div>
    <div class="form-group ">
    <label for="coordinate">Coordinate</label>
    <input class="form-control" name="coordinate" type="text" placeholder="" value="{{$data->coordinate}}" id="coordinate">

    </div>
   
</form>
