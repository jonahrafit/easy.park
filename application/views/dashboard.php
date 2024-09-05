<?php 
    $total = $simplestat['total'];
    $occupe = $simplestat['occupe'];
    $eninfraction = $simplestat['eninfraction'];
    $indisponible = $simplestat['indisponible'];
    $libre = $simplestat['libre'];
?>
<div class="row">
    <div class="col-lg-9 main-chart">
        <div class="row mt">
            <div class="col-md-4 col-sm-4 mb">
                <div class="grey-panel pn donut-chart">
                    <div class="grey-header">
                        Etat de place
                    </div>
                    <canvas id="chartoccup" height="120" width="120"></canvas>
                    <script>
                    var doughnutData = [{
                            value: <?php echo ($occupe * 100) / $total; ?>,
                            color: "red"
                        },
                        {
                            value: <?php echo ($eninfraction * 100) / $total; ?>,
                            color: "yellow"
                        },
                        {
                            value: <?php echo ($indisponible * 100) / $total; ?>,
                            color: "black"
                        },
                        {
                            value: <?php echo ($libre * 100) / $total; ?>,
                            color: "green"
                        }
                    ];
                    var myDoughnut = new Chart(document.getElementById("chartoccup").getContext("2d")).Doughnut(
                        doughnutData);
                    </script>
                    <div class="row">
                        <div class="col-sm-7 col-xs-7 goleft">
                            <p> <i class='fa fa-square' style='color : red'> </i> Occupé : <?php echo $occupe; ?> <br>
                                <i class='fa fa-square' style='color : yellow'> </i> En Infraction : <?php echo $eninfraction; ?> <br>
                                <i class='fa fa-square' style='color : black'> </i> Indisponible: <?php echo $indisponible; ?> <br>
                                <i class='fa fa-square' style='color : green'> </i> Libre : <?php echo $libre; ?>
                            </p>
                        </div>
                        <div class="col-sm-5 col-xs-5">
                            <h3>Total : <?php echo $total; ?></h3>
                        </div>
                    </div>
                </div>
                <!-- /grey-panel -->
            </div>
            <!-- <div class="col-md-4">
                <div class="card card-info">
                    <div class="card-header">
                        <h4 class="card-title">Line Chart</h4>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="line-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div> <!-- /. col -->
</div>
<!-- <script src="<?php echo chart_url('Chart.js') ?>"></script>
<script src="<?php echo chart_url('jquery-3.3.1.min.js') ?>"></script>
<script>
$(function() {

    var ctx5 = $("#line-chart");

    //options
    var options = {
        responsive: true,
        title: {
            display: true,
            position: "top",
            text: "Amount registered ",
            fontSize: 18,
            fontColor: "#111"
        },
        legend: {
            display: true,
            position: "bottom",
            labels: {
                fontColor: "#333"
            }
        }
    };
    var xvalue = [50,60,70,80,90,100,110,120,130,140,150];
    var yvalue = [7,8,8,9,9,9,10,11,14,14,15];

    var chart5 = new Chart(ctx5, {
        type: "line",
        data: {
            labels: xvalue,
            datasets: [{
                backgroundColor: "white",
                borderColor: "rgba(0,0,0,0.1)",
                data: yvalue
            }]
        },
        options: options
    });
});
</script>  -->