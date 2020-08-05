<form method="post" action="{{ route('review-store') }}">
@csrf

    <div class="row">
        <div class="form-group col-6">
        <label for="name">Name</label>
            <input class="form-control" name="name"  type="text" value="{{ auth()->user()->name }}" id="name" disabled>
        </div>
        <div class="form-group col-6">
        <label for="email">Email</label>
            <input class="form-control" name="email"  type="text" value="{{ auth()->user()->email }}" id="email" disabled>
        </div>
    </div>

    <div class="form-group ">
    <label for="Package">Package</label>
        <select name="users_has_packages_id" class=form-control id="users_has_packages_id">
             @foreach($subscription as $package)
            <option value="{{$package->users_has_packages_id}}">{{$package->name}}</option>
                @endforeach       
        </select>
    </div>
    <div class="form-group ">
    <label for="review">Review</label>
        <input class="form-control" name="review"  type="text" value="" placeholder="Required" id="review">
    </div>
   
    <div class="form-group ">
    <label for="star">Star</label>
    
    <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="star" id="inlineRadio1" value="1">
    <label class="form-check-label" for="inlineRadio1">1</label>
    </div>
    <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="star" id="inlineRadio2" value="2">
    <label class="form-check-label" for="inlineRadio2">2</label>
    </div>
    <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="star" id="inlineRadio3" value="3">
    <label class="form-check-label" for="inlineRadio3">3</label>
    </div>
    <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="star" id="inlineRadio4" value="4">
    <label class="form-check-label" for="inlineRadio4">4</label>
    </div>
    <div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="star" id="inlineRadio5" value="5">
    <label class="form-check-label" for="inlineRadio5">5</label>
    </div>

    <!-- <input type="radio" name="star" id=""> -->
    <!-- <textarea id="description" class="form-control" name="description" rows="10" cols="50"></textarea> -->
    </div>

    <!-- <div class="form-group ">
    <label for="attachment">Attachment</label>
        <input class="form-control" name="file"  type="file" value="" id="attachment">
    </div> -->
   
</form>




<script src="{{asset('assets/vendors/stisla/ckeditor/ckeditor.js')}}"></script>
<script>
  var description = document.getElementById("description");
    CKEDITOR.replace(description,{
    language:'en-gb'
  });
  CKEDITOR.config.allowedContent = true;
</script>