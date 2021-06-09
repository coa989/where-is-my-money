@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
            <script type="text/javascript">

                // Load the Visualization API and the corechart package.
                google.charts.load('current', {'packages':['corechart']});

                // Set a callback to run when the Google Visualization API is loaded.
                google.charts.setOnLoadCallback(drawChart);

                // Callback that creates and populates a data table,
                // instantiates the pie chart, passes in the data and
                // draws it.
                function drawChart() {

                    // Create the data table.
                    var data = new google.visualization.arrayToDataTable([
                        ['Category', 'Amount'],
                        @php
                            foreach($expenses as $expense) {
                                echo "['".$expense['category']['name']."', ".$expense['amount']."],";
                            }
                        @endphp
                    ]);

                    // Set chart options
                    var options = {'title':'Total Expenses Structure',
                        'width':400,
                        'height':300};

                    // Instantiate and draw our chart, passing in some options.
                    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                    chart.draw(data, options);
                }
            </script>
            <!--Div that will hold the pie chart-->
            <div id="chart_div"></div>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <a href="{{ route('total-structure') }}"><button class="btn btn-info">All Time</button></a>
                <a href="{{ route('days-structure', 7) }}"><button class="btn btn-success">Last Week</button></a>
                <a href="{{ route('days-structure', 30) }}"><button class="btn btn-primary">This Month</button></a>
                <a href="{{ route('days-structure', 180) }}"><button class="btn btn-secondary">Last 6 Months</button></a>
                <a href="{{ route('days-structure', 365) }}"><button class="btn btn-dark">Last Year</button></a>
             </div>
        </div>
    </div>
@endsection
