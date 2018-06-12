<?php
	
	if($error>0)
	{		
		switch($error){
			case 1:$warning="Data tidak ditemukan";break;
			case 2:$warning="Data sudah terdaftar ulang";break;
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
		<form id="settlement-form" novalidate="novalidate" method="POST" action="<?=base_url().$active_controller;?>/submit_settlement">
			<input type="hidden" id="img_path" value="<?=$this->config->item('img_path');?>"/>
			<input type="hidden" name="verifikasi_id_pendaftaran" value="<?=$pendaftaran_row['id_pendaftaran'];?>"/>
			<input type="hidden" name="verifikasi_no_pendaftaran" value="<?=$pendaftaran_row['no_pendaftaran'];?>"/>
			<input type="hidden" name="verifikasi_nama" value="<?=$pendaftaran_row['nama'];?>"/>
			<input type="hidden" name="verifikasi_jk" value="<?=$pendaftaran_row['jk'];?>"/>
			<input type="hidden" name="verifikasi_alamat" value="<?=$pendaftaran_row['alamat'];?>"/>
			<input type="hidden" name="verifikasi_nama_kecamatan" value="<?=$pendaftaran_row['nama_kecamatan'];?>"/>
			<input type="hidden" name="verifikasi_nama_dt2" value="<?=$pendaftaran_row['nama_dt2'];?>"/>
			<input type="hidden" name="verifikasi_sekolah_asal" value="<?=$pendaftaran_row['sekolah_asal'];?>"/>
			<input type="hidden" name="verifikasi_sekolah_id" value="<?=$sekolah_pilihan_row['sekolah_id'];?>"/>
			<input type="hidden" name="verifikasi_nama_sekolah" value="<?=$sekolah_pilihan_row['nama_sekolah'];?>"/>
			<input type="hidden" name="verifikasi_sekolah_pilihan_ke" value="<?=$sekolah_pilihan_row['pilihan_ke'];?>"/>
			<input type="hidden" name="verifikasi_jalur_id" value="<?=$pendaftaran_row['jalur_id'];?>"/>
			<input type="hidden" name="verifikasi_nama_jalur" value="<?=$pendaftaran_row['nama_jalur'];?>"/>
			<input type="hidden" name="verifikasi_tipe_jalur" value="<?=$pendaftaran_row['tipe_jalur'];?>"/>
			<input type="hidden" name="verifikasi_tipe_sekolah_id" value="<?=$sekolah_pilihan_row['tipe_sekolah_id'];?>"/>
			<input type="hidden" name="verifikasi_nama_tipe_sekolah" value="<?=$sekolah_pilihan_row['nama_tipe_sekolah']." (".$sekolah_pilihan_row['akronim'].")";?>"/>
			<input type="hidden" name="verifikasi_kompetensi_id" value="<?=$sekolah_pilihan_row['kompetensi_id'];?>"/>
			
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<?php
						echo "
						<table class='table table-bordered table-striped'>
							<tbody>
								<tr><td>No. Registrasi</td><td><b>".$pendaftaran_row['no_pendaftaran']."</b></td></tr>
								<tr><td>Nama</td><td>".$pendaftaran_row['nama']."</td></tr>
								<tr><td>J. Kelamin</td><td>".($pendaftaran_row['jk']=='L'?'Laki-laki':'Perempuan')."</td></tr>
								<tr><td>Sekolah Asal</td><td>".$pendaftaran_row['sekolah_asal']."</td></tr>
								<tr><td>Alamat</td><td>".$pendaftaran_row['alamat']."</td></tr>
								<tr><td>Kecamatan</td><td>".$pendaftaran_row['nama_kecamatan']."</td></tr>
								<tr><td>Kab./Kota</td><td>".$pendaftaran_row['nama_dt2']."</td></tr>
								<tr><td>Jalur Pendaftaran</td><td>".$pendaftaran_row['nama_jalur']."</td></tr>
								<tr><td>Jenjang Skolah Tujuan</td><td>".$sekolah_pilihan_row['nama_tipe_sekolah']." (".$sekolah_pilihan_row['akronim'].")</td></tr>";

								if($sekolah_pilihan_row['tipe_sekolah_id']=='1'){
									echo "<tr><td>Sekolah Tujuan (pilihan ke)</td><td>".$sekolah_pilihan_row['nama_sekolah']." (".$sekolah_pilihan_row['pilihan_ke'].")</td></tr>";
								}else{
									echo "
									<tr><td>Sekolah Tujuan</td><td>".$sekolah_pilihan_row['nama_sekolah']."</td></tr>									
									<tr><td>Kompetensi Tujuan (pilihan ke)</td><td>".$sekolah_pilihan_row['nama_kompetensi']." (".$sekolah_pilihan_row['pilihan_ke'].")</td></tr>";
								}

								echo "<tr><td></td><td><button type='submit' class='btn btn-primary'>Daftar Ulang</button></td></tr>
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
