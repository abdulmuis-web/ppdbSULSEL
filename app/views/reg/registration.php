<div class="container-fluid box">

	<fieldset>
		
		<div class="alert alert-danger">
		  <strong>Perhatian!</strong> Lengkapi formulir di bawah ini dengan data yang benar. <br />
		  Perhatikan kembali data yang telah diisi sebelum menekan tombol Submit karena penginputan data hanya sekali saja!
		</div>

		<form action="<?=base_url();?>reg/submit_reg" id="reg-form" method="POST" class="form-horizontal">
			<input type="hidden" name="input_tipe_sekolah" value="<?=$stage;?>"/>
			<input type="hidden" name="input_jalur_pendaftaran" value="<?=$path;?>"/>
			<input type="hidden" name="input_tipe_ujian_smp" value="<?=$peserta_row['tipe_ujian_smp'];?>"/>
			<input type="hidden" name="input_jml_sekolah" value="<?=$kuota_jalur_row['jml_sekolah'];?>"/>
			<input type="hidden" name="input_dt2_id" value="<?=$peserta_row['dt2_id'];?>"/>			

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label col-md-4" for="input_no_peserta">No. Peserta <?=($input_rule=='required'?"<font color='red'>*</font>":"");?></label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control" id="input_no_peserta" type="text" name="input_no_peserta" value="<?=$input_arr['nopes'];?>" <?=$input_rule;?>/>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="input_nama">Nama <?=($input_rule=='required'?"<font color='red'>*</font>":"");?></label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control" id="input_nama" type="text" name="input_nama" value="<?=$input_arr['nama'];?>" <?=$input_rule;?>/>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="input_jk">J. Kelamin <?=($input_rule=='required'?"<font color='red'>*</font>":"");?></label>
						<div class="col-md-8">
							<div class="input">
								<?php
									if($path!='5'){
										echo "<input class='form-control' id='input_jk' type='text' name='input_jk' value='".$input_arr['jk']."' readonly/>";
									}else{
										echo "
										<select name='input_jk' id='input_jk' class='form-control' required>
										<option value=''></option>";
										foreach(array('L'=>'Laki-laki','P'=>'Perempuan') as $key=>$val){
											echo "<option value='".$key."'>".$val."</option>";
										}
										echo "</select>";
									}
								?>
								
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="input_sekolah_asal">Sekolah Asal <?=($input_rule=='required'?"<font color='red'>*</font>":"");?></label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control" id="input_sekolah_asal" type="text" name="input_sekolah_asal" value="<?=$input_arr['sklh_asal'];?>" <?=$input_rule;?>/>

							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4">Tpt, Tgl. Lahir <?=($input_rule=='required'?"<font color='red'>*</font>":"");?></label>
						<div class="col-md-4">
							<div class="input">
								<input class="form-control" id="input_tpt_lahir" name="input_tpt_lahir" type="text" value="<?=$input_arr['tpt_lahir'];?>" <?=$input_rule;?>/>
							</div>
						</div>
						<div class="col-md-4">
							<div class="input">
								<input class="form-control datepicker" id="input_tgl_lahir" type="text" name="input_tgl_lahir" value="<?=$input_arr['tgl_lahir'];?>" <?=$input_rule;?>/>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label class="control-label col-md-4" for="input_alamat">Alamat <?=($input_rule=='required'?"<font color='red'>*</font>":"");?></label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control" id="input_alamat" type="text" name="input_alamat" value="<?=$input_arr['alamat'];?>" <?=$input_rule;?>/>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="input_dt2">Kab./Kota <?=($input_rule=='required'?"<font color='red'>*</font>":"");?></label>
						<div class="col-md-8">
							<div class="input">
								<?php
									
									echo "<select name='input_dt2' id='input_dt2' onchange=\"get_data_linked_toRegency($(this).val(),'".$stage."','".$kuota_jalur_row['lintas_dt2']."','".$kuota_jalur_row['jml_sekolah']."');\" class='form-control' required>
									<option value=''></option>";
									foreach($dt2_rows as $row){
										echo "<option value='".$row['dt2_id']."_".$row['dt2_kd']."_".$row['nama_dt2']."'>".$row['nama_dt2']."</option>";
									}
									echo "</select>";
									
								?>
								<span class="help-block">Pilih Kab./Kota sesuai Kartu Keluarga</span>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-md-4" for="input_kecamatan">Kecamatan <font color="red">*</font></label>
						<div class="col-md-8">
							<div id="district-loader" style="display:none">
								<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
							</div>
							<div class="input" id="cont_input_kecamatan">
								<select name="input_kecamatan" id="input_kecamatan" class="form-control" required>
									<option value=""><?=($path=='5'?"- Pilih Kab./Kota lebih dulu -":"");?></option>
									<?php
										foreach($kecamatan_rows as $row){
											echo "<option value='".$row['kecamatan_id']."_".$row['nama_kecamatan']."'>".$row['nama_kecamatan']."</option>";
										}
									?>
								</select>
								<span class="help-block">Pilih Kecamatan sesuai Kartu Keluarga</span>
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
							<h4 class="form-inline-title">Nilai Ujian Nasional SMP Thn. <?=date('Y');?></h4>
						</div>
					</div>

					<?php					

					echo "
						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_bhs_indonesia'>Bhs. Indonesia <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control decimal' id='input_nil_bhs_indonesia' type='text' onkeyup=\"count_tot_value();\" name='input_nil_bhs_indonesia' value='".$input_arr['nil_bhs_indonesia']."' required>
								</div>
							</div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_bhs_inggris'>Bhs. Inggris <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control decimal' id='input_nil_bhs_inggris' type='text' onkeyup=\"count_tot_value();\" name='input_nil_bhs_inggris' value='".$input_arr['nil_bhs_inggris']."' required>
								</div>
							</div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_matematika'>Matematika <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control decimal' id='input_nil_matematika' type='text' onkeyup=\"count_tot_value();\" name='input_nil_matematika' value='".$input_arr['nil_matematika']."' required>
								</div>
							</div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_ipa'>IPA <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control decimal' id='input_nil_ipa' type='text' onkeyup=\"count_tot_value();\" name='input_nil_ipa' value='".$input_arr['nil_ipa']."' required>
								</div>
							</div>
						</div>					

						<div class='form-group'>
							<label class='control-label col-md-4' for='input_tot_nilai'>Total Nilai</label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control decimal' id='input_tot_nilai' type='text' name='input_tot_nilai' value='".$input_arr['tot_nilai']."' readonly>
								</div>
							</div>
						</div>";
					?>

				</div>

				<div class="col-md-6">
					<div class="form-group">
						<div class="col-md-12" align="right">
							<h4 class="form-inline-title">Berkas Kelengkapan Pendaftaran</h4>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12">
							<table class="table table-bordered table-hover">
								<tbody>
									<?php
										$i=0;
										foreach($dokumen_persyaratan_rows as $row){
											$i++;
											echo "
											<tr>
												<td>
													<input id='input_berkas' type='checkbox' name='input_berkas".$i."' value='".$row['ref_dokumen_id']."' ".($row['status']=='mandatory'?"onclick='return false' checked":'')."><label for='input_berkas".$i."'><span></span>".$row['nama_dokumen']."</label>";
													if($row['status']=='mandatory')
														echo "<span class='badge badge-primary pull-right' style='background:#f71313!important'>Wajib</span>";
													else
														echo "<span class='badge badge-primary pull-right' style='background:#ffc044!important'>Opsional</span>";
												echo "</td>
											</tr>";
										}
									?>
									
								</tbody>
							</table>
							<input type="hidden" name="input_n_berkas" value="<?=$i;?>"/>
						</div>
					</div>
				</div>
			</div>

			<div class="row">				
					
				<?php

				if($kuota_jalur_row['lintas_dt2']!='0')
					$class = 'col-md-12';
				else{
					$class = 'col-md-6';
					if($path!='3')
						$class .= " col-md-offset-3";
				}
				
				echo "
				<div class='".$class."'>";

					if($kuota_jalur_row['lintas_dt2']=='1')
					{
						echo "
						<div class='alert alert-warning'>
						  <strong>Perhatian!</strong><br />
						  Pada Jalur Pendaftaran ini anda diperbolehkan memilih sekolah dari kota/kab. lain yang berbatasan dengan kota/kab. domisili.
						</div>";
					}

					echo "
					<div id='regency-dest-school-loader' style='display:none' align='center'>
						<img src='".$this->config->item('img_path')."ajax-loaders/ajax-loader-1.gif'/> Mohon tunggu ...
					</div>

					<div id='regency-dest-school'>
						<table class='table table-bordered'>								
							<thead>
								<tr><td width='4%' align='center'><b>#</b></td>";
								if($kuota_jalur_row['lintas_dt2']!='0')
									echo "<td width='50%' align='center'><b>Kota/Kab.</b></td>";
								
								if($stage=='1')
									echo "<td align='center'><b>SMA Tujuan</b></td>";
								else
									echo "<td align='center'><b>SMK Tujuan</b></td><td align='center'><b>Jenis Kompetensi</b></td>";

								echo "</tr>

							</thead>
							<tbody>";								
								for($i=1;$i<=$kuota_jalur_row['jml_sekolah'];$i++)
								{
									echo "
									<tr>
									<td align='center'>".$i."</td>";
									if($kuota_jalur_row['lintas_dt2']!='0')
									{
										echo "
										<td>																						
											<select name='input_dt2_sekolah_tujuan".$i."' id='input_dt2_sekolah_tujuan".$i."' onchange=\"get_destSchools($(this).val(),'".($path!='5'?$peserta_row['dt2_id']:'')."','".$stage."','".$kuota_jalur_row['lintas_dt2']."','".$i."');\" class='form-control' required>";
												echo "<option value=''>".($kuota_jalur_row['lintas_dt2']=='1'?"-- Pilih Kab./Kota Domisili lebih dulu --":"")."</option>";
												foreach($pengaturan_dt2_sekolah_rows as $row)
												{
													$keterangan = ($kuota_jalur_row['lintas_dt2']=='1'?" (".ucwords($row['status']).")":"");
													echo "<option value='".$row['dt2_sekolah_id']."'>".$row['nama_dt2'].$keterangan."</option>";
												}
											echo "</select>											
										</td>";
									}

									echo "<td>
										<div id='dest-school-loader".$i."' style='display:none'>
											<img src='".$this->config->item('img_path')."ajax-loaders/ajax-loader-1.gif'/>
										</div>
										<div id='cont_input_sekolah_tujuan".$i."'>
											<select name='input_sekolah_tujuan".$i."' id='input_sekolah_tujuan".$i."' onchange=\"get_destFields($(this).val(),'".$i."')\" class='form-control' ".($i==1?'required':'').">
												<option value=''>".($path=='3'?'-- Pilih Kab./Kota Domisili lebih dulu --':'-- Pilih Kab./Kota Sekolah lebih dulu --')."</option>";
											echo "</select>
										</div>
										<input type='hidden' name='input_komptensi_tujuan' value='0_0'/>
									</td>";

									if($stage=='2'){
										echo "
										<td>
											<div id='dest-field-loader".$i."' style='display:none'>
												<img src='".$this->config->item('img_path')."ajax-loaders/ajax-loader-1.gif'/>
											</div>
											<div id='cont_input_kompetensi_tujuan".$i."'>
												<select name='input_kompetensi_tujuan".$i."' id='input_kompetensi_tujuan".$i."' class='form-control' ".($i==1?'required':'').">
													<option value=''>- Pilih SMK lebih dulu -</option></select>
											</div>
										</td>";
									}

									echo "</tr>";
								}
							echo "</tbody>
						</table>
					</div>
				</div>";

			if($path=='3')
			{

				if($kuota_jalur_row['lintas_dt2']=='0'){
					echo "<div class='col-md-6'>";
				}else{
					echo "</div>";
				}

				echo "<div class='row'>
					<div class='col-md-12'>
						<div class='form-group'>
							<div class='col-md-6' align='right'>
								<h4 class='form-inline-title'>Jenis Ujian Nasional SMP</h4>
							</div>
							<div class='col-md-6'>
								<input type='text' class='form-control' name='input_jenis_ujian_smp' value='".$peserta_row['mode_un']."' readonly/>
							</div>
						</div>	
					</div>
				</div>";

				if($kuota_jalur_row['lintas_dt2']=='0'){
					echo "</div>";
				}
			}else{
				echo "<input type='hidden' name='input_jenis_ujian_smp' value''/>";
			}


				if($path=='4'){
					echo "
					<div class='row'>
						<div class='col-md-12'>
							<div class='form-group'>
								<div class='col-md-12' align='center'>
									<h4 class='form-inline-title'>Prestasi Akademik/Non Akademik</h4>
								</div>
							</div>						
							<div class='form-group'>
								<div class='col-md-12'>
									<table class='table table-bordered'>
										<tbody>";
											$i = 0;
											foreach($tingkat_kejuaraan_rows as $row1){
												$i++;
												$j = 1;
												echo "
												<tr>
													<td>													
														<input type='checkbox' name='input_tingkat_kejuaraan".$i."' id='input_tingkat_kejuaraan' onclick=\"toggle_detail_achievement(".$i.",$(this).prop('checked'))\" value='".$row1['ref_tkt_kejuaraan_id']."'>
														<label for='tingkat_kejuaraan".$i."'><span></span><b>Tingkat ".$row1['tingkat_kejuaraan']."</b></label>
													</td>
												</tr>
												<tr>
													<td>
													<table class='table' id='detail_achievement".$i."' style='display:none'>
														<thead>
															<tr><td>Bidang</td><td>Nama Kejuaraan</td><td>Penyelenggaran</td><td>No. Sertifikat</td><td>Peringkat/Tahun</td><td></td></tr>
														</thead>
														<tbody id='detail_achievement".$i."-tbody'>
															<tr id='row-1'>
															<td>
																<select name='input_bidang".$i."_".$j."' class='form-control' required>															
																".$bidang_kejuaraan_opts."
																</select>															
															</td>
															<td>
																<input type='text' name='input_nm_kejuaraan".$i."_".$j."' class='form-control' required/>
															</td>
															<td>
																<input type='text' name='input_penyelenggara".$i."_".$j."' class='form-control' required/>
															</td>
															<td>
																<input type='text' name='input_no_sertifikat".$i."_".$j."' class='form-control numeric' required/>
															</td>
															<td>
																<input type='text' name='input_peringkat_thn_kejuaraan".$i."_".$j."' id='input_peringkat_thn_kejuaraan".$i."' class='form-control' required/>
															</td>
															<td></td>
															</tr>
														</tbody>
														<tfoot>
															<!-- tr>
																<td colspan='5' align='right'>
																<a href='javascript:;' onclick=\"add_achievement_rows(".$i.")\" class='txt-btn'><i class='fa fa-plus'></i> Tambah Baris</a>
																</td>
															</tr -->
														</tfoot>
													</table>
													<input type='hidden' name='input_n_prestasi".$i."' id='n_achievement_rows".$i."' value='".$j."'/>
													</td>
												</tr>";
											}
										echo "
										</tbody>
									</table>
									<input type='hidden' name='input_n_tingkat_kejuaraan' value='".$i."'/>
								</div>
							</div>
						</div>
					</div>";
				}

			?>
			<div class="row">
				<div class="col-md-12" align="center">
					<input type="checkbox" name="input_persetujuan" id="input_persetujuan" onclick="return false" data-toggle="modal" data-target="#terms-conditionModal" value="1">
					<label for="input_persetujuan"><span></span>Baca Ketentuan Berlaku</label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<hr></hr>
					<center>
						<button type="submit" class="btn btn-success" id="submit-btn"><i class="fa fa-save"></i> Submit</button><br /><br />
						<div id="submit-loader" style="display:none">
							<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/> Data sedang dikirim ke Server ... !!
						</div>
						<div id="submit-notify" style="display:none"></div>
					</center>
				</div>
			</div>

			<!-- Login Modal -->
		    <div class="modal fade" id="terms-conditionModal" role="dialog">
		        <div class="modal-dialog modal-lg">
		            <div class="modal-content">		                
		                <div class="modal-header">		                    
		                    <h4 class="modal-title">Ketentuan Berlaku</h4>
		                </div>
		                <div class="modal-body">
		                    <?php
		                    	echo $ketentuan_berlaku;
		                    ?>
		                </div>
		                <div class="modal-footer">
		                    <div class="row">
		                        <div class="col-lg-6 col-md-6">&nbsp;</div>
		                        <div class="col-lg-6 col-md-6">
		                            <button type="button" class="btn btn-default" onclick="$('#input_persetujuan').prop('checked',true)" data-dismiss="modal"><i class="fa fa-check"></i> Setuju</button>
		                            <button type="button" class="btn btn-default" onclick="$('#input_persetujuan').prop('checked',false)" data-dismiss="modal"><i class="fa fa-times"></i> Tidak Setuju</button>
		                        </div>
		                    </div>  
		                </div>
		            </form>
		            </div>
		        </div>
		    </div>

		</form>
	</fieldset>
	
</div>

<link rel="stylesheet" href="<?=$this->config->item('js_path');?>plugins/iCheck/all.css">
<script type="text/javascript" src="<?=$this->config->item('js_path');?>plugins/iCheck/icheck.min.js"></script>

<script type="text/javascript">	
	
    var $reg_form=$('#reg-form'), $submitLoader = $('#submit-loader'), $submitBtn = $('#submit-btn'), $submitNotify = $('#submit-notify'), $content = $('#data-view');
    var path = "<?=$path;?>";


   	function validate_checkboxes(id,path){
   		var chks = document.querySelectorAll('input[id="'+id+'"]');
   		var hasChecked = false;
   		for(var i = 0;i < chks.length;i++){
   			if(chks[i].checked){
   				hasChecked = true;
   				break;
   			}
   		}
   		
   		if(!hasChecked && path=='4'){
   			alert('Silahkan isikan data prestasi minimal satu tingkat kejuaraan!');
   			return false;
   		}
   		return true;
   	}

    $(function() {

    	jQuery.extend(jQuery.validator.messages, {
		    required: "Required",		   
		});

        // Validation
        var stat = $reg_form.validate(
	        	{
	        		messages:{
	        			required:'required'
	        		},
	                // Do not change code below
	                errorPlacement : function(error, element) {	                	
	                    error.addClass('error');
	                    error.insertAfter(element.parent());
	                }
	            }
        	);


        $reg_form.submit(function(){

            if(stat.checkForm())
            {
            	if(validate_checkboxes('input_tingkat_kejuaraan',path))
            	{
	            	if($('#input_persetujuan').prop('checked')==true)
	            	{
	            		if(confirm('Anda yakin data inputan sudah benar?'))
	            		{
			                $.ajax({
			                  type:'POST',
			                  url:$reg_form.attr('action'),
			                  data:$reg_form.serialize(),
			                  beforeSend:function(){    
			                  	$submitNotify.hide();
			                    $submitLoader.show();
			                    $submitBtn.attr('disabled',true);
			                  },
			                  success:function(data){                    

			                    error=/ERROR/;

			                    if(data=='failed' || data.match(error))
			                    {
			                        if(data=='failed')
			                        {
			                            content_box = "Data gagal dikirim, silahkan ulangi lagi !";
			                        }else{
			                            x = data.split(':');
			                            content_box = x[1].trim();
			                        }
			                        
			                        $submitLoader.hide();
			                        $submitNotify.html(content_box);
			                        $submitNotify.show();
			                        $submitBtn.attr('disabled',false);
			                    }else{

			                    	$content.html(data);

			                    }
			                  }
			                  
			                });
						}
					}else{
						alert('Anda wajib menyetujui Ketentuan Berlaku!');
					}
				}
                return false;
            }
        });
    });

	function init_jquery_plugin(){
		
		$("#input_tgl_lahir").mask('99-99-9999');

		$(".datepicker").datepicker(
			{ 
				dateFormat: 'dd-mm-yy',
				changeMonth: true,
            	changeYear: true

			});

		$(".decimal").inputmask({
		    'alias': 'decimal',
		    rightAlign: false
		  });

		$(".numeric").inputmask({
		    'alias': 'numeric',
		    rightAlign: false
		  });

		//iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
	}

	function init_jquery_masked2(i){
		$('#input_peringkat_thn_kejuaraan'+i).mask('9/9999');
	}

	$(document).ready(function(){
		init_jquery_plugin();
	});

	_bidang_kejuaraan_opts = "<?=$bidang_kejuaraan_opts;?>";

	function toggle_detail_achievement(i,checked){
		var $detail_achievement = $('#detail_achievement'+i), $n_achievement_rows = $('#n_achievement_rows'+i);
		if(checked)
		{
			$detail_achievement.show();
			if($n_achievement_rows.val()=='')
				$n_achievement_rows.val('1');
		}
		else
			$detail_achievement.hide();

		init_jquery_masked2(i)
	}

	function delete_achievement_row(i,order_num)
    {
    	var $tr = $('#detail_achievement'+i+'-tbody > tr');
    	$tr.remove('#row-'+order_num);    	
    }

	function add_achievement_rows(i){
		var $tbody = $('#detail_achievement'+i+'-tbody'), $lc_tbody = $('#detail_achievement'+i+'-tbody tr:last-child'), $n_achievement_rows = $('#n_achievement_rows'+i);
    	var last_row_id = $lc_tbody.attr('id');
    	
    	x = last_row_id.split('-');
    	last_order = x[1];
    	new_order = parseInt(last_order)+1;

    	new_row = "<tr id='row-"+new_order+"'>"+
    			  "<td><select name='input_bidang"+i+"_"+new_order+"' class='form-control' required>"+_bidang_kejuaraan_opts+"</select></td>"+
				  "<td><input type='text' name='input_nm_kejuaraan"+i+"_"+new_order+"' class='form-control' required/></td>"+
				  "<td><input type='text' name='input_penyelenggara"+i+"_"+new_order+"' class='form-control' required/></td>"+
				  "<td><input type='text' name='input_peringkat"+i+"_"+new_order+"' class='form-control numeric'  required/></td>"+
				  "<td><input type='text' name='input_peringkat_thn_kejuaraan"+i+"_"+new_order+"' id='input_peringkat_thn_kejuaraan' class='form-control' required/></td>"+
				  "<td><button type='button' id='achievement_row"+i+"_"+new_order+"' class='btn btn-default btn-xs' onclick=\"delete_achievement_row('"+i+"','"+new_order+"');\"><i class='fa fa-trash-o'></i></button></td>"+
    			  "</tr>";
    	
    	$n_achievement_rows.val(new_order);
    	$tbody.append(new_row);
    	init_jquery_plugin();
	}	

	function get_destSchools(school_regency,regency,school_type,accross_regency,i){
		
		ajax_object.reset_object();
		var data_ajax = new Array('school_regency='+school_regency,'regency='+regency,'school_type='+school_type,'accross_regency='+accross_regency,'i='+i);
        ajax_object.set_url($('#baseUrl').val()+'reg/get_destSchools').set_data_ajax(data_ajax).set_loading('#dest-school-loader'+i).set_content('#cont_input_sekolah_tujuan'+i).request_ajax();

        if(school_type=='2'){
        	$('#input_kompetensi_tujuan'+i).html("<option value''>- Pilih SMK lebih dulu -");
        }
	}

	function get_destFields(school,i){
		ajax_object.reset_object();
		var data_ajax = new Array('school='+school,'i='+i);
        ajax_object.set_url($('#baseUrl').val()+'reg/get_destFields').set_data_ajax(data_ajax).set_loading('#dest-field-loader'+i).set_content('#cont_input_kompetensi_tujuan'+i).request_ajax();
	}

	function get_data_linked_toRegency(regency,school_type,accross_regency,n_schools){
		
		$.ajax({
          type:'POST',
          url:$('#baseUrl').val()+'reg/get_data_linked_toRegency',
          data:'regency='+regency+'&school_type='+school_type+'&accross_regency='+accross_regency+'&n_schools='+n_schools,
          beforeSend:function(){    
            
            $('#district-loader').show();
            $('#cont_input_kecamatan').hide();

            if(school_type=='1')
            {
	            $('#regency-dest-school-loader').show();            
	            $('#regency-dest-school').hide();
	        }
            
          },
          success:function(data){
            
            x = data.split('#%%#');
						
            $('#district-loader').hide();
            $('#cont_input_kecamatan').html(x[0]);
            $('#cont_input_kecamatan').show();

            if(school_type=='1')
            {
	            $('#regency-dest-school-loader').hide();
	            $('#regency-dest-school').html(x[1]);
	            $('#regency-dest-school').show();
	        }
          }
        });
	}

	function count_tot_value(){
		var $bhs_indo = $('#input_nil_bhs_indonesia'), $bhs_inggris = $('#input_nil_bhs_inggris'), 
			$matematika = $('#input_nil_matematika'), $ipa = $('#input_nil_ipa'), $tot_nilai = $('#input_tot_nilai');

		var bhs_indo = gnv($bhs_indo.val()), bhs_inggris = gnv($bhs_inggris.val()), matematika = gnv($matematika.val()), 
			ipa = gnv($ipa.val()), tot_nilai = 0;

		tot_nilai = parseFloat(bhs_indo)+parseFloat(bhs_inggris)+parseFloat(matematika)+parseFloat(ipa);
    	tot_nilai = (tot_nilai==0?0:number_format(tot_nilai,2,'.',','));
    	$tot_nilai.val(tot_nilai);
	}
</script>
