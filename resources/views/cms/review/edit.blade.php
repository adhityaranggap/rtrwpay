<form method="post" action="{{ route('list-subscription-update', $data->id) }}">
@csrf

    <div class="form-group ">
    <label for="name">Name</label>
        <input class="form-control" name="name" type="text" value="{{$data->name}}" id="name">
    </div>
    <div class="form-group ">
    <label for="name">Speed</label>
        <input class="form-control" name="speed" type="speed" value="{{$data->speed}}" id="speed">
    </div>
    <div class="form-group ">
    <label for="name">Price</label>
        <input class="form-control" name="price" type="text" placeholder="Required" value="{{$data->price}}" id="price">
    </div>
</form>


