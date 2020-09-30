<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Dashboard</li>
    </ol>
    <a href="<?= ROOT_DIREC ?>/sales/daily" target="_blank" style="float:right;
    margin-top: -34px;
    margin-right: 16px;
    padding: 3px 10px;
    background: black;
    color: white;text-decoration:none!important;cursor:pointer">Exporter</a>
</div>

<div class="panel panel-container" style="margin-bottom:50px">
	<div class="row">
		<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
			<div class="panel panel-teal panel-widget border-right">
				<div class="row no-padding"><em class="fa fa-xl fa-dollar color-blue"></em>
					<div style="font-size:22px;margin-bottom:7px" class="medium"><?= number_format($total_sales[0], 2, ".", ",") ?> HTG</div>
					<div class="text-muted">Ventes Totales (HTG)</div>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
			<div class="panel panel-teal panel-widget border-right">
				<div class="row no-padding"><em class="fa fa-xl fa-dollar color-blue"></em>
					<div style="font-size:22px;margin-bottom:7px" class="medium"><?= number_format($total_sales[1], 2, ".", ",") ?> USD</div>
					<div class="text-muted">Ventes Totales (USD)</div>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
			<div class="panel panel-blue panel-widget border-right">
				<div class="row no-padding"><em class="fa fa-xl fa-cube color-orange"></em>
					<div style="font-size:22px;margin-bottom:7px" class="medium"><?= number_format($volume, 2, ".", ",") ?> M3</div>
					<div class="text-muted">Volume Total</div>
				</div>
			</div>
		</div>
		<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
			<div class="panel panel-orange panel-widget border-right">
				<div class="row no-padding"><em class="fa fa-xl fa-file color-teal"></em>
					<div style="font-size:22px;margin-bottom:7px" class="medium"><?= $count ?></div>
					<div class="text-muted">Nb de Fiches</div>
				</div>
			</div>
		</div>
	</div><!--/.row-->
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Ventes Totales</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<thead>
						<th></th>
						<th class="text-center">CASH</th>
						<th class="text-center">CREDIT</th>
						<th class="text-center">CHEQUE</th>
						<th class="text-center">TOTAL</th>
					</thead>
					<tbody>
						<tr>
							<th class="text-center">HTG</th>
							<td class="text-center"><?= number_format($salesDetails['cashHTG'], 2, ".", ",") ?> HTG</td>
							<td class="text-center"><?= number_format($salesDetails['creditHTG'], 2, ".", ",") ?> HTG</td>
							<td class="text-center"><?= number_format($salesDetails['chequeHTG'], 2, ".", ",") ?> HTG</td>
							<td class="text-center"><?= number_format(($salesDetails['creditHTG'] + $salesDetails['cashHTG'] + $salesDetails['chequeHTG']), 2, ".", ",") ?> HTG</td>
						</tr>
						<tr>
							<th class="text-center">USD</th>
							<td class="text-center">0.00 USD</td>
							<td class="text-center"><?= number_format($salesDetails['creditUSD'], 2, ".", ",") ?> USD</td>
							<td class="text-center"><?= number_format($salesDetails['chequeUSD'], 2, ".", ",") ?> USD</td>
							<td class="text-center"><?= number_format($salesDetails['creditUSD'] + $salesDetails['chequeUSD'], 2, ".", ",") ?> USD</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Ventes par produit</div>
			<div class="panel-body">
				<div class="canvas-wrapper">
					<canvas class="main-chart" id="bar-chart" height="300" width="600"></canvas>
				</div>
			</div>
		</div>
	</div>
</div><!--/.row-->	
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Volumes par type de Camion 
				</div>
			<div class="panel-body">
				<div class="canvas-wrapper">
					<canvas class="chart" id="pie-chart" ></canvas>
				</div>
				<div class="row">
					<div class="col-md-12">
						<span class="legendcolor" style="float:right;padding:5px;margin-left:5px;color:white;background:#1ebfae;border-radius:2px">CANTERS : <?= $truck_ratios[2]['value'] ?> VOY</span>
						<span class="legendcolor" style="float:right;padding:5px;margin-left:5px;color:white;background:#ffb53e;border-radius:2px">6 ROUES : <?= $truck_ratios[1]['value'] ?> VOY</span>
						<span class="legendcolor" style="float:right;padding:5px;margin-left:5px;color:white;background:#30a5ff;border-radius:2px">10 ROUES : <?= $truck_ratios[0]['value'] ?> VOY</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Qté de Fiches Chèque / Cash / Crédit</div>
			<div class="panel-body">
				<div class="canvas-wrapper">
					<canvas class="chart" id="doughnut-chart" ></canvas>
				</div>
				<div class="row">
					<div class="col-md-12">
						<span class="legendcolor" style="float:right;padding:5px;margin-left:5px;color:white;background:#30a5ff;border-radius:2px">CASH : <?= $transport_ratios[0]['value'] ?></span>
						<span class="legendcolor" style="float:right;padding:5px;margin-left:5px;color:white;background:#ffb53e;border-radius:2px">CREDIT : <?= $transport_ratios[1]['value'] ?></span>
						<span class="legendcolor" style="float:right;padding:5px;margin-left:5px;color:white;background:#1ebfae;border-radius:2px">CHEQUE : <?= $transport_ratios[2]['value'] ?></span>
						<span class="legendcolor" style="float:right;padding:5px;margin-left:5px;color:white;background:#FF0000;border-radius:2px">TRANSPORT : <?= $transport_ratios[3]['value'] ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!--/.row-->
<div class="row">	
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Meilleurs Clients</div>
			<div class="panel-body" style="height:420px">
				<ul class="todo-list">
				<?php foreach($best_clients as $b) : ?>
					<a href="<?= ROOT_DIREC ?>/customers/view/<?= $b['id'] ?>" target="_blank" style="color:black">
						<li class="todo-list-item">
							<div class="checkbox">
								<span class="fa fa-arrow-right">&nbsp;</span>
								<label for="checkbox-2"><?= strtoupper(strtolower($b['first_name']))." ".strtoupper($b['last_name']) ?></label>
							</div>
							<div class="pull-right action-buttons"><a href="<?= ROOT_DIREC ?>/customers/view/<?= $b['id'] ?>" target="_blank" class="trash">
								<span class="label label-warning"><?= number_format($b['total_sold'], 2, ".", ",") ?> M3</span>
							</a></div>
						</li>
					</a>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Meilleurs Camions Cash</div>
			<div class="panel-body" style="height:420px">
				<ul class="todo-list">
				<?php foreach($best_trucks as $b) : ?>
					<li class="todo-list-item">
					<a href="<?= ROOT_DIREC ?>/trucks/view/<?= $b['id'] ?>" target="_blank" style="color:black;cursor:pointer">
						<div class="checkbox">
							<span class="fa fa-arrow-right">&nbsp;</span>
							<label for="checkbox-1"><?= $b['immatriculation'] ?></label>
						</div>
						
						<div class="pull-right action-buttons">
							<span class="label label-warning"><?= number_format($b['total_sold'], 2, ".", ",") ?> M3</span>
						</div>

						<div class="pull-right action-buttons">
							<span class="label label-info" style="margin-right:5px"><?= number_format($b['total_trips'], 0, ".", ",") ?> VOYAGES</span>
						</div>
						</a>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>	
<div class="row">	
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Fiches non sorties</div>
			<div class="panel-body" style="height:430px;overflow-y: scroll;">
				<ul class="todo-list">
				<?php foreach($sales as $sale) : ?>
					<?php if($sale->status != 2 && $sale->status != 3 && $sale->status != 5 && $sale->status != 8 && $sale->status != 9 && $sale->status != 11) ?>
						<a href="<?= ROOT_DIREC ?>/sales/view/<?= $sale->id ?>" target="_blank" style="color:black">
							<li class="todo-list-item">
								<div class="checkbox">
									<span class="fa fa-arrow-right">&nbsp;</span>
									<label for="checkbox-2"><?= $sale->sale_number ?></label>
								</div>
							</li>
						</a>
					<?php endif; ?>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				Rapport de Caisse</div>
			<div class="panel-body" style="height:430px;overflow-y:scroll">
					<?php foreach($closing as $report) : ?>
            <table class="table table-bordered datatable" style="margin-top:15px">
                <thead>
                <tr><th colspan="3"><?= $report['user'] ?></th></tr>
                    <tr><th>Type</th><th class="text-center">HTG</th><th class="text-center">USD</th></tr>
                </thead>
                <tbody>
                
                    <tr><th>Cash</th><td class="text-center"><?= number_format($report['cash_htg'], 2, ".", ",") ?> HTG</td> <td class="text-center"><?= number_format($report['cash_usd'], 2, ".", ",") ?> USD</td></tr>
                    <tr><th>Chèque </th> <td class="text-center"><?= number_format($report['cheque_htg'], 2, ".", ",") ?> HTG</td><td class="text-center"><?= number_format($report['cheque_usd'], 2, ".", ",") ?> USD</td></tr>
                    <tr><th>Crédit </th> <td class="text-center"><?= number_format($report['credit_htg'], 2, ".", ",") ?> HTG</td><td class="text-center"><?= number_format($report['credit_usd'], 2, ".", ",") ?> USD</td></tr>
                </tbody>
            </table>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>	
<?= $this->Html->script("chart.min.js") ?>
<?= "<script> var labels = [];" ?>
<?php foreach($product_data as $product): ?>
	<?= "labels.push('".$product['abbreviation']. " - [ " . number_format($product['total_sold'], 0, "", " ") . " ]');" ?>
<?php endforeach; ?>
	<?= "console.log(labels)</script>" ?>


<?= "<script> var values = [];" ?>
<?php foreach($product_data as $product): ?>
	<?= "values.push('".number_format($product['total_sold'], 0, "", "")."');" ?>
<?php endforeach; ?>
	<?= "console.log(values)</script>" ?>

<?= "<script> var pieData = ".json_encode($truck_ratios)."</script>" ?>

<?= "<script> var doughnutData = ".json_encode($transport_ratios)."</script>" ?>

<script>
		
	var barChartData = {
		labels : labels,
		datasets : [
			{
				fillColor : "rgba(207, 0, 15, 1)",
				strokeColor : "rgba(207, 0, 15, 1)",
				highlightFill: "rgba(226, 106, 106, 1)",
				highlightStroke: "rgba(226, 106, 106, 1)",
				data : values
			},
		]

	}

	window.onload = function () {

	var chart3 = document.getElementById("doughnut-chart").getContext("2d");
	window.myDoughnut = new Chart(chart3).Doughnut(doughnutData, {
		responsive: true,
		segmentShowStroke: false
	});

	var chart4 = document.getElementById("pie-chart").getContext("2d");
	window.myPie = new Chart(chart4).Pie(pieData, {
		responsive: true,
		segmentShowStroke: false
	});

	var chart2 = document.getElementById("bar-chart").getContext("2d");
	window.myBar = new Chart(chart2).Bar(barChartData, {
		responsive: true,
		scaleLineColor: "rgba(0,0,0,.2)",
		scaleGridLineColor: "rgba(0,0,0,.05)",
		scaleFontColor: "#c5c7cc",
		options: {
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero: true
	                }
	            }]
	        }
	    }
	});
};
	</script>	

<style type="text/css">
    select{
        padding: 5px;
        /* margin-right: 5px; */
        margin-left: 5px;
        margin-bottom: 20px;
        }

    .input label{
        margin-left:22px;
    }
</style>