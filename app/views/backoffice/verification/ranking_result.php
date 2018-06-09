<?php	
	echo "
	<div class='col-md-6 col-md-offset-3'>
		<table class='table table-bordered table-striped'>
		<tbody>
			<tr><td>No. Registrasi</td><td>".$no_pendaftaran."</td></tr>
			<tr><td>Nama</td><td>".$nama."</td></tr>
			<tr><td>J. Kelamin</td><td>".($jk=='L'?'Laki-laki':'Perempuan')."</td></tr>
			<tr><td>Sekolah Asal</td><td>".$sekolah_asal."</td></tr>
			<tr><td>Alamat</td><td>".$alamat."</td></tr>
			<tr><td>Jalur Pendaftaran</td><td>".$jalur."</td></tr>
			<tr><td>Peringkat</td><td>".$peringkat." (".NumToWords($peringkat).")</td></tr>
			<tr><td>Skor</td><td>".number_format($score)."</td></tr>			
		</tbody>
		</table>
	</div>";
?>