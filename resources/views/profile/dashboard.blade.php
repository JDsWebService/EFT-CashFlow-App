@extends('layouts.app')

@section('title', 'Profile Dashboard')

@section('stylesheets')

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);

          function drawVisualization() {
            

            var data = google.visualization.arrayToDataTable({!! $balance_json !!});

            var options = {
              title : 'Last 25 Transactions Profit',
              animation:{
                    "startup": true,
                  duration: 1000,
                  easing: 'out',
                },
              height: 500,
              vAxis: {title: 'Balance', format: '# \u20BD'},
              hAxis: {title: 'Transactions', textPosition: 'none', gridlines: {count: 0}},
              series: {
                0: {
                    type: 'bars',
                    annotations: {
                        textStyle: {fontSize: 12, color: 'red' }
                  }
                }
              },
              legend: {
                position: 'none'
              },
              tooltip: {isHtml: true}
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
          }
    </script>

    <style>
        div.google-visualization-tooltip {
          white-space: nowrap;
        }
    </style>

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!--Div that will hold the pie chart-->
            <div id="chart_div" class="w-100"></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    setTimeout(function(){
   window.location.reload(1);
}, 30000);
</script>

@endsection