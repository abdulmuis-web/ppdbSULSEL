<div class="container-fluid box">
	<div class="row" style="margin-top:20px">
		<div class="col-md-6">
			<h5 align="center">Grafik Ratio Pendaftaran (%)</h5>
			<canvas id="barChart" height="200"></canvas>
		</div>
		<div class="col-md-6">
			<table style="margin-top:46px" class="table table-bordered table-striped table-hover">
				<tbody>
					<tr>
						<td colspan="4">Ratio Pendaftaran Jalur <?=$nama_jalur;?></td>
					</tr>
					<tr>
						<td>Jenjang</td><td>Kuota</td><td>Pendaftar</td><td>(%)</td>
					</tr>
					<?php
						$tot_kuota = 0;
						$tot_pendaftar = 0;
						foreach($tipe_sekolah_arr as $key=>$val){
							$ratio = ($kuota_sekolah[$key]>0?$pendaftar_sekolah[$key]/$kuota_sekolah[$key]*100:0);
							echo "<tr>
							<td>".$val."</td>
							<td align='right'>".number_format($kuota_sekolah[$key])."</td>
							<td align='right'>".number_format($pendaftar_sekolah[$key])."</td>
							<td align='right'>".number_format($ratio,3,'.',',')."</td>
							</tr>";
							$tot_kuota += $kuota_sekolah[$key];
							$tot_pendaftar += $pendaftar_sekolah[$key];
						}
						$tot_ratio = ($tot_kuota>0?$tot_pendaftar/$tot_kuota*100:0);
						echo "<tr>
						<td align='center'>TOTAL</td><td align='right'>".number_format($tot_kuota)."</td><td align='right'>".number_format($tot_pendaftar)."</td>
						<td align='right'>".number_format($tot_ratio,3,'.',',')."</td>
						</tr>";
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script src="<?=$this->config->item("js_path");?>plugins/chartjs/chart.min.js"></script>

<script type="text/javascript">
	// BAR CHART
    var barOptions = {
	    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
	    scaleBeginAtZero : true,
	    //Boolean - Whether grid lines are shown across the chart
	    scaleShowGridLines : true,
	    //String - Colour of the grid lines
	    scaleGridLineColor : "rgba(0,0,0,.05)",
	    //Number - Width of the grid lines
	    scaleGridLineWidth : 1,
	    //Boolean - If there is a stroke on each bar
	    barShowStroke : true,
	    //Number - Pixel width of the bar stroke
	    barStrokeWidth : 1,
	    //Number - Spacing between each of the X value sets
	    barValueSpacing : 5,
	    //Number - Spacing between data sets within X values
	    barDatasetSpacing : 1,
	    //Boolean - Re-draw chart on page resize
        responsive: true,
	    //String - A legend template
	    legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
    }

    var barData = {
        labels: <?=$labelChart;?>,
         datasets: [
	        {
	            label: "Grafik PPDB Online",
	            fillColor: "rgba(20, 255, 0,0.5)",
	            strokeColor: "rgba(16, 191, 1,0.8)",
	            highlightFill: "rgba(23, 224, 6,0.75)",
	            highlightStroke: "rgba(19, 198, 3,1)",
	            data: <?=$dataChart;?>
	        }
	    ]
    };

    // render chart
    var ctx = document.getElementById("barChart").getContext("2d");
    var myNewChart = new Chart(ctx).Bar(barData, barOptions);

    // END BAR CHART
    
</script>