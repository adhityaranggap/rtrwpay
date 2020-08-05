<form method="post" action="{{ route('warga-subscription-store') }}">
@csrf

    <div class="form-group ">
        <label for="name">Username</label>
        <div class="form-group" style="margin-top:5px; ">
            <select class="form-control cari" id="user_id" name="user_id" style="width:100%;">
            
            </select>
        </div>
    </div>
    <div class="form-group ">
    <label for="subscription_id">Subscription Name</label>
    <select class="form-control" name="subscription_id">
    @foreach($subscriptions as $subscription)
      <option value="{{$subscription->id}}">{{$subscription->name}}</option>
    @endforeach
    </select>
    </div>
 
   
</form>

<script type="text/javascript">
$( document ).ready(function(){
	$('.cari').select2({
		placeholder: 'Username...',
		ajax: {
        // headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // }
        url: "{{route ('warga-subscription-load')}}",
        dataType: 'json',
		delay: 250,
		processResults: function (data) {
 
			return {
			results:  $.map(data, function (item) {
                $('#name').empty().val(item.name).attr('readonly', true);
                // $('#price').empty().val(item.price).attr('readonly', true);
				return {
                text: item.username,
				id: item.id
				}
			})
			};
		},
        
		cache: true
		}
	});
}   );
	</script>
