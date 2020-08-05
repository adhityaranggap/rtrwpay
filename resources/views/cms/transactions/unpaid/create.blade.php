<form method="post" action="{{ route('all-transaction-store') }}">
@csrf

    <div class="form-group ">
        <label for="name">Username</label>
        <div class="form-group" style="margin-top:5px; ">
            <select class="form-control cari" id="type" name="type">
            
            </select>
        </div>
    </div>

    <div class="package-list" style="margin-top:5px;"></div>

    <div class="form-group" style="margin-top:15px; ">
        <label for="name">Name Package</label>
        <select class="form-control " id="type" name="type">
            @forelse($subscription as $package)
                <option value="{{ $package->id }}">{{ $package->name }}</option>
            @empty
            @endforelse
        </select>    
    </div>
    <div class="form-group ">
    <label for="name">Price</label>
        <input class="form-control" name="price" type="integer" value="" id="price">
    </div>
    
    

    <div class="form-group ">
        <label for="name">Status</label>
        <input type="text" class="form-control">
    </div>
</form>

<script type="text/javascript">
$(document).ready(function(){
	$('.cari').select2({
		placeholder: 'Username...',
		ajax: {
        // headers: {
        //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        // }
        url: "{{route ('customer-load')}}",
        dataType: 'json',
		delay: 250,
		processResults: function (data) {
 
			return {
			results:  $.map(data, function (item) {
                $('#name').empty().val(item.name).attr('readonly', true);
                // $('#price').empty().val(item.price).attr('readonly', true);
				return {
                text: item.username + ' | ' + item.email,
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
