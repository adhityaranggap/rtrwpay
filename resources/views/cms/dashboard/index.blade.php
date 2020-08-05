@extends('_layout.app') 
@section('title', 'Dashboard') 
@section('page_header', 'Dashboard') 
@section('content')

    <!-- Start Count -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Warga</h4>
                    </div>
                    <div class="card-body">
                        {{$customercount}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Transaksi Lunas</h4>
                    </div>
                    <div class="card-body">
                    {{$lunascount}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Belum Bayar</h4>
                    </div>
                    <div class="card-body">
                        {{$ticketcount}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                <i class="fas fa-money-check-alt"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Telat Bayar</h4>
                    </div>
                    <div class="card-body">
                        {{$telatcount}}
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- End Count -->

<!-- Start Transaction -->
<div class="row">
    <div class="col-lg-8 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Statistics Transaction</h4>
                <div class="card-header-action">
                    <div class="btn-group">
                        <a href="#" class="btn btn-primary">Week</a>
                        <a href="#" class="btn">Month</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                    <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                        <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                        <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                    </div>
                </div>
                <canvas id="myChart" height="840" width="1386" class="chartjs-render-monitor" style="display: block; height: 420px; width: 693px;"></canvas>
                <div class="statistic-details mt-sm-4">
                    <div class="statistic-details-item">
                        <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 7%</span>
                        <div class="detail-value">$243</div>
                        <div class="detail-name">Today's Sales</div>
                    </div>
                    <div class="statistic-details-item">
                        <span class="text-muted"><span class="text-danger"><i class="fas fa-caret-down"></i></span> 23%</span>
                        <div class="detail-value">$2,902</div>
                        <div class="detail-name">This Week's Sales</div>
                    </div>
                    <div class="statistic-details-item">
                        <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span>9%</span>
                        <div class="detail-value">$12,821</div>
                        <div class="detail-name">This Month's Sales</div>
                    </div>
                    <div class="statistic-details-item">
                        <span class="text-muted"><span class="text-primary"><i class="fas fa-caret-up"></i></span> 19%</span>
                        <div class="detail-value">$92,142</div>
                        <div class="detail-name">This Year's Sales</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Recent Transaction</h4>
            </div>
            <div class="card-body">
            @foreach($trxrecent as $data)

                <ul class="list-unstyled list-unstyled-border">
                    <li class="media">
                        <img class="mr-3 rounded-circle" width="50" src="assets/img/avatar/avatar-2.png" alt="avatar">
                        <div class="media-body">
                            <div class="float-right text-primary">{{Carbon\Carbon::parse($data->updated_at)->diffForHumans()}}</div>
                            <div class="media-title">{{$data->name}}</div>
                            <span class="text-small text-muted">Payment {{$data->paid}}</span>
                        </div>
                    </li>
                    @endforeach

                    
    
                </ul>
                <div class="text-center pt-1 pb-1">
                    <a href="{{route ('all-transaction-index') }}" class="btn btn-primary btn-lg btn-round">
                      View All
                    </a>
                </div>
        </div>
        </div>
    </div>
</div>
<!-- End Transaction -->
<div class="row">
<div class="col-lg-8 col-md-8 col-12">
    <div class="card">
        <div class="card-header">
            <h4>Package Usage</h4>
        </div>
        <div class="card-body">
        @foreach($results as $data)

            <div class="mb-4">
                <div class="text-small float-right font-weight-bold text-muted">{{$data['total']}} ({{$data['percent']}}%)  </div>
                <div class="font-weight-bold mb-1">{{$data['name']}}</div>
                <div class="progress" data-height="3" style="height: 3px;">
                    <div class="progress-bar" role="progressbar" data-width="{{$data['percent']}}%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: {{$data['percent']}}%;"></div>
                </div>
            </div>
        @endforeach

        </div>
    </div>
</div>

<div class="col-lg-4 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Recent Activities Package</h4>
            </div>
            <div class="card-body">
            @foreach($packagerecent as $data)

                <ul class="list-unstyled list-unstyled-border">
                    <li class="media">
                        <img class="mr-3 rounded-circle" width="50" src="assets/img/avatar/avatar-3.png" alt="avatar">
                        <div class="media-body">
                            <div class="float-right text-primary">{{Carbon\Carbon::parse($data->updated_at)->diffForHumans()}}</div>
                            <div class="media-title">{{$data->name}}</div>
                            <span class="text-small text-muted">Package {{$data->subscription_name}}</span>
                        </div>
                    </li>
                    @endforeach

                </ul>
                <div class="text-center pt-1 pb-1">
                    <a href="{{route ('warga-subscription-index') }}" class="btn btn-primary btn-lg btn-round">
                      View All
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        var url = "{{ url()->current().'/chart' }}";
        var Week = new Array();
        var Labels = new Array();
        var Paid = new Array();
        $(document).ready(function(){
          $.get(url, function(response){
            response.forEach(function(data){
                Week.push(data.expired_date);
                Labels.push(data.users_has_packages_id);
                Paid.push(data.Paid);
            });
            var ctx = document.getElementById("myChart").getContext('2d');
                var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels:Week,
                      datasets: [{
                          label: 'Infosys Price',
                          data: Paid,
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });
          });
        });
        </script>

    @endsection