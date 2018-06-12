<?php

	if($error>0)
	{
		
		switch($error){
			case 1:$warning="Data tidak ditemukan";break;
			case 2:$warning="Sudah pernah melakukan verifikasi di salah satu sekolah pilihan, proses reset tidak bisa dilanjutkan!";break;
			default:$warning='kesalahan tidak diketahui';break;
		}		
			

		echo "<br />
		<div class='alert alert-warning'>
			<strong>Perhatian!</strong> ".$warning."
		</div>";
		die();
	}
?>

	<hr></hr>
				
	<div class="row" id="verification-container">
		<form id="reset-form" novalidate="novalidate" method="POST" action="<?=base_url();?>administration/submit_reset_registration">
			<input type="hidden" id="img_path" value="<?=$this->config->item('img_path');?>"/>
			<input type="hidden" name="reset_id_pendaftaran" value="<?=$pendaftaran_row['id_pendaftaran'];?>"/>
			<input type="hidden" name="reset_no_pendaftaran" value="<?=$pendaftaran_row['no_pendaftaran'];?>"/>
			<input type="hidden" name="reset_nama" value="<?=$pendaftaran_row['nama'];?>"/>
			<input type="hidden" name="reset_jk" value="<?=$pendaftaran_row['jk'];?>"/>
			<input type="hidden" name="reset_alamat" value="<?=$pendaftaran_row['alamat'];?>"/>
			<input type="hidden" name="reset_sekolah_asal" value="<?=$pendaftaran_row['sekolah_asal'];?>"/>
			<input type="hidden" name="reset_jalur_id" value="<?=$pendaftaran_row['jalur_id'];?>"/>
			<input type="hidden" name="reset_nama_jalur" value="<?=$pendaftaran_row['nama_jalur'];?>"/>
			<input type="hidden" name="reset_tipe_sekolah" value="<?=$pendaftaran_row['nama_tipe_sekolah']." (".$pendaftaran_row['akronim'].")";?>"/>

			
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
								<tr><td>Jenjang</td><td>".$pendaftaran_row['nama_tipe_sekolah']." (".$pendaftaran_row['akronim'].")</td></tr>
								<tr><td></td><td><button type='submit' class='btn btn-primary'>Reset</button></td></tr>
							</tbody>
							</table>";
					?>
				</div>
			</div>
		</form>
	</div>

<script type="text/javascript">
		
    var $reset_form=$('#reset-form');
    var reset_stat=$reset_form.validate();

    $reset_form.submit(function(){
    	
        if(reset_stat.checkForm())
        {

        	ajax_object.reset_object();
            ajax_object.set_content('#verification-container')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($reset_form)
                           .submit_ajax('menyimpan data');
            return false;
        }

    });    
	
</script>
