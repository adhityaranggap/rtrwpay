<div class="x_panel">
    <div class="x_title">
    <h2>Form ::  {{ strpos(Route::currentRouteName(), 'create') == true ? 'Create New '.$navTitle : (' '.$data->name)}} </h2>        <div class="clearfix"></div>        
    </div>
    <!-- Content Here -->    
    <br>

    @if(strpos(Route::currentRouteName(), 'create'))
        <form method="POST" action="{{ route('setting-user-store') }}"class="form-horizontal form-label-left">
    @elseif(strpos(Route::currentRouteName(), 'edit'))
        <form method="POST" action="{{ route('setting-user-update', $data->id) }}"class="form-horizontal form-label-left">
    @endif
        @csrf
        <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
            <label class="control-label col-md-2 col-sm-2 col-xs-12 ">
                <div class="float-right">    
                    <b>User Name</b> <span class="required" style="color:#f22;">*</span>
                </div>
            </label>        
     
            <div class="col-md-10 col-sm-10 col-xs-12 ">
                <input type="text" class="form-control" placeholder="Input Group Name" name="name" value="{{old('name', empty($data->name) == true ? '' : $data->name)}}" maxlength="255" required >
                @if ($errors->has('name'))
                    <div class="text-danger">
                    <p>{{ $errors->first('name')}}</p>
                    </div>
                @endif
            </div>                
        </div>

        <div class="form-group row {{ $errors->has('email') ? 'has-error' : '' }}">
            <label class="control-label col-md-2 col-sm-2 col-xs-12 ">
                <div class="float-right">    
                    <b>Mail Address</b> <span class="required" style="color:#f22;">*</span>
                </div>
            </label>                
            <div class="col-md-10 col-sm-10 col-xs-12 ">
                <input type="email" class="form-control" placeholder="Input email" name="email" value="{{old('email',  empty($data->email) == true ? '' : $data->email)}}" maxlength="100" required >
                @if ($errors->has('email'))
                    <div class="text-danger">
                    <p>{{ $errors->first('email')}}</p>
                    </div>
                @endif
            </div>                
        </div>

        <div class="form-group row {{ $errors->has('username') ? 'has-error' : '' }}">
            <label class="control-label col-md-2 col-sm-2 col-xs-12 ">
                <div class="float-right">    
                    <b>User ID</b> <span class="required" style="color:#f22;">*</span>
                </div>
            </label>                
            <div class="col-md-10 col-sm-10 col-xs-12 ">
                <input type="text" class="form-control" placeholder="Input Group User ID" name="username" value="{{old('username', empty($data->username) == true ? '' : $data->username)}}" maxlength="100" required >
                @if ($errors->has('username'))
                    <div class="text-danger">
                    <p>{{ $errors->first('username')}}</p>
                    </div>
                @endif
            </div>                
        </div>

        @if(strpos(Route::currentRouteName(), 'create'))
            <div class="form-group row {{ $errors->has('name') ? 'has-error' : '' }}">
                <label class="control-label col-md-2 col-sm-2 col-xs-12 ">
                    <div class="float-right">    
                        <b>Password</b> <span class="required" style="color:#f22;">*</span>
                    </div>
                </label>                
                <div class="col-md-10 col-sm-10 col-xs-12 ">
                    <input type="text" class="form-control" placeholder="Input Group Name" name="password" maxlength="100" required >
                    @if ($errors->has('password'))
                        <div class="text-danger">
                        <p>{{ $errors->first('password')}}</p>
                        </div>
                    @endif
                </div>                
            </div>
        @endif

        <div class="form-group row {{ $errors->has('user') ? 'has-error' : '' }}">
            <label class="control-label col-md-2 col-sm-2 col-xs-12 ">
                <div class="float-right">    
                    <b>User Groups</b>
                </div>
            </label>                
            <div class="col-md-10 col-sm-10 col-xs-12 ">
                <select name="rule" class="form-control" required>
                @if(strpos(Route::currentRouteName(), 'create'))
                    <option value="" selected hidden>-- Choose Role --</option>
                    @foreach($data as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                @elseif(strpos(Route::currentRouteName(), 'edit'))
                    @foreach($data->userGroups as $group)
                        <option value="{{ $group->id }}" {{ $group->id === $data->rule_id ? 'selected' : '' }} >{{ $group ->name }}</option>
                    @endforeach
                @endif
                </select>
                
                @if ($errors->has('rule'))
                    <div class="text-danger">
                    <p>{{ $errors->first('rule')}}</p>
                    </div>
                @endif
            </div>                
        </div>

        <div class="form-group row {{ $errors->has('status') ? 'has-error' : '' }}">
            <label class="control-label col-md-2 col-sm-2 col-xs-12 ">
                <div class="float-right">    
                    <b>Group Status</b>
                </div>
            </label>                
            <div class="col-md-10 col-sm-10 col-xs-12 ">
                <div class="radio">
                    <label style="padding-left: 0px; margin-right: 10px;">
                        <div class="iradio_flat-green" style="position: relative;"><input type="radio" class="flat" {{ empty($data->status) === true ? '' : ( $data->status == 1 ? 'checked' : '' ) }} name="status" value="1" style="position: absolute; opacity: 0;"></div> Enable
                    </label>
                    <label style="padding-left: 0px;" class="">
                        <div class="iradio_flat-green" style="position: relative;"><input type="radio" class="flat" {{ empty($data->status) === true ? 'checked' : ( $data->status == 0 ? 'checked' : '' ) }} name="status" value="0"  style="position: absolute; opacity: 0;"></div> Disable
                    </label>
                </div>
                @if ($errors->has('status'))
                    <div class="text-danger">
                    <p>{{ $errors->first('status')}}</p>
                    </div>
                @endif
            </div>                
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-2"></div>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <a class="btn btn-primary" href="{{'create'}}"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;&nbsp;<span>Reset</span></a>
                <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;<span>Submit</span></button>
            </div>
        </div>
    </form>
    </div>
</div>