<form method="post" action="{{ route('all-router-store') }}">
@csrf
    <div class="form-group ">
    <label for="router_name">Router Name</label>
        <input class="form-control" name="router_name" type="text" placeholder="Required" value="" id="router_name">
    </div>

    <div class="form-group ">
    <label for="host">Host</label>
        <input class="form-control" name="host" type="text" value="" id="host">
    </div>
    <div class="form-group ">
    <label for="port">Port</label>
        <input class="form-control" name="port" type="number" value="" id="port">
    </div>
    <div class="form-group ">
    <label for="user">User</label>
    <input class="form-control" name="user" type="text" placeholder="Required" value="" id="user">
    </div>
    <div class="form-group ">
    <label for="password">Password</label>
        <input class="form-control" name="password" type="password" value="" id="password">
    </div>
    <div class="form-group ">
    <label for="name">Address</label>
        <textarea class="form-control" name="address" placeholder="Required"></textarea>

    </div>
    <div class="form-group ">
    <label for="coordinate">Coordinate</label>
    <input class="form-control" name="coordinate" type="text" placeholder="" value="" id="coordinate">

    </div>
   
</form>
