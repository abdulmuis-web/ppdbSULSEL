<script type="text/javascript" src="<?=$this->config->item('js_path');?>my_scripts/ajax_upload.js"></script>

<div class="container-fluid box">
	<div style="padding:15px">
		<div class="row">			
			<div class="col-lg-12 col-md-12">
				<table class="table table-bordered">
					<thead>
						<th colspan="2"><i class="fa fa-file-text-o"></i> DATA PENDAFTARAN</th>
					</thead>
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
						<tr><td>Kab./Kota</td><td>".$nm_dt2."</td></tr>
						<tr><td>Jalur Pendaftaran</td><td>".$jalur_pendaftaran['nama_jalur']."</td></tr>
						<tr><td>Jenjang Sekolah Pilihan</td><td>".$tipe_sekolah['nama_tipe_sekolah']." (".$tipe_sekolah['akronim'].")</td></tr>
						<tr><td>".strtoupper($tipe_sekolah['akronim'])." Pilihan</td>
							<td>
								<ol type='1' style='margin:0;margin-left:15px;padding:0'>";
									foreach($sekolah_pilihan_arr as $item){
										echo "<li>".$item."</li>";
									}
								echo "</ol>
							</td>
						</tr>
						<tr><td>Tgl. Pendaftaran</td><td>".indo_date_format($tgl_pendaftaran,'longDate')."</td></tr>";
						if($show_passphrase=='1'){
							echo "<tr><td>Password</td><td><b>".$passphrase."</b> <br /><small>*<font color='red'>Password ini diperlukan saat login selanjutnya!</font></small></td></tr>";
						}
						?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2" align="right">
								<a href="<?=base_url()."reg/reg_data_pdf/".urlencode($encoded_nopes);?>" target="_blank" class="txt-btn"><b><i class="fa fa-file-pdf-o"></i> PDF</b></a>&nbsp;|&nbsp;
								<a href="<?=base_url()."reg/reg_data_print/".urlencode($encoded_nopes);?>" target="_blank" class="txt-btn"><b><i class="fa fa-print"></i> Cetak</b></a>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>

	
</div>