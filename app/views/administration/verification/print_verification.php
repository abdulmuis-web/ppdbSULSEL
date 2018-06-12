<!DOCTYPE html>
<html>
	<head>
		<title>PPDB Online Prov. <?=$this->_SYS_PARAMS[2]." Tahun ".date('Y');?> | Hasil Verifikasi</title>
		<link rel="stylesheet" type="text/css" href="<?=$this->config->item('css_path');?>report-style.css"/>		
		<style type="text/css">@import "<?=$this->config->item('css_path');?>report-table-style.css";</style>
	</head>
	<body>
		<div style="margin:20px;">
			<div class="fluid">
					<img src="<?=$this->config->item('img_path');?>logo_sulsel.png" width="48px" style="float:left"/>
					<div style="margin-left:10px;margin-top:5px;float:left">
					<h3>
						<?php
						echo "
						DINAS PENDIDIKAN PROVINSI ".strtoupper($this->_SYS_PARAMS[2])."<br />
						".strtoupper($this->session->userdata('nama_sekolah'))."<br />";
						?>						
					</h3>
					Hasil Verifikasi PPDB Online
					</div>
				
				<div style="clear:both"></div>
			</div>
			<br />
			<div class="fluid">				
				<div class="grid12">					
					<?php	
					echo "
					<table class='report' cellpadding='0' cellspacing='0'>
						<tbody>
							<tr><td>No. Registrasi</td><td><b>".$pendaftaran_row['no_pendaftaran']."</b></td></tr>
							<tr><td>Nama</td><td>".$pendaftaran_row['nama']."</td></tr>
							<tr><td>J. Kelamin</td><td>".($pendaftaran_row['jk']=='L'?'Laki-laki':'Perempuan')."</td></tr>
							<tr><td>Sekolah Asal</td><td>".$pendaftaran_row['sekolah_asal']."</td></tr>
							<tr><td>Alamat</td><td>".$pendaftaran_row['alamat']."</td></tr>
							<tr><td>Kecamatan</td><td>".$pendaftaran_row['nama_kecamatan']."</td></tr>
							<tr><td>Kab./Kota</td><td>".$pendaftaran_row['nama_dt2']."</td></tr>
							<tr><td>Jalur Pendaftaran</td><td>".$pendaftaran_row['nama_jalur']."</td></tr>
							<tr><td>Jenjang Sekolah Tujuan</td><td>".$sekolah_pilihan_row['nama_tipe_sekolah']."</td></tr>";

							if($sekolah_pilihan_row['tipe_sekolah_id']=='1'){
								echo "<tr><td>Sekolah Tujuan (pilihan ke)</td><td>".$sekolah_pilihan_row['nama_sekolah']." (".$sekolah_pilihan_row['pilihan_ke'].")</td></tr>";
							}else{
								echo "
								<tr><td>Sekolah Tujuan</td><td>".$sekolah_pilihan_row['nama_sekolah']."</td></tr>
								<tr><td>Kompetensi Tujuan (pilihan ke)</td><td>".$sekolah_pilihan_row['nama_kompetensi']." (".$sekolah_pilihan_row['pilihan_ke'].")</td></tr>";
							}

							echo "<tr><td>Tgl. Verifikasi</td><td>".indo_date_format($log_status_row['tgl_verifikasi'],'longDate')."</td></tr>
							<tr><td>Skor</td><td>".number_format($sekolah_pilihan_row['score'])."</td></tr>
							<tr><td>Status</td><td><b>Telah diverifikasi</b></td></tr>
						</tbody>
					</table><br />
					<table width='100%'>
						<tr>
							<td width='50%'></td>
							<td align='right'>". ucwords(strtolower($this->session->userdata('dt2'))).", ".indo_date_format(date('Y-m-d'),'longDate')."</td>
						</tr>
						<tr><td colspan='2'><br /></td></tr>
						<tr>
							<td align='center'>
								Petugas Verifikasi,<br /><br /><br /><br /><br />
								<b><u>".$this->session->userdata('fullname')."</u></b>
							</td>
							<td align='center'>
								Calon Siswa,<br /><br /><br /><br /><br />
								<b><u>".$pendaftaran_row['nama']."</u></b>
							</td>
						</tr>
					</table>";
					?>
				</div>
			</div>
		</div>
	</body>
</html>