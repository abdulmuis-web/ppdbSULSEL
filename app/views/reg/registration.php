<div class="container-fluid box">
	<fieldset style="padding:15px;">
		<div class="alert alert-danger">
		  <strong>Perhatian!</strong> Lengkapi formulir di bawah ini dengan data yang benar. <br />
		  Perhatikan kembali data yang telah diisi sebelum menekan tombol Submit karena penginputan data hanya sekali saja!
		</div>
		<form action="" id="reg-form" method="POST" class="form-horizontal">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label col-md-4" for="input_no_pendaftaran">No. Peserta</label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control" id="input_no_pendaftaran" type="text" name="input_no_pendaftaran" value="<?=$this->session->userdata('nopes');?>" readonly>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="input_nama">Nama</label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control" id="input_nama" type="text" name="input_nama" value="<?=$this->session->userdata('nama');?>" readonly>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="input_jk">J. Kelamin</label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control" id="input_jk" type="text" name="input_jk" value="<?=($this->session->userdata('jk')=='L'?'Laki-laki':'Perempuan');?>" readonly>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="input_sekolah_asal">Sekolah Asal</label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control" id="input_sekolah_asal" type="text" name="input_sekolah_asal" value="<?=$this->session->userdata('sklh_asal');?>" readonly>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="input_ttl">Tempat, Tgl. Lahir</label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control" id="input_ttl" type="text" name="input_ttl" value="<?=$peserta_row['tpt_lahir'].", ".indo_date_format($peserta_row['tgl_lahir'],'shortDate');?>" readonly>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label col-md-4" for="input_alamat">Alamat</label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control" id="input_almt" type="text" name="input_almt" value="<?=$this->session->userdata('alamat');?>" readonly>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="input_dt2">Kab./Kota</label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control" id="input_dt2" type="text" name="input_dt2" value="<?=$this->session->userdata('nm_dt2');?>" readonly>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="input_kecamatan">Kecamatan <font color="red">*</font></label>
						<div class="col-md-8">
							<div class="input">
								<select name="input_kecamatan" id="input_kecamatan" onchange="get_villages(this.value,'<?=$kuota_jalur_row['jml_sekolah'];?>')" class="form-control" required>
									<option value=""></option>
									<?php
										foreach($kecamatan_rows as $row){
											echo "<option value='".$row['kecamatan_id']."'>".$row['nama_kecamatan']."</option>";
										}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="input_kelurahan ">Kelurahan <font color="red">*</font></label>
						<div class="col-md-8">
							<div class="input">
								<div id="input_kelurahan_loader" style="display:none">
									<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/><br />
								</div>
								<select name="input_kelurahan" id="input_kelurahan" class="form-control" required>
									<option value="">- Pilih Kecamatan lebih dulu -</option>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="input_no_telp">No. Telepon</label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control" id="input_no_telp" type="text" name="input_no_telp" value="">
							</div>
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<div class="col-md-12" align="right">
							<h4><u>Nilai Ujian Nasional SMP Thn. <?=date('Y');?></u></h4>
						</div>
					</div>

					<?php

					if($peserta_row['tipe_ujian_smp']=='2')
					{
						echo "
						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_pkn'>PKN <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control' id='input_nil_pkn' type='text' name='input_nil_pkn' onkeypress=\"return only_number(this,event);\" value='".$peserta_row['nil_pkn']."'>
								</div>
							</div>
						</div>";
					}

					echo "
						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_bhs_indonesia'>Bhs. Indonesia <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control' id='input_nil_bhs_indonesia' type='text' name='input_nil_bhs_indonesia' onkeypress=\"return only_number(this,event);\" value='".$peserta_row['nil_bhs_indonesia']."'>
								</div>
							</div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_bhs_inggris'>Bhs. Inggris <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control' id='input_nil_bhs_inggris' type='text' name='input_nil_bhs_inggris' onkeypress=\"return only_number(this,event);\" value='".$peserta_row['nil_bhs_inggris']."'>
								</div>
							</div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_matematika'>Matematika <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control' id='input_nil_matematika' type='text' name='input_nil_matematika' onkeypress=\"return only_number(this,event);\" value='".$peserta_row['nil_matematika']."'>
								</div>
							</div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_ipa'>IPA <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control' id='input_nil_ipa' type='text' name='input_nil_ipa' onkeypress=\"return only_number(this,event);\" value='".$peserta_row['nil_ipa']."'>
								</div>
							</div>
						</div>";


					if($peserta_row['tipe_ujian_smp']=='2')
					{
						echo "
						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_ips'>IPS <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control' id='input_nil_ips' type='text' name='input_nil_ips' onkeypress=\"return only_number(this,event);\" value='".$peserta_row['nil_ips']."'>
								</div>
							</div>
						</div>";
					}

					echo "<div class='form-group'>
							<label class='control-label col-md-4' for='input_tot_nilai'>Total Nilai</label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control' id='input_tot_nilai' type='text' name='input_tot_nilai' value='".$peserta_row['tot_nilai']."' readonly>
								</div>
							</div>
						</div>";


					?>


				</div>

				<div class="col-md-6">
					<div class="form-group">
						<div class="col-md-12" align="right">
							<h4><u>Berkas Kelengkapan Pendaftaran</u></h4>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12">
							<table class="table table-bordered table-hover">
								<tbody>
									<?php
										foreach($dokumen_persyaratan_rows as $row){
											echo "
											<tr>
												<td><input type='checkbox'> ".$row['nama_dokumen']."
											</tr>";
										}
									?>
									
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<div class="col-md-12" align="right">
							<h4><u>Sekolah Tujuan</u></h4>
						</div>
					</div>
					<div id="dest-school-loader" style="display:none" align="right">
						<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/><br />
					</div>
					<div id="dest-school">
						<?php
							for($i=1;$i<=$kuota_jalur_row['jml_sekolah'];$i++)
							{
								echo "
								<div class='form-group'>
									<label class='control-label col-md-4'>Sekolah-".$i." ".($i==1?"<font color='red'>*</font>":"")."</label>
									<div class='col-md-8'>
										<div class='input'>							
											<select name='input_sekolah_tujuan".$i."' id='input_sekolah_tujuan".$i."' class='form-control' required>
												<option value=''>- Pilih Kecamatan lebih dulu -</option>
											</select>
										</div>
									</div>
								</div>";
							}
						?>
					</div>
				</div>
				<div class="col-md-6">
					
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<hr></hr>
					<center>
						<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>
					</center>
				</div>
			</div>
		</form>
	</fieldset>
</div>

<script type="text/javascript">
	function get_villages(district_val,path_quota){

		$.ajax({
          type:'POST',
          url:$('#baseUrl').val()+'reg/get_village_destSchool',
          data:'district='+district_val+'&path_quota='+path_quota+'&type=1',
          beforeSend:function(){    
            $('#input_kelurahan_loader').show();
            $('#dest-school-loader').show();
            $('#input_kelurahan').hide();
            $('#dest-school').hide();
          },
          success:function(data){
                        
            $('#input_kelurahan_loader').hide();
            $('#dest-school-loader').hide();

            x = data.split('#%%#');
            $('#input_kelurahan').html(x[0]);
            $('#dest-school').html(x[1]);

            $('#input_kelurahan').show();
            $('#dest-school').show();
          }
        });

	}
</script>