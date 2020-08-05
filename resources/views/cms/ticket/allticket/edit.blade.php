<form method="post" action="{{ route('all-ticket-update', $data->id) }}">
@csrf

<div class="row">
    <div class="col-6">
        <div class="form-group ">
        <label for="ticket_number">Ticket Number</label>
            <input class="form-control" name="ticket_number" type="text" value="{{$data->ticket_number}}" id="ticket_number" disabled>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group ">
        <label for="customer">Customer</label>
            <input class="form-control"  type="text" placeholder="Required" value="{{$data->customer}}" id="customer" disabled>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group ">
        <label for="subject">subject</label>
            <textarea id="" class="form-control" readonly>{{ $data->subject }}</textarea>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group ">
        <label for="description">Description</label>
            <!-- <textarea id="" class="form-control" readonly>{{ $data->description }}</textarea> -->
            {!! $data->description !!}
        </div>
    </div>
    <table class="table table-striped">
    <thead>
    <tr>
      <th scope="col"><b>Respond</b></th>  
      <th scope="col"><b>Respond Time</b></th>      
    
    </tr>

    </thead>
    <tbody>
        
        @forelse($ticketsResponds as $ticketRespond)
            <tr>
            <td>{!! $ticketRespond->respond !!}</td>
            <td>{{ Carbon\Carbon::parse($ticketRespond->created_at)->diffForHumans()}}</td>
            </tr>
        @empty
            <td>Nothing Respond</td>
        @endforelse
    </tbody>
    </table>
    <div class="col-12">
        <div class="form-group ">
        <label for="respond">Answer</label>
                <textarea id="ckeditor" name="ckeditor" class="form-control" rows="10" cols="50"></textarea>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group ">
            <label for="status">status</label>
            <select name="status" class=form-control id="status">
                @foreach(\EnumTicket::statusLists() as $key => $status)
                    <option value="{{$key}}" {{ $data->status == $key ? 'selected' : '' }}>{{$status}}</option>
                @endforeach       
            </select>    
        </div>
    </div>

</div>    

</form>



<script src="{{asset('assets/vendors/stisla/ckeditor/ckeditor.js')}}"></script>
<script>
  var respond = document.getElementById("ckeditor");
    CKEDITOR.replace(respond,{
    language:'en-gb'
  });
  CKEDITOR.config.allowedContent = true;
</script>