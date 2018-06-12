<?php
	echo "
	<div class='col-md-6 col-md-offset-3'>
	<form id='rangking-form' method='POST' action='".base_url().$active_controller."/ranking_process'>
	<input type='hidden' name='ranking_id_pendaftaran' value='".$id_pendaftaran."'/>
	<input type='hidden' name='ranking_sekolah_id' value='".$sekolah_id."'/>
	<input type='hidden' name='ranking_kompetensi_id' value='".$kompetensi_id."'/>
	<input type='hidden' name='ranking_tipe_sekolah_id' value='".$tipe_sekolah_id."'/>
	<input type='hidden' name='ranking_nama_tipe_sekolah' value='".$nama_tipe_sekolah."'/>
	<input type='hidden' name='ranking_jalur_id' value='".$jalur_id."'/>
	<input type='hidden' name='ranking_nama_jalur' value='".$nama_jalur."'/>
	<input type='hidden' name='ranking_no_pendaftaran' value='".$no_pendaftaran."'/>
	<input type='hidden' name='ranking_nama' value='".$nama."'/>
	<input type='hidden' name='ranking_jk' value='".$jk."'/>
	<input type='hidden' name='ranking_sekolah_asal' value='".$sekolah_asal."'/>
	<input type='hidden' name='ranking_alamat' value='".$alamat."'/>
	<input type='hidden' name='ranking_nama_kecamatan' value='".$nama_kecamatan."'/>
	<input type='hidden' name='ranking_nama_dt2' value='".$nama_dt2."'/>
	<input type='hidden' name='ranking_nama_sekolah' value='".$nama_sekolah."'/>
	<input type='hidden' name='ranking_sekolah_pilihan_ke' value='".$sekolah_pilihan_ke."'/>
	<input type='hidden' name='ranking_nama_kompetensi' value='".$nama_kompetensi."'/>
	<input type='hidden' name='ranking_tgl_verifikasi' value='".$tgl_verifikasi."'/>

	<table class='table table-bordered table-striped'>
	<tbody>
		<tr><td>No. Registrasi</td><td><b>".$no_pendaftaran."</b></td></tr>
		<tr><td>Nama</td><td>".$nama."</td></tr>
		<tr><td>J. Kelamin</td><td>".($jk=='L'?'Laki-laki':'Perempuan')."</td></tr>		
		<tr><td>Sekolah Asal</td><td>".$sekolah_asal."</td></tr>
		<tr><td>Alamat</td><td>".$alamat."</td></tr>
		<tr><td>Kecamatan</td><td>".$nama_kecamatan."</td></tr>
		<tr><td>Kab./Kota</td><td>".$nama_dt2."</td></tr>
		<tr><td>Jalur Pendaftaran</td><td>".$nama_jalur."</td></tr>
		<tr><td>Jenjang Sekolah Tujuan</td><td>".$nama_tipe_sekolah."</td></tr>";

		if($tipe_sekolah_id=='1'){
			echo "<tr><td>Sekolah Tujuan (pilihan ke)</td><td>".$nama_sekolah." (".$sekolah_pilihan_ke.")</td></tr>";
		}else{
			echo "
			<tr><td>Sekolah Tujuan</td><td>".$nama_sekolah."</td></tr>
			<tr><td>Kompetensi Tujuan (pilihan ke)</td><td>".$nama_kompetensi." (".$sekolah_pilihan_ke.")</td></tr>";
		}

		echo "<tr><td>Tgl. Verifikasi</td><td>".indo_date_format($tgl_verifikasi,'longDate')."</td></tr>
		<tr><td>Status</td><td><font color='green'><b>".($status_pendaftaran=='1'?'Lulus Berkas':'Gagal Berkas')."</b></font></td></tr>";

		if($status_pendaftaran=='1')
			echo "<tr><td></td><td><button type='submit' class='btn btn-primary'>Tetapkan Peringkat</button></td></tr>";

	echo "</tbody>
	</table>
	</form>
	</div>";
?>

<script type="text/javascript">
	var $ranking_form=$('#rangking-form');
    var ranking_stat=$ranking_form.validate();

    $ranking_form.submit(function(){
    	
        if(ranking_stat.checkForm())
        {

        	ajax_object.reset_object();
            ajax_object.set_content('#verification-container')
                          .set_loading('#preloadAnimation')
                          .enable_pnotify()
                          .set_form($ranking_form)
                          .submit_ajax('menetapkan peringkat');
            return false;
        }

    });
</script>