<div class="container-fluid box">

	<div class="alert alert-warning">
		<strong>Kuota/Daya Tampung</strong><br />
	  Jumlah Daya Tampung Jalur <?=$nama_jalur;?> dan SMA/SMK dalam Lingkup Provinsi Sulawesi Selatan :
	</div>

	<div class="row">
		<?php
		echo "
		<div class='col-lg-6 col-md-6'>
			<table class='table table-bordered'>
				<tbody>";
					
					$tot_kuota_sekolah = 0;
					foreach($tipe_sekolah_arr as $key=>$val){
						echo "<tr>
						<td><b>".$val."</b></td><td align='right'>".number_format($kuota_sekolah[$key])." Orang</td>
						</tr>";
						$tot_kuota_sekolah += $kuota_sekolah[$key];
					}
					
				echo "</tbody>
				<tfoot>
					<tr><td align='right'><b>TOTAL PENERIMAAN SISWA</b></td><td align='right'>".number_format($tot_kuota_sekolah)." Orang</td></tr>
				</tfoot>
			</table>
		</div>
		<div class='col-lg-6 col-md-6'>
			<table class='table table-bordered'>
				<tbody>
					<tr><td colspan='3'>Daya Tampung Jalur ".$nama_jalur." : 
					<small>".$kuota_jalur_row['persen_kuota']." % * Total Penerimaan Siswa</small>
					</td></tr>
					<tr>";
					foreach($tipe_sekolah_arr as $key=>$val){
						echo "<td align='center'><b>".$val."</b></td>";
					}					
					echo "<td>Total</td></tr>
					<tr>";
					$total = 0;
					foreach($tipe_sekolah_arr as $key=>$val){
						$kuota = $kuota_jalur_row['persen_kuota']*$kuota_sekolah[$key]/100;
						echo "<td align='right'>".number_format($kuota)." Orang</td>";
						$total += $kuota;
					}
					echo "
					<td align='right'>".number_format($total)." Orang</td>
					</tr>					
				</tbody>
			</table>
		</div>";
		?>
	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<table id="school-quota-table" class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<td width="4%" align="center"><b>No.</b></td><td align="center"><b>Nama Sekolah</b></td>
						<td align="center"><b>Alamat, Kab./Kota</b></td>						
						<td align="center"><b>Rombel</b></td>
						<td align="center"><b>Kapasitas</b></td>
						<td align="center"><b>Kuota</b></td>
						<td align="center"><b>Pendaftar</b></td>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 0;
						foreach($pengaturan_kuota_sekolah_rows as $row){
							$no++;
							$kuota = '';
							switch($path){
								case '1':$kuota = $row['kuota_domisili'];break;
								case '2':$kuota = $row['kuota_afirmasi'];break;
								case '3':$kuota = $row['kuota_akademik'];break;
								case '4':$kuota = $row['kuota_prestasi'];break;
								case '5':$kuota = $row['kuota_khusus'];break;
							}
							echo "<tr>
							<td align='center'>".$no."</td>
							<td>".$row['nama_sekolah']."</td>
							<td>".(empty($row['alamat'])?'-':'')."<br />
							".$row['nama_dt2']."</td>							
							<td align='right'>".number_format($row['jml_rombel'])."</td>
							<td align='right'>".number_format($row['jml_kuota'])."</td>
							<td align='right'>".number_format($kuota)."</td>
							<td align='right'>".number_format($row['tot_pendaftar'])."</td>
							</tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	</div>

</div>



<script src="<?=$this->config->item("js_path");?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$this->config->item("js_path");?>plugins/datatables/dataTables.colVis.min.js"></script>
<script src="<?=$this->config->item("js_path");?>plugins/datatables/dataTables.tableTools.min.js"></script>
<script src="<?=$this->config->item("js_path");?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?=$this->config->item("js_path");?>plugins/datatable-responsive/datatables.responsive.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		
		$('#school-quota-table').DataTable({
            "oLanguage": {
            "sSearch": "Search :"
            },
            "aoColumnDefs": [
                {
                    'bSortable': false,
                    'aTargets': [0]
                } //disables sorting for column one
            ],
            'iDisplayLength': 10,
            "sPaginationType": "full_numbers"
        });

	});
</script>