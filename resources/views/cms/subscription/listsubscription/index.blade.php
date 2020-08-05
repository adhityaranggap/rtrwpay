@extends('_layout.app')
@section('title', 'Data Subscription')
@section('page_header', 'Subscription')
@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h4>Data Subscription</h4>
            <div class="card-header-action">
                <a href="{{ route('list-subscription-create') }}" class="btn btn-outline-primary modal-show" title="Tambah Subscription Baru ">(+) Tambah Baru</a>                
            </div>
        </div>
        <div class="card-body ">
            <div class="table">
                <table id="appTable" class="table nowrap table-bordered table-hover dataTable table-striped" style="width:100%">
                    <thead>
                    <tr>
                    <th scope="col">No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
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
<link rel='stylesheet' href='https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css'>
@endpush

@push('js')
<!-- add Js Script Here -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script>
 $('#appTable').DataTable({
    responsive:true,
        processing:true,
        serverSide:true,
        ajax: "{{ url()->current().'/datatables' }}",
        columns:[
            {data: 'DT_RowIndex', name:'name', searchable: false},
            {data: 'name', name:'name'},
            {data: 'price', name:'price'},
            {data: 'action', name:'action', searchable: false}           
        ]
    });
</script>
@endpush
