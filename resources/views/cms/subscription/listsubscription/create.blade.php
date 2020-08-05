<form method="post" action="{{ route('list-subscription-store') }}">
@csrf

    <div class="form-group ">
    <label for="name">Name</label>
        <input class="form-control" name="name" type="text" value="" id="name" placeholder="Required">
    </div>
    <div class="form-group ">
    <label for="name">Price</label>
    <input class="form-control" name="price" type="text" placeholder="Required" value="" id="price">
    </div>
    <div class="form-group ">
 
   
</form>
