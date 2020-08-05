<form method="post" action="{{ route('all-transaction-update', $data->id) }}">
@csrf
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col"><b>Warga</b></th>
      <th>{{ $data->name }}</th>    
    </tr>
    <tr>
      <th scope="col"><b>Nomor Telpon</b></th>
      <th>{{ $data->contact_person }}</th>    
    </tr>
    <tr>
      <th scope="col"><b>Paket Internet</b></th>
      <th>{{ $data->subscription_name}}</th>    
    </tr>
    <tr>
      <th scope="col"><b>Jatuh Tempo</b></th>
      <th>{{Carbon\Carbon::parse($data->expired_date)->format('M Y')}}</th>    
    </tr>
    <tr>
      <th scope="col"><b>History Pembayaran</b></th>
      <th>{{Carbon\Carbon::parse($data->updated_at)->diffForHumans()}}</th>    
    </tr>
    <tr>
      <th scope="col"><b>Biaya Tagihan</b></th>
      <th>{{ $data->payment_billing}}</th>    
    </tr>
    <tr>
      <th scope="col"><b>Pembayaran Sebelumnya</b></th>
      <th>{{ $data->paid}}</th>    
    </tr>
    <tr>
      <th scope="col"><b>Admin</b></th>
      <th>{{ auth()->user()->name }}</th>    
      <!-- TODO auth 
        auth()->user()->name
      -->
    </tr>
  </thead> 
</table>
<div class="form-group ">
    <label for="type_payment">Tipe Pembayaran</label>
    <select class="form-control" id="type_payment" name="type_payment">
            <option value="Transfer">Transfer</option>
            <option selected value="Cash">Cash</option>
        </select>
    </div>   
    <div class="form-group ">
    <label for="payment_proof">Upload Bukti Bayar (Jika Transfer)</label>
        <input class="form-control-file" name="payment_proof" type="file" id="payment_proof">
    </div>

    <div class="form_group"></div>
    <label for="expired_date">Expired Date</label>
    <input type="text" class="form-control datepicker" name="expired_date" id="expired_date" value="{{ $data->expired_date }}">
    </div>
    
    <div class="form-group ">
    <label for="name">Biaya Admin</label>
        <input class="form-control" name="fee" type="number" value="0" id="fee" readonly>
    </div>
    <div class="form-group ">
    <label for="paid">Nominal Dibayar</label>
        <input class="form-control" name="paid" type="number" value="{{ $data->payment_billing - $data->paid}}" id="paid">
    </div>


    <script>

$('.datepicker').daterangepicker({
        locale: {format: 'YYYY-MM-DD hh:mm'},
        singleDatePicker: true,
        timePicker: true,
        timePicker24Hour: true,
      });
    // $('.datepicker').daterangepicker({
    //       locale: {format: 'YYYY-MM-DD hh:mm:ss'},
    //       singleDatePicker: true,
    //     });

    // Timepicker
      $(".timepicker").timepicker({
        icons: {
          up: 'fas fa-chevron-up',
          down: 'fas fa-chevron-down'
        }
      });

    </script>
</form>


