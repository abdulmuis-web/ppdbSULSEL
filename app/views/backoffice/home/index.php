<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">

		<span class="ribbon-button-alignment"> 
			<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
				<i class="fa fa-refresh"></i>
			</span> 
		</span>
		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>Home</li><li>Dashboard</li>
		</ol>
		<!-- end breadcrumb -->

	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">
		<?php			
			$title = "Statistik";
			$title .= ($this->session->userdata('admin_type_id')=='3' || $this->session->userdata('admin_type_id')=='4'?" ".$this->session->userdata('nama_sekolah'):'');
		?>
		<div class="row">
			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
				<h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-home"></i> Dashboard <span>> <?=$title;?></span></h1>
			</div>
			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
				
			</div>
		</div>
		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">
				<article class="col-sm-12">							
					<div class="row">
						<div class="col-md-6">							
							<h5 align="center">Grafik Ratio Pendaftaran (%)</h5>
							<canvas id="barChart" height="200"></canvas>
						</div>
						<div class="col-md-6">
							<table style="margin-top:46px" class="table table-bordered table-striped table-hover">
								<tbody>
									<?php
									if($this->session->userdata('admin_type_id')=='3' or $this->session->userdata('admin_type_id')=='4'){

										echo "
										<tr>
											<td colspan='4'>Tabel Ratio Pendaftaran</td>
										</tr>
										<tr>
											<td>Jalur</td><td>Kuota</td><td>Pendaftar</td><td>(%)</td>
										</tr>";

										$tot_kuota = 0;
										$tot_pendaftar = 0;
										foreach($jalur_pendaftaran_rows as $row){
											$ratio = ($kuota_sekolah[$row['ref_jalur_id']]>0?$pendaftar_sekolah[$row['ref_jalur_id']]/$kuota_sekolah[$row['ref_jalur_id']]*100:0);
											echo "<tr>
											<td>".$row['nama_jalur']."</td>
											<td align='right'>".number_format($kuota_sekolah[$row['ref_jalur_id']])."</td>
											<td align='right'>".number_format($pendaftar_sekolah[$row['ref_jalur_id']])."</td>
											<td align='right'>".number_format($ratio,3,'.',',')."</td>
											</tr>";
											$tot_kuota += $kuota_sekolah[$row['ref_jalur_id']];
											$tot_pendaftar += $pendaftar_sekolah[$row['ref_jalur_id']];
										}

									}else{
										echo "
										<tr>
											<td colspan='4'>Tabel Ratio Pendaftaran</td>
										</tr>
										<tr>
											<td>Jenjang</td><td>Kuota</td><td>Pendaftar</td><td>(%)</td>
										</tr>";
											$tot_kuota = 0;
											$tot_pendaftar = 0;
											foreach($tipe_sekolah_rows as $row){
												$ratio = ($kuota_sekolah[$row['ref_tipe_sklh_id']]>0?$pendaftar_sekolah[$row['ref_tipe_sklh_id']]/$kuota_sekolah[$row['ref_tipe_sklh_id']]*100:0);
												echo "<tr>
												<td>".$row['nama_tipe_sekolah']."</td>
												<td align='right'>".number_format($kuota_sekolah[$row['ref_tipe_sklh_id']])."</td>
												<td align='right'>".number_format($pendaftar_sekolah[$row['ref_tipe_sklh_id']])."</td>
												<td align='right'>".number_format($ratio,3,'.',',')."</td>
												</tr>";
												$tot_kuota += $kuota_sekolah[$row['ref_tipe_sklh_id']];
												$tot_pendaftar += $pendaftar_sekolah[$row['ref_tipe_sklh_id']];
											}
											$tot_ratio = ($tot_kuota>0?$tot_pendaftar/$tot_kuota*100:0);
											echo "<tr>
											<td align='center'>TOTAL</td><td align='right'>".number_format($tot_kuota)."</td><td align='right'>".number_format($tot_pendaftar)."</td>
											<td align='right'>".number_format($tot_ratio,3,'.',',')."</td>
											</tr>";
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</article>
			</div>

			<!-- end row -->

		</section>
		<!-- end widget grid -->

	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->
		
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