<?php

	if(!isset($pendaftaran_row) or !isset($sekolah_pilihan_row))
	{
		$warning = "kesalahan tidak diketahui!";

		if(!isset($pendaftaran_row) or !isset($sekolah_pilihan_row))
		{
			$warning = "Data tidak ditemukan!";
		}		

		echo "
		<article class='col-sm-12 col-md-12 col-lg-12'>
			
			<div class='alert alert-warning'>
				<strong>Perhatian!</strong> ".$warning."
			</div>
			
		</article>";
		die();
	}
?>

	<hr></hr>
				
	<div class="row" id="verification-container">
		<form id="settlement-form" novalidate="novalidate" method="POST" action="<?=base_url();?>backoffice/submit_settlement">
			<input type="hidden" id="img_path" value="<?=$this->config->item('img_path');?>"/>
			<input type="hidden" name="verifikasi_id_pendaftaran" value="<?=$pendaftaran_row['id_pendaftaran'];?>"/>
			<input type="hidden" name="verifikasi_no_pendaftaran" value="<?=$pendaftaran_row['no_pendaftaran'];?>"/>
			<input type="hidden" name="verifikasi_nama" value="<?=$pendaftaran_row['nama'];?>"/>
			<input type="hidden" name="verifikasi_jk" value="<?=$pendaftaran_row['jk'];?>"/>
			<input type="hidden" name="verifikasi_alamat" value="<?=$pendaftaran_row['alamat'];?>"/>
			<input type="hidden" name="verifikasi_sekolah_asal" value="<?=$pendaftaran_row['sekolah_asal'];?>"/>
			<input type="hidden" name="verifikasi_sekolah_id" value="<?=$sekolah_pilihan_row['sekolah_id'];?>"/>
			<input type="hidden" name="verifikasi_jalur_id" value="<?=$pendaftaran_row['jalur_id'];?>"/>
			<input type="hidden" name="verifikasi_nama_jalur" value="<?=$pendaftaran_row['nama_jalur'];?>"/>
			<input type="hidden" name="verifikasi_tipe_jalur" value="<?=$pendaftaran_row['tipe_jalur'];?>"/>
			<input type="hidden" name="verifikasi_tipe_sekolah" value="<?=$sekolah_pilihan_row['tipe_sekolah'];?>"/>
			<input type="hidden" name="verifikasi_kompetensi_id" value="<?=$sekolah_pilihan_row['kompetensi_id'];?>"/>
			
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<?php
						echo "
						<table class='table table-bordered table-striped'>
							<tbody>
								<tr><td>No. Registrasi</td><td>".$pendaftaran_row['no_pendaftaran']."</td></tr>
								<tr><td>Nama</td><td>".$pendaftaran_row['nama']."</td></tr>
								<tr><td>J. Kelamin</td><td>".($pendaftaran_row['jk']=='L'?'Laki-laki':'Perempuan')."</td></tr>
								<tr><td>Sekolah Asal</td><td>".$pendaftaran_row['sekolah_asal']."</td></tr>
								<tr><td>Alamat</td><td>".$pendaftaran_row['alamat']."</td></tr>
								<tr><td>Jalur</td><td>".$pendaftaran_row['nama_jalur']."</td></tr>
								<tr><td>Status</td><td>Lulus Seleksi</td></tr>
								<tr><td></td><td><button type='submit' class='btn btn-primary'>Daftar Ulang</button></td></tr>
							</tbody>
							</table>";
					?>
				</div>
			</div>
		</form>
	</div>

<script type="text/javascript">
		
    var $settlement_form=$('#settlement-form');
    var settlement_stat=$settlement_form.validate();

    $settlement_form.submit(function(){
    	
        if(settlement_stat.checkForm())
        {

        	ajax_object.reset_object();
            ajax_object.set_content('#verification-container')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($settlement_form)
                           .submit_ajax('menyimpan data');
            return false;
        }

    });    
	
</script>
