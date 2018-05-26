<div class="container-fluid box">
	<div style="padding:15px">
		<div class="row">
			<div class="col-lg-4 col-md-4" id="submit-result-photo">
				<?php
					if($this->session->userdata('gambar')==''){
			            $src = $this->config->item('img_path').'default_photo.png';
			        }else{
			            $src = $this->config->item('upload_path').'pendaftar/'.$this->session->userdata('gambar');
			        }
				?>
				<img src="<?=$src;?>" style="width:100%" class="img-thumbnail"/><br /><br />
				<center><button type="button" class="btn btn-default btn-xs"><i class="fa fa-upload"></i> Unggah Foto</button></center>
			</div>
			<div class="col-lg-8 col-md-8">
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
						<tr><td>Zona</td><td>".$nm_zona."</td></tr>
						<tr><td>Kota/Kab.</td><td>".$nm_dt2."</td></tr>
						<tr><td>Jalur Pendaftaran</td><td>".$jalur_pendaftaran['nama_jalur']."</td></tr>
						<tr><td>Jenjang Sekolah Pilihan</td><td>".$tipe_sekolah['nama_tipe_sekolah']." (".$tipe_sekolah['akronim'].")</td></tr>
						<tr><td>Sekolah Pilihan</td>
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
					<tfoot>
						<tr>
							<td colspan="2" align="right">
								<a href="<?=base_url()."reg/reg_receipt_pdf/".$no_registrasi;?>" target="_blank" class="txt-btn"><b><i class="fa fa-file-pdf-o"></i> PDF</b></a>&nbsp;|&nbsp;
								<a href="<?=base_url()."reg/reg_receipt_print/".$no_registrasi;?>" target="_blank" class="txt-btn"><b><i class="fa fa-print"></i> Cetak</b></a>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>