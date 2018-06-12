<?php

	if(!isset($pendaftaran_row) or (isset($pendaftaran_row) and ($pendaftaran_row['status']!='1')) 
		or (!$status_urutan) or ($map_status!='OK'))
	{
		$warning = "kesalahan tidak diketahui!";
		
		if(!isset($pendaftaran_row))
		{
			$warning = "Data tidak ditemukan!";
		}
		else if(isset($pendaftaran_row))
		{
			if($pendaftaran_row['status']!='1')
			{				
				$warning = "Data sudah diverifikasi!";
			}	
		}else if(!$status_urutan){
			$prev = $sekolah_pilihan_row['sklh_pilihan_ke']-1;
			$warning = "Proses belum bisa dilanjutkan. Silahkan melakukan verifikasi berkas pada Sekolah Pilihan ke ".$prev." terlebih dahulu!";
		}else if($map_status=='ZERO_RESULTS'){
			$warning = "Gagal mendapatkan titik Koordinat alamat peserta, silahkan ulangi lagi!!";
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



<!-- NEW WIDGET START -->
<article class="col-sm-12 col-md-12 col-lg-12">

	<!-- Widget ID (each widget will need unique ID)-->
	<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-deletebutton="false">
		<!-- widget options:
		usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

		data-widget-colorbutton="false"
		data-widget-editbutton="false"
		data-widget-togglebutton="false"
		data-widget-deletebutton="false"
		data-widget-fullscreenbutton="false"
		data-widget-custombutton="false"
		data-widget-collapsed="true"
		data-widget-sortable="false"

		-->
		<header>
			<span class="widget-icon"> <i class="fa fa-check"></i> </span>
			<h2>Form Verifikasi </h2>

		</header>

		<!-- widget div-->
		<div>

			<!-- widget edit box -->
			<div class="jarviswidget-editbox">
				<!-- This area used as dropdown edit box -->

			</div>
			<!-- end widget edit box -->

			<!-- widget content -->
			<div class="widget-body">
				<div id="verification-loader" style="display:none" align="center">
					<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-7.gif"/>
				</div>
				<div class="row" id="verification-container">
					<form id="wizard-1" novalidate="novalidate" method="POST" action="<?=base_url();?>backoffice/submit_verification">
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
						<input type="hidden" name="verifikasi_kompetensi_id" value="0"/>
						<div id="bootstrap-wizard-1" class="col-sm-12">
							<div class="form-bootstrapWizard">
								<ul class="bootstrapWizard form-wizard">
									<li class="active" data-target="#step1">
										<a href="#tab1" data-toggle="tab"> <span class="step">1</span> <span class="title">Data Diri & Nilai</span> </a>
									</li>
									<li data-target="#step2">
										<a href="#tab2" data-toggle="tab"> <span class="step">2</span> <span class="title">Berkas</span> </a>
									</li>
									<li data-target="#step3">
										<a href="#tab3" data-toggle="tab"> <span class="step">3</span> <span class="title">Zonasi</span> </a>
									</li>
									<li data-target="#step4">
										<a href="#tab4" data-toggle="tab"> <span class="step">4</span> <span class="title">Simpan</span> </a>
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
												</tr>
												<tr>
													<td>Sekolah Tujuan/Pilihan ke-</td>
													<td>".$sekolah_pilihan_row['nama_sekolah']."/".$sekolah_pilihan_row['sklh_pilihan_ke']." (".NumToWords($sekolah_pilihan_row['sklh_pilihan_ke']).")</td>
												</tr>
											</tbody>
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
									<h3><strong>Step 2</strong> - Verifikasi Berkas</h3>

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
								<div class="tab-pane" id="tab3">
									<input type="hidden" id="school_latitide" value="<?=$sekolah_pilihan_row['latitude'];?>"/>
									<input type="hidden" id="school_longitude" value="<?=$sekolah_pilihan_row['longitude'];?>"/>
									<input type="hidden" id="school_name" value="<?=$sekolah_pilihan_row['nama_sekolah'];?>"/>									
									<br>
									<h3><strong>Step 3</strong> - Zonasi</h3>
									<div class="row">
										<div class="col-md-12">											
											<div id="map" style="height:500px!important;width:100%;border;1px solid #cccccc;"></div><br />
											<table class="table table-bordered">
												<tbody>
													<tr><td colspan="2" align="center"><a href="javascript:;" id="startDistanceCalculation"><i class="fa fa-road"></i> Mulai Menghitung Jarak</a></td></tr>
													<tr><td width="30%" align="right">Alamat Sekolah</td>
														<td><input type="text" class="form-control" value="<?=$sekolah_pilihan_row['alamat_sekolah']." (".$sekolah_pilihan_row['latitude'].", ".$sekolah_pilihan_row['longitude'].")";?>" id="school_LatLang" readonly/></td></tr>
													<tr>
														<td align="right">Alamat Calon Siswa</td>
														<td>
															<input type="hidden" id="reg_address" value="<?=$pendaftaran_row['alamat'];?>" readonly/>
														</td>														
													</tr>
													<tr>
														<td align="right">Jarak</td>
														<td><input type="text" class="form-control" id="distance" readonly/></td>														
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="tab4" align="center">
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

			</div>
			<!-- end widget content -->

		</div>
		<!-- end widget div -->

	</div>
	<!-- end widget -->

</article>
<!-- WIDGET END -->


<script type="text/javascript">
	//Bootstrap Wizard Validations
	$(document).ready(function(){

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
                           .set_loading('#verification-loader')
                           .disable_pnotify()
                           .set_form($verify_form)
                           .submit_ajax('');
            return false;
        }

    });

    $(function(){
		'user strick';

		var map,marker1,marker2;
		var mapDiv = document.getElementById('map');
		var schoolLatLang = new google.maps.LatLng($('#school_latitide').val(),$('#school_longitude').val());
		
		function initMap(){

			map = new google.maps.Map(mapDiv,{
				center:schoolLatLang,
				zoom:15,
				zoomControl:false,
				streetViewControl:false,
				scrollwheel:true
			});
			marker1 = new google.maps.Marker({
				position:schoolLatLang,
				map:map,
				title:$('#school_name').val(),
				draggable:false,
			});

		};
		
		// processing the results
		function changeMapLocation(locations) {
			if(locations && locations.length) {

				$('#reg_address2').val($('#reg_address').val()+" "+locations[0].location.toString());
				$('#reg_latLng').val(locations[0].location.toString());

				marker2 = new google.maps.Marker({
					map: map,
					position: locations[0].location,
					title:'Alamat Calon Siswa',
					draggable:true,
				});
				
				map.panTo(locations[0].location);
				map.setZoom(15);
			} else {
				log("Num of results: 0");
			}
		}

		// converting the address's string to a google.maps.LatLng object
		function addressToLocation(address, callback) {

			var geocoder = new google.maps.Geocoder();
			geocoder.geocode(
				{
					address: address
				}, 
				function(results, status) {
					
					var resultLocations = [];
					
					if(status == google.maps.GeocoderStatus.OK) {
						if(results) {
							var numOfResults = results.length;
							for(var i=0; i<numOfResults; i++) {
								var result = results[i];
								resultLocations.push(
									{
										text:result.formatted_address,
										addressStr:result.formatted_address,
										location:result.geometry.location
									}
								);
							};
						}
					} else if(status == google.maps.GeocoderStatus.ZERO_RESULTS) {
						// address not found
					}
					
					if(resultLocations.length > 0) {
						callback(resultLocations);
					} else {
						callback(null);
					}
				}
			);
		}

		// adding events
		document.getElementById("startDistanceCalculation").onclick = function() {
			var address = $("#reg_address").val();
			addressToLocation(address, changeMapLocation);
		}

		initMap();
	});

	
</script>