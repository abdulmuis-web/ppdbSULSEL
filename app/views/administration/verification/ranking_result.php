<?php	
	echo "
	<div class='col-md-6 col-md-offset-3'>
		<table class='table table-bordered table-striped'>
		<tbody>
			<tr><td>No. Registrasi</td><td><b>".$no_pendaftaran."</b></td></tr>
			<tr><td>Nama</td><td>".$nama."</td></tr>
			<tr><td>J. Kelamin</td><td>".($jk=='L'?'Laki-laki':'Perempuan')."</td></tr>
			<tr><td>Sekolah Asal</td><td>".$sekolah_asal."</td></tr>
			<tr><td>Alamat</td><td>".$alamat."</td></tr>
			<tr><td>Kecamatan</td><td>".$nama_kecamatan."</td></tr>
			<tr><td>Kab./Kota</td><td>".$nama_dt2."</td></tr>
			<tr><td>Jalur Pendaftaran</td><td>".$jalur."</td></tr>
			<tr><td>Jenjang Sekolah Tujuan</td><td>".$nama_tipe_sekolah."</td></tr>";

			if($tipe_sekolah_id=='1'){
				echo "<tr><td>Sekolah Tujuan (pilihan ke)</td><td>".$nama_sekolah." (".$sekolah_pilihan_ke.")</td></tr>";
			}else{
				echo "
				<tr><td>Sekolah Tujuan</td><td>".$nama_sekolah."</td></tr>
				<tr><td>Kompetensi Tujuan (pilihan ke)</td><td>".$nama_kompetensi." (".$sekolah_pilihan_ke.")</td></tr>";
			}

			echo "<tr><td>Tgl. Verifikasi</td><td>".indo_date_format($tgl_verifikasi,'longDate')."</td></tr>
			<tr><td>Skor</td><td>".number_format($score)."</td></tr>
			<tr><td>Status</td><td><font color='green'><b>Telah diverifikasi</b></font></td></tr>
			<tr>
			<td></td>
			<td><a class='btn btn-default' href='".base_url().$active_controller."/print_verification/".urlencode($encoded_regid)."/".urlencode($encoded_fieldid)."' target='_blank'><i class='fa fa-print'></i> Cetak</a></td>
			</tr>
		</tbody>
		</table>
	</div>";
?>