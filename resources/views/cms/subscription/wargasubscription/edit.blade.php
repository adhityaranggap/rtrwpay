<form method="post" action="{{ route('warga-subscription-update', $data->id) }}">
@csrf

    <div class="form-group ">
    <label for="username">Username</label>
        <input class="form-control" name="username" type="text" value="{{$data->username}}" id="username" readonly>
    </div>
    <div class="form-group ">
    <label for="subscription_id">Subscription Name</label>
    <select class="form-control" name="subscription_id">
    @foreach($subscriptions as $subscription)
      <option value="{{$subscription->id}}"  {{ $subscription->id == $data->subscription_id ? 'selected' : '' }}>{{$subscription->name}}</option>
    @endforeach
  </select>
    </div>
   
</form>


