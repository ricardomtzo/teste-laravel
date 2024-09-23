<x-layout>
    @section('content')
    <div class="py-12 mt-5">

        <h4>Gerenciamento de usuários</h4>
        <div class="row">
            <div class="col-md-6">
                <div id="chart_div"></div>
            </div>
            <div class="col-md-6">
                <div id="activeUsers_chart_div"></div>
            </div>
            <div class="col-md-12 mt-5">
                <div id="totalUsers_chart_div"></div>
            </div>
        </div>

        <input type="hidden" id="pizza" value="{{ json_encode($valuesChart['pizza']) }}">
        <input type="hidden" id="usersByYear" value="{{ json_encode($valuesChart['usersByYear']) }}">
        <input type="hidden" id="activeUsers" value="{{ json_encode($valuesChart['activeUsers']) }}">
        <input type="hidden" id="inactiveUsers" value="{{ json_encode($valuesChart['inactiveUsers']) }}">

    </div>

    @endsection

</x-layout>

<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });

    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawTotalUsersChart);
    google.charts.setOnLoadCallback(drawActiveUsersChart);

    function drawChart() {

        var values = JSON.parse(document.getElementById("pizza").value);

        values = values.map(v => [
            v.state,
            parseInt(v.total)
        ])

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows(values);

        // Set chart options
        var options = {
            'title': 'Usuários por estado',

        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

    function drawTotalUsersChart() {

        const colors = ['#76A7FA', '#703593', '#871B47', '#BC5679', '#C5A5CF'];

        var values = JSON.parse(document.getElementById("usersByYear").value);

        values = values.map((v, i) => [
            `${v.year}`,
            parseInt(v.total),
            'color:' + colors[i]
        ])

        values.unshift(['Year', 'Total', {
            role: 'style'
        }]);

        var data = google.visualization.arrayToDataTable(values);

        var options = {
            title: 'Usuarios por ano de cadastro',

        };

        var chart = new google.visualization.ColumnChart(document.getElementById('totalUsers_chart_div'));
        chart.draw(data, options);
    }

    function drawActiveUsersChart() {

        const activeUsers = JSON.parse(document.getElementById("activeUsers").value);
        const inactiveUsers = JSON.parse(document.getElementById("inactiveUsers").value);

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Ativos', activeUsers],
            ['Inativos', inactiveUsers],
        ]);

        var options = {
            title: 'Usuarios ativos e inativos',
            is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('activeUsers_chart_div'));
        chart.draw(data, options);
    }
</script>