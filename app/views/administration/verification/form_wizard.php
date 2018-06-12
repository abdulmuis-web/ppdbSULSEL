<?php

	if($error>0)
	{
		if($error!=1)
			$prev = $sekolah_pilihan_row['pilihan_ke']-1;

		switch($error){
			case 1:$warning="Data tidak ditemukan";break;
			case 2:$warning="Data sudah diverifikasi";break;
			case 3:$warning="Proses belum bisa dilanjutkan. Silahkan melakukan verifikasi berkas pada 
						    ".($this->session->userdata('tipe_sekolah')=='1'?'Sekolah':'Kompetensi')." pilihan ke - ".$prev." terlebih dahulu!";break;			
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

		<form id="wizard-1" novalidate="novalidate" method="POST" action="<?=base_url().$active_controller;?>/submit_verification">
			<input type="hidden" id="img_path" value="<?=$this->config->item('img_path');?>"/>
			<input type="hidden" name="verifikasi_id_pendaftaran" value="<?=$pendaftaran_row['id_pendaftaran'];?>"/>
			<input type="hidden" name="verifikasi_no_pendaftaran" value="<?=$pendaftaran_row['no_pendaftaran'];?>"/>
			<input type="hidden" name="verifikasi_nama" value="<?=$pendaftaran_row['nama'];?>"/>
			<input type="hidden" name="verifikasi_jk" value="<?=$pendaftaran_row['jk'];?>"/>
			<input type="hidden" name="verifikasi_alamat" value="<?=$pendaftaran_row['alamat'];?>"/>
			
			<input type="hidden" name="verifikasi_nama_kecamatan" value="<?=$pendaftaran_row['nama_kecamatan'];?>"/>
			<input type="hidden" name="verifikasi_nama_dt2" value="<?=$pendaftaran_row['nama_dt2'];?>"/>
			<input type="hidden" name="verifikasi_tipe_sekolah_id" value="<?=$sekolah_pilihan_row['tipe_sekolah_id'];?>"/>
			<input type="hidden" name="verifikasi_nama_tipe_sekolah" value="<?=$sekolah_pilihan_row['nama_tipe_sekolah']." (".$sekolah_pilihan_row['akronim'].")";?>"/>

			<input type="hidden" name="verifikasi_sekolah_asal" value="<?=$pendaftaran_row['sekolah_asal'];?>"/>
			<input type="hidden" name="verifikasi_sekolah_id" value="<?=$sekolah_pilihan_row['sekolah_id'];?>"/>
			<input type="hidden" name="verifikasi_nama_sekolah" value="<?=$sekolah_pilihan_row['nama_sekolah'];?>"/>
			<input type="hidden" name="verifikasi_sekolah_pilihan_ke" value="<?=$sekolah_pilihan_row['pilihan_ke'];?>"/>

			<input type="hidden" name="verifikasi_jalur_id" value="<?=$pendaftaran_row['jalur_id'];?>"/>
			<input type="hidden" name="verifikasi_nama_jalur" value="<?=$pendaftaran_row['nama_jalur'];?>"/>
			<input type="hidden" name="verifikasi_tipe_jalur" value="<?=$pendaftaran_row['tipe_jalur'];?>"/>
			<input type="hidden" name="verifikasi_kompetensi_id" value="<?=$sekolah_pilihan_row['kompetensi_id'];?>"/>
			<input type="hidden" name="verifikasi_nama_kompetensi" value="<?=$sekolah_pilihan_row['nama_kompetensi'];?>"/>

			<div id="bootstrap-wizard-1" class="col-sm-12">
				<div class="form-bootstrapWizard">
					<ul class="bootstrapWizard form-wizard">
						<li class="active" data-target="#step1">
							<a href="#tab1" data-toggle="tab"> <span class="step">1</span> <span class="title">Data Diri & Nilai</span> </a>
						</li>
						<li data-target="#step2">
							<a href="#tab2" data-toggle="tab"> <span class="step">2</span> <span class="title">Berkas</span> </a>
						</li>
						
						<?php
						$nextStep = 3;
						if($sekolah_pilihan_row['tipe_sekolah_id']!='2' and $pendaftaran_row['tipe_jalur']=='1')
						{
							$nextStep++;
							echo "
							<li data-target='#step3'>
								<a href='#tab3' data-toggle='tab'> <span class='step'>3</span> <span class='title'>Zonasi</span> </a>
							</li>";
						}

						if($pendaftaran_row['jalur_id']=='4')
						{
							$nextStep++;
							echo "
							<li data-target='#step3'>
								<a href='#tab3' data-toggle='tab'> <span class='step'>3</span> <span class='title'>Prestasi</span> </a>
							</li>";	
						}
						?>

						<li data-target="#step4">
							<a href="#tab<?=$nextStep;?>" data-toggle="tab"> <span class="step">4</span> <span class="title">Simpan</span> </a>
						</li>
					</ul>
					<div class="clearfix"></div>
				</div>
				<div class="tab-content">
					<div class="tab-pane active" id="tab1">
						<br>
						<h3><strong>Step 1 </strong> - Data Diri & Nilai</h3>
						<?php
						echo "
						<div class='row'>
							<div class='col-md-6'>
								<table class='table table-bordered'>
								<tbody>
									<tr>
										<td>Nama</td>
										<td>".$pendaftaran_row['nama']."</td>
									</tr>
									<tr>
										<td>J. Kelamin</td>
										<td>".($pendaftaran_row['jk']=='L'?'Laki-laki':'Perempuan')."</td>
									</tr>
									<tr>
										<td>Tempat/Tgl. Lahir</td>
										<td>".$pendaftaran_row['tpt_lahir'].", ".indo_date_format($pendaftaran_row['tgl_lahir'],'longDate')."</td>
									</tr>
									<tr>
										<td>Sekolah Asal</td>
										<td>".$pendaftaran_row['sekolah_asal']."</td>
									</tr>";
									if($sekolah_pilihan_row['tipe_sekolah_id']=='1')
									{
										echo "
										<tr>
											<td>Sekolah Tujuan (pilihan ke)</td>
											<td>".$sekolah_pilihan_row['nama_sekolah']." (".$sekolah_pilihan_row['pilihan_ke'].")</td>
										</tr>";
									}else{
										echo "
										<tr><td>Sekolah Tujuan</td><td>".$sekolah_pilihan_row['nama_sekolah']."</td></tr>
										<tr><td>Kompetensi Tujuan (pilihan ke)</td>
										<td>".$sekolah_pilihan_row['nama_kompetensi']." (".$sekolah_pilihan_row['pilihan_ke'].")</td>
										</tr>";
									}
								echo "</tbody>
								</table>
							</div>

							<div class='col-md-6'>
								<table class='table table-bordered'>
								<tbody>
									<tr>
										<td>Nama Orang Tua</td>
										<td>".$pendaftaran_row['nm_orang_tua']."</td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td>".$pendaftaran_row['alamat']."</td>
									</tr>
									<tr>
										<td>Kecamatan</td>
										<td>".$pendaftaran_row['nama_kecamatan']."</td>
									</tr>
									<tr>
										<td>Kab./Kota</td>
										<td>".$pendaftaran_row['nama_dt2']."</td>
									</tr>
									<tr>
										<td style='background:#adadad;color:white'><b>Jalur Pilihan</b></td>
										<td>".$pendaftaran_row['nama_jalur']."</td>
									</tr>
								</tbody>
								</table>
							</div>
						</div>
						
						<div class='row'>
							<div class='col-md-12'>
								<table class='table table-border table-hover'>
									<thead>
										<tr><th>Mata Pelajaran</th><th>Nilai</th><th></th></tr>
									</thead>
									<tbody>
										<tr><td>Bahasa Indonesia</td><td>".$pendaftaran_row['nil_bhs_indonesia']."</td>
										<td><input type='checkbox' name='verifikasi_nil_bhs_indonesia' value='1'/>&nbsp;Valid</td></tr>
										<tr><td>Bahasa Inggris</td><td>".$pendaftaran_row['nil_bhs_inggris']."</td>
										<td><input type='checkbox' name='verifikasi_nil_bhs_inggris' value='1'/>&nbsp;Valid</td></tr>
										<tr><td>Bahasa Matematika</td><td>".$pendaftaran_row['nil_matematika']."</td>
										<td><input type='checkbox' name='verifikasi_nil_matematika' value='1'/>&nbsp;Valid</td></tr>
										<tr><td>Bahasa IPA</td><td>".$pendaftaran_row['nil_ipa']."</td>
										<td><input type='checkbox' name='verifikasi_nil_ipa' value='1'/>&nbsp;Valid</td></tr>
										<tr><td>Total Nilai</td><td>".$pendaftaran_row['tot_nilai']."</td>
										<td><input type='checkbox' name='verifikasi_tot_nilai' value='1'/>&nbsp;Valid</td></tr>
									</tbody>
								</table>
							</div>
						</div>";
						?>

					</div>
					<div class="tab-pane" id="tab2">
						<br>
						<h3><strong>Step 2</strong> - Verifikasi Berkas
							<div class="btn-group pull-right">
							<button class="btn btn-default" type="button">
								Cek Berkas
							</button>
							<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li>
									<a href="javascript:void(0);" onclick="window.open('https://www.w3schools.com', '_blank', 'toolbar=no,scrollbars=yes,resizable=yes,top=0,left=0,width=600,height=800');">Kartu Keluarga</a>
								</li>								
							</ul>
						</div>
						</h3>

						<div class="row">
							<div class="col-md-12">
								<table class="table table-border table-hover">
									<thead>
										<tr>
											<th colspan="2">Nama Berkas</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$i = 0;
											foreach($dokumen_rows as $row){
												$i++;
												echo "<tr>
												<td>".$row['nama_dokumen']."</td>
												<td><input type='checkbox' name='verifikasi_berkas".$i."' value='1'/>
												<input type='hidden' name='verifikasi_berkas_id".$i."' value='".$row['dokel_id']."'/>
												&nbsp;Valid</td>
												</tr>";
											}
										?>
									</tbody>
								</table>
								<input type="hidden" name="verifikasi_n_berkas" value="<?=$i;?>"/>
							</div>										
						</div>									
					</div>

					<?php
					$nextTab = 3;
					if($sekolah_pilihan_row['tipe_sekolah_id']!='2' and $pendaftaran_row['tipe_jalur']=='1')
					{
						$nextTab++;
						echo "
						<div class='tab-pane' id='tab3'>
							<input type='hidden' id='school_latitide' value='".$sekolah_pilihan_row['latitude']."'/>
							<input type='hidden' id='school_longitude' value='".$sekolah_pilihan_row['longitude']."'/>
							<input type='hidden' id='school_name' value='".$sekolah_pilihan_row['nama_sekolah']."'/>
							<input type='hidden' id='reg_address' value='".$pendaftaran_row['alamat'].", ".$pendaftaran_row['nama_kecamatan'].", ".$pendaftaran_row['nama_dt2']."' readonly/>
							<br>
							<h3><strong>Step 3</strong> - Zonasi</h3>
							<div class='row'>
								<div class='col-md-12'>
									<div id='map' style='height:500px!important;width:100%;border;1px solid #cccccc;'></div><br />
									<div class='alert alert-warning'>
										<strong>Perhatian!</strong> Klik tombol 'Mulai Menghitung Jarak' kemudian tarik Marker (Penunjuk Lokasi) ke titik domisili Peserta
									</div>
									<table class='table table-bordered'>
										<tbody>
											<tr><td colspan='2' align='center'>
												<button class='btn btn-default' id='startDistanceCalculation'><i class='fa fa-road'></i> Mulai Menghitung Jarak</button></td></tr>
											<tr><td width='30%' align='right'>Alamat Sekolah</td>
												<td><input type='text' class='form-control' value='".$sekolah_pilihan_row['alamat_sekolah']."' id='school_LatLang' readonly/></td></tr>
											<tr>
												<td align='right'>Alamat Peserta</td>
												<td>
													<input type='text' class='form-control' id='reg_address' value='".$pendaftaran_row['alamat']."' readonly/>
												</td>
											</tr>
											<tr>
												<td align='right'>Jarak</td>
												<td><input type='text' class='form-control' id='distance' name='verifikasi_jarak' readonly required/></td>														
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>";
					}

					if($pendaftaran_row['jalur_id']=='4')
					{
						$nextTab++;
						echo "
						<div class='tab-pane' id='tab3'>										
							<br>
							<h3><strong>Step 3</strong> - Verifikasi Prestasi</h3>
							<div class='row'>
								<div class='col-md-12'>
									<table class='table table-border table-hover'>
										<thead>
											<tr>
												<th>Tingkat</th><th>Bidang</th><th>No. Sertifikat</th><th>Nama Kejuaraan</th><th>Tahun</th><th>Peringkat</th><th></th>
											</tr>
										</thead>
										<tbody>";
											
											$i = 0;
											foreach($prestasi_rows as $row){
												$i++;
												echo "<tr>
												<td>".$row['tingkat_kejuaraan']."</td>
												<td>".$row['bidang_kejuaraan']."</td>
												<td>".$row['no_sertifikat']."</td>
												<td>".$row['nm_kejuaraan']."</td>
												<td align='center'>".$row['thn_kejuaraan']."</td>
												<td align='center'>".$row['peringkat']."</td>
												<td>
												<input type='checkbox' name='verifikasi_prestasi".$i."' value='1'/>
												<input type='hidden' name='verifikasi_prestasi_id".$i."' value='".$row['prestasi_id']."'/>
												&nbsp;Valid</td>
												</tr>";
											}
											
										echo "</tbody>
									</table>
									<input type='hidden' name='verifikasi_n_prestasi' value='".$i."'/>
								</div>
							</div>
						</div>";
					}

					?>


					<div class="tab-pane" id="tab<?=$nextTab;?>" align="center">
						<br /><br />
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>

					<div class="form-actions">
						<div class="row">
							<div class="col-sm-12">
								<ul class="pager wizard no-margin">
									<!--<li class="previous first disabled">
									<a href="javascript:void(0);" class="btn btn-lg btn-default"> First </a>
									</li>-->
									<li class="previous disabled">
										<a href="javascript:void(0);" class="btn btn-lg btn-default"> Previous </a>
									</li>
									<!--<li class="next last">
									<a href="javascript:void(0);" class="btn btn-lg btn-primary"> Last </a>
									</li>-->
									<li class="next">
										<a href="javascript:void(0);" class="btn btn-lg txt-color-darken"> Next </a>
									</li>
								</ul>
							</div>
						</div>
					</div>

				</div>
			</div>
		</form>
	</div>

		

<?php 
if($sekolah_pilihan_row['tipe_sekolah_id']!='2' and $pendaftaran_row['tipe_jalur']=='1')
{
?>
	<script type="text/javascript" src="<?=$this->config->item('js_path');?>my_scripts/distance_measurement.js"></script>
<?php
}
?>

<script type="text/javascript">
	//Bootstrap Wizard Validations
	$(document).ready(function(){


		$('input').iCheck({
		    checkboxClass: 'icheckbox_square-blue',
		    radioClass: 'iradio_square-blue',
		    increaseArea: '20%' // optional
		  });



	  var $validator = $("#wizard-1").validate({	    
	    
	    highlight: function (element) {
	      $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
	    },
	    unhighlight: function (element) {
	      $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
	    },
	    errorElement: 'span',
	    errorClass: 'help-block',
	    errorPlacement: function (error, element) {
	      if (element.parent('.input-group').length) {
	        error.insertAfter(element.parent());
	      } else {
	        error.insertAfter(element);
	      }
	    }
	  });
	  

	  $('#bootstrap-wizard-1').bootstrapWizard({
	    'tabClass': 'form-wizard',
	    'onNext': function (tab, navigation, index) {
	      var $valid = $("#wizard-1").valid();
	      if (!$valid) {
	        $validator.focusInvalid();
	        return false;
	      } else {
	        $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).addClass(
	          'complete');
	        $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).find('.step')
	        .html('<i class="fa fa-check"></i>');
	      }
	    }
	  });
	});

		
    var $verify_form=$('#wizard-1');
    var verify_stat=$verify_form.validate();

    $verify_form.submit(function(){
    	
        if(verify_stat.checkForm())
        {

        	ajax_object.reset_object();
            ajax_object.set_content('#verification-container')                           
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($verify_form)
                           .submit_ajax('menyimpan verifikasi');
            return false;
        }

    });    
	
</script>
