<!DOCTYPE html>
<html>
	<head>
		<title>Data Registrasi PPDB 2018</title>
		<link rel="stylesheet" type="text/css" href="<?=$this->config->item('css_path');?>report-style.css"/>		
		<style type="text/css">@import "<?=$this->config->item('css_path');?>report-table-style.css";</style>
	</head>
	<body>
		<div style="margin:20px;">
			<div class="fluid">				
				<img src="<?=$this->config->item('img_path');?>logo_ppdb.png" width="160px" style="float:left"/>				
				<div style="float:left">
					<h3>DATA PENDAFTARAN PPDB ONLINE<br />
						PROVINSI SULAWESI SELATAN TAHUN 2018</h3>
				</div>
				<div style="clear:both"></div>
			</div>
			<br />
			<div class="fluid">
				<div class="grid3">
					<?php
						if($this->session->userdata('gambar')==''){
				            $src = $this->config->item('img_path').'default_photo.png';
				        }else{
				            $src = $this->config->item('upload_path').'registration/'.$this->session->userdata('gambar');
				        }
				    ?>
				    <img src="<?=$src;?>" style="width:100%"/>
				</div>
				<div class="grid9">
					<table class="report" cellpadding="0" cellspacing="0">
						<tbody>							
							<?php
							echo "
								<tr><td>No. Peserta</td><td>".$no_peserta."</td></tr>
								<tr><td>No. Registrasi</td><td><b>".$no_registrasi."</b></td></tr>
								<tr><td>Nama</td><td>".$nama."</td></tr>
								<tr><td>J. Kelamin</td><td>".($jk=='L'?'Laki-laki':'Perempuan')."</td></tr>
								<tr><td>Sekolah Asal</td><td>".$sekolah_asal."</td></tr>
								<tr><td>Alamat</td><td>".$alamat."</td></tr>
								<tr><td>Kecamatan</td><td>".$kecamatan."</td></tr>						
								<tr><td>Kota/Kab.</td><td>".$nm_dt2."</td></tr>
								<tr><td>Jalur Pendaftaran</td><td>".$jalur_pendaftaran['nama_jalur']."</td></tr>
								<tr><td>Jenjang Sekolah Pilihan</td><td>".$tipe_sekolah['nama_tipe_sekolah']." (".$tipe_sekolah['akronim'].")</td></tr>
								<tr><td valign='top'>Sekolah Pilihan</td>
									<td>
										<ol type='1'>";
											foreach($sekolah_pilihan_arr as $item){
												echo "<li>".$item."</li>";
											}
										echo "</ol>
									</td>
								</tr>";							
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>