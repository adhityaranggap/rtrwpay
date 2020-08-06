@extends('_layout.app')
@section('title', 'Unpaid Transaction')
@section('page_header', 'Transaction')
@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h4>Transaksi Bulan Ini</h4>
            
            <!-- <div class="card-header-action">
                <button id="lunas" class="btn btn-info">Set Lunas</button>
                <a href="{{ route('all-transaction-sync') }}" class="btn btn-outline-primary title="Sync Data App\Component::btnDelete><i class="fas fa-sync"> Sync Data </i></a>                                
            </div> -->
            <div class="card-header-action">
                <a href="{{ route('all-transaction-create') }}" class="btn btn-outline-primary modal-show" title="Tambah Transaction Baru ">(+) Tambah Baru</a>                
            </div>
        </div>
        <div class="card-body ">
            <div class="table">
                <table id="appTable" class="table nowrap table-bordered table-hover dataTable table-striped" style="width:100%">
                    <thead>
                    <tr>
                    <!-- <th scope="col">No</th> -->
                        <!-- <th scope="col">id</th> -->
                        <th scope="col">Nama</th>
                        <!-- <th scope="col">Bulan Pembayaran</th> -->
                        <th scope="col">Bulan</th>
                        <!-- <th scope="col">Harga</th> -->
                        <th scope="col">Tagihan</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                </table>    
            </div>
        </div>
    </div>


@endsection


@push('css')
<!-- add Css Here -->
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
<!-- datatables -->
<!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css'> -->
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/rowreorder/1.2.7/css/rowReorder.dataTables.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/responsive/2.2.5/css/responsive.dataTables.min.css'>
<link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css'>
<link rel='stylesheet' href=''>
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css'>

<!-- Datepicker -->
<link rel="stylesheet" href="https://demo.getstisla.com/assets/modules/bootstrap-daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://demo.getstisla.com/assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css" />

@endpush

@push('js')
<!-- add Js Script Here -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.5/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<!-- Datepicker -->
<script src="https://demo.getstisla.com/assets/modules/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="https://demo.getstisla.com/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>

<!-- <script>
 $('#appTable').DataTable({
    columnDefs: [ {
            orderable: false,
            // className: 'select-checkbox',
            targets:   0
        } ],
        select: {
            style:    'multi',
            selector: 'td:first-child'
        },
        order: [[ 1, 'asc' ]],
        responsive:true, 
        dom: '<"top"fB>rt<"bottom"lp><"clear">',
        buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],    
        processing:true,
        serverSide:true,
        ajax: "{{ url()->current().'/datatables' }}",
        columns:[
            {data: 'DT_RowIndex', name:'name', searchable: false},
            {data: 'name', name:'name'},
            // {data: 'month_date', name:'month_date'},
            {data: 'subscription_name', name:'subscription_name'},
            // {data: 'price', name:'price'},
            {data: 'expired_date', name:'expired_date'},
        {data: 'status', name:'status'},
            {data: 'action', name:'action'},           
        ]
    });
</script> -->

<script>
$(document).ready(function (){
   var table = $('#appTable').DataTable({
    responsive: true,
    processing:true,
    serverSide:true,
    ajax: "{{ url()->current().'/datatables' }}",
        columns:[
            // {data: 'DT_RowIndex', name:'name', searchable: false},
            // {data: 'id', visible: false, className: 'id'},
            {data: 'name', name:'name'},
            // {data: 'month_date', name:'month_date'},
            {data: 'expired_date', name:'expired_date'},
            {data: 'subscription_name', name:'subscription_name'},
            // {data: 'price', name:'price'},
            {data: 'status', name:'status'},
            {data: 'action', name:'action'},           
        ],
      'select': {
         'style': 'multi'
      },
      'order': [[3, 'desc']]
   });

   $('#appTable tbody').on( 'click', 'tr', function () {
        // $(this).toggleClass('selected');
        var tblData = table.rows('.selected').data();
        // var tmpData;
        // $.each(tblData, function(i, val) {
        //     tmpData = tblData[i];
            // alert(tmpData);
        // })
    } );
 
    $('#lunas').click( function () {
        // var selectedIds = table.rows('.selected').data()
        // selectedIds.push(table[0]);
        // console.log(selectedIds);
        $.each(table.rows('.selected').nodes(), function(i, item) {
    var id = item.id;
    var data = table.row(this).data();

    alert("Produt Id : " +
      id + " && product Status:  " + data[2]);
  })
        // alert( table.rows('.selected').data());
    } );
   // Handle form submission event

//    $('#lunas').on('click', function(e){

//     var selectedIds = tbl.columns().checkboxes.selected()[0];
//    console.log(selectedIds)

//    selectedIds.forEach(function(selectedId) {
//        alert(selectedId);
//    });
    // var table = table.row(this).data();                          
    // console.log(table.rows(this).data());

    // var table = table.column(0).checkboxes.selected();
    //     console.log(table.rows(this).data());


    // // Iterate over all selected checkboxes
    // $.each(table, function(index, rowId){
    // // Create a hidden element
    // console.log(index);
    // console.log(rowId);
    // $(form).append(
    //     $('<input>')
    //         .attr('type', 'hidden')
    //         .attr('name', 'id[]')
    //         .val(rowId)
    // );
    // });

    // alert('beres');

    //   var form = this;

    //   var rows_selected = table.column(0).checkboxes.selected();

    //   // Iterate over all selected checkboxes
    //   $.each(rows_selected, function(index, rowId){
    //      // Create a hidden element
    //      console.log(index);
    //      console.log(rowId);
    //      $(form).append(
    //          $('<input>')
    //             .attr('type', 'hidden')
    //             .attr('name', 'id[]')
    //             .val(rowId)
    //      );
    //   });
});
// });
</script>
@endpush
