@extends('_layout.app')
@section('title', 'User Profile')
@section('page_header', 'Profile')
@section('content')

    <div class="card card-primary">
          <div class="row">
              <div class="col-md-4">
                <div class="card">
                  <div class="card-header">
                    <h4>Jump To</h4>
                  </div>
                  <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                      <li class="nav-item"><a href="#" class="nav-link active">General</a></li>
                      <li class="nav-item"><a href="#" class="nav-link">Password</a></li>
                      <li class="nav-item"><a href="#" class="nav-link">Profile Picture</a></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <form id="setting-form" class="form-validate" method="post" action="{{ route('profile-update', auth()->user()->id) }}">
                @csrf

                  <div class="card" id="settings-card">
                    <div class="card-header">
                      <h4>General Settings</h4>
                    </div>
                    <div class="card-body">
                      <p class="text-muted">General settings such as, site title, site description, address and so on.</p>
                      <div class="form-group row align-items-center">
                        <label for="username" class="form-control-label col-sm-3 text-md-right">Username</label>
                        <div class="col-sm-6 col-md-9">
                          <input type="text" value="{{ $user->username }}" name="username" class="form-control" id="username">
                        </div>
                      </div>
                      <div class="form-group row align-items-center">
                        <label for="name" class="form-control-label col-sm-3 text-md-right">Name</label>
                        <div class="col-sm-6 col-md-9">
                          <input type="text" value="{{ $user->name }}" name="name" class="form-control" id="name">
                        </div>
                      </div>
                      <div class="form-group row align-items-center">
                        <label for="oldPassword" class="form-control-label col-sm-3 text-md-right">Current Password</label>
                        <div class="col-sm-6 col-md-9">
                        <input id="password-field" type="password" class="form-control" name="oldPassword" value="">
                        </div>
                      </div>
                      <div class="form-group row align-items-center">
                        <label for="password" class="form-control-label col-sm-3 text-md-right">Password</label>
                        <div class="col-sm-6 col-md-9">
                          <!-- asdsad -->
                          <div class="input-group mb-3">                  
                          <input id="newPassword" type="password" class="form-control password" name="password" value="">
                        <div class="input-group-append">
                          <span class="input-group-text">                        
                          <i class="far fa-eye" onclick="myFunction()"></i>
                          
                        </span>
                        </div>
                      </div>
                          <!-- asds -->
                          <!-- <input type="password" value="" name="password" class="form-control" id="password"> -->
                        </div>
                      </div>
                      <div class="form-group row align-items-center">
                        <label for="passwordConfirmation" class="form-control-label col-sm-3 text-md-right">Confirmation Password</label>
                        <div class="col-sm-6 col-md-9">
                          <input type="password" value="" name="passwordConfirmation" class="form-control" id="passwordConfirmation">
                        </div>
                      </div>
                      <div class="form-group row align-items-center">
                        <label for="email" class="form-control-label col-sm-3 text-md-right">Email</label>
                        <div class="col-sm-6 col-md-9">
                          <input type="email" value="{{ $user->email }}" name="email" class="form-control" id="email">
                        </div>
                      </div>
                      <div class="form-group row align-items-center">
                        <label for="contact_person" class="form-control-label col-sm-3 text-md-right">Contact person</label>
                        <div class="col-sm-6 col-md-9">
                          <input type="contact_person" value="{{ $user->contact_person }}" name="contact_person" class="form-control" id="contact_person">
                        </div>
                      </div>
                      <div class="form-group row align-items-center">
                        <label for="address" class="form-control-label col-sm-3 text-md-right">Address</label>
                        <div class="col-sm-6 col-md-9">
                          <textarea class="form-control" value="{{ $user->address }}" name="address" id="address"></textarea>
                        </div>
                      </div>
                     
                       
                     
                    </div>
                    <div class="card-footer bg-whitesmoke text-md-right">
                      <button class="btn btn-primary" id="save-btn">Save Changes</button>
                      <button class="btn btn-secondary" type="button">Reset</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
        </div>
    </div>

  <script src="{{ asset('js/form-validate.js') }}"></script>
  @push('js')
  <script>
 function myFunction() {
  var pw_ele = document.getElementById("newPassword");
  if (pw_ele.type === "password") {
    pw_ele.type = "text";
  } else {
    pw_ele.type = "password";
  }
}
</script>
@endpush
@endsection