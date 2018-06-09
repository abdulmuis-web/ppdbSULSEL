<div class="container-fluid box">

	<div class="alert alert-warning">
		<strong>Jadwal Kegiatan PPDB</strong><br />
	  Jadwal Pelaksanaan PPDB Online Jalur <?=$nama_jalur;?> :
	</div>

	<table class="table table-bordered table-striped table-hover">
		<thead>
			<tr>
				<th>KEGIATAN</th><th>LOKASI</th><th>LAMA KEGIATAN</th><th>WAKTU</th>
			</tr>
		</thead>
		<tbody>
			<?php
				foreach($jadwal_kegiatan_rows as $row){
					echo "<tr>
					<td>".$row['kegiatan']."</td><td>".$row['lokasi']."</td>
					<td>".mix_2Date($row['tgl_buka'],$row['tgl_tutup'])."</td>
					<td>".$row['keterangan']."</td>
					</tr>";
				}
			?>
		</tbody>
	</table>

</div>