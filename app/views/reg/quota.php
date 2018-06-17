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
					<tr><td colspan='2'>Daya Tampung Jalur ".$nama_jalur."</td></tr>
					<tr><td>".$kuota_jalur_row['persen_kuota']." % * TOTAL PENERIMAAN SISWA</td><td align='right'>".number_format($kuota_jalur)." Orang</td></tr>
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
						<td width="4%" align="center"><b>No.</b></td><td align="center"><b>Nama Sekolah</b></td><td align="center"><b>Alamat</b></td><td align="center"><b>Kab./Kota</b></td><td align="center"><b>Jml. Rombel</b></td>
						<td align="center"><b>Jml. Diterima</b></td>
					</tr>
				</thead>
				<tbody>
					<?php
						$no = 0;
						foreach($pengaturan_kuota_sekolah_rows as $row){
							$no++;
							echo "<tr>
							<td align='center'>".$no."</td>
							<td>".$row['nama_sekolah']."</td>
							<td>".$row['alamat']."</td>
							<td>".$row['nama_dt2']."</td>
							<td align='right'>".number_format($row['jml_rombel'])."</td>
							<td align='right'>".number_Format($row['jml_kuota'])."</td>
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