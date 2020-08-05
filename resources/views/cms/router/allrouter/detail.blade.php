<form method="post" action="{{ route('all-router-update', $data->id) }}">
@csrf
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col"><b>Router Name</b></th>
      <th>{{ $data->router_name }}</th>    
    </tr>
    <tr>
      <th scope="col"><b>IP Public</b></th>
      <th>{{ $data->host }}</th>    
    </tr>
    <tr>
      <th scope="col"><b>Port API</b></th>
      <th>{{ $data->port}}</th>    
    </tr>
    <tr>
      <th scope="col"><b>User Router</b></th>
      <th>{{ $data->user}}</th>    
    </tr>
    <tr>
      <th scope="col"><b>Address Router</b></th>
      <th>{{ $data->address}}</th>    
    </tr>
    <tr>
      <th scope="col"><b>Coordinate Router</b></th>
      <th>{{ $data->coordinate}}</th>    
    </tr>
    @endforlse
    <tr>
    @forelse($response as $response)
      <th scope="col"><b>IP VPN </b></th>
      <th>{{ $response['address'] }}</th>    
      @empty
      <th>Belum terhubung</th>    
    @endforelse
    </tr>
   
  </thead> 
</table>

</div>
</form>


