<div class="container-fluid box">

	<fieldset style="padding:15px;">
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
						<label class="control-label col-md-4" for="input_no_peserta">No. Peserta</label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control" id="input_no_peserta" type="text" name="input_no_peserta" value="<?=$this->session->userdata('nopes');?>" readonly>
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
								<input class="form-control" id="input_alamat" type="text" name="input_alamat" value="<?=$this->session->userdata('alamat');?>" readonly>
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
								<select name="input_kecamatan" id="input_kecamatan" class="form-control" required>
									<option value=""></option>
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
									<input class='form-control decimal' id='input_nil_pkn' type='text' onkeyup=\"count_tot_value();\" name='input_nil_pkn' value='".$peserta_row['nil_pkn']."'>
								</div>
							</div>
						</div>";
					}else{
						echo "<input type='hidden' id='input_nil_pkn' value=0/>";
					}

					echo "
						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_bhs_indonesia'>Bhs. Indonesia <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control decimal' id='input_nil_bhs_indonesia' type='text' onkeyup=\"count_tot_value();\" name='input_nil_bhs_indonesia' value='".$peserta_row['nil_bhs_indonesia']."'>
								</div>
							</div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_bhs_inggris'>Bhs. Inggris <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control decimal' id='input_nil_bhs_inggris' type='text' onkeyup=\"count_tot_value();\" name='input_nil_bhs_inggris' value='".$peserta_row['nil_bhs_inggris']."'>
								</div>
							</div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_matematika'>Matematika <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control decimal' id='input_nil_matematika' type='text' onkeyup=\"count_tot_value();\" name='input_nil_matematika' value='".$peserta_row['nil_matematika']."'>
								</div>
							</div>
						</div>

						<div class='form-group'>
							<label class='control-label col-md-4' for='input_nil_ipa'>IPA <font color='red'>*</font></label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control decimal' id='input_nil_ipa' type='text' onkeyup=\"count_tot_value();\" name='input_nil_ipa' value='".$peserta_row['nil_ipa']."'>
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
									<input class='form-control decimal' id='input_nil_ips' type='text' onkeyup=\"count_tot_value();\" name='input_nil_ips' value='".$peserta_row['nil_ips']."'>
								</div>
							</div>
						</div>";
					}else{
						echo "<input type='hidden' id='input_nil_ips' value=0/>";
					}

					echo "<div class='form-group'>
							<label class='control-label col-md-4' for='input_tot_nilai'>Total Nilai</label>
							<div class='col-md-8'>
								<div class='input'>
									<input class='form-control decimal' id='input_tot_nilai' type='text' name='input_tot_nilai' value='".$peserta_row['tot_nilai']."' readonly>
								</div>
							</div>
						</div>";


					?>
                    
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
											<select name='input_sekolah_tujuan".$i."' id='input_sekolah_tujuan".$i."' class='form-control' ".($i==1?'required':'').">
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
										$i=0;
										foreach($dokumen_persyaratan_rows as $row){
											$i++;
											echo "
											<tr>
												<td>
													<input id='input_berkas' type='checkbox' name='input_berkas".$i."' value='".$row['ref_dokumen_id']."' ".($row['checked']=='1'?"onclick='return false' checked":'')."><label for='input_berkas".$i."'><span></span>".$row['nama_dokumen']."</label>
												</td>
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

			<?php
				if($path=='4'){
					echo "<div class='row'>
					<div class='col-md-12'>
						<div class='form-group'>
							<div class='col-md-12' align='center'>
								<h4><u>Prestasi Akademik/Non Akademik</u></h4>
							</div>
						</div>
						<div class='form-group'>
							<div class='col-md-12'>
								<table class='table table-bordered'>
									<tbody>";
										$i = 0;
										foreach($tingkat_kejuaraan_rows as $row1){
											$i++;
											$j = 0;
											echo "
											<tr>
												<td>													
													<input type='checkbox' name='tingkat_kejuaraan".$i."' id='tingkat_kejuaraan' onclick=\"toggle_detail_achievement(".$i.",$(this).prop('checked'))\" value='".$row1['ref_tkt_kejuaraan_id']."'><label for='tingkat_kejuaraan".$i."'><span></span><b>Tingkat ".$row1['tingkat_kejuaraan']."</b></label>
												</td>
											</tr>
											<tr>
												<td>
												<table class='table' id='detail_achievement".$i."' style='display:none'>
													<thead>
														<tr><td>Bidang</td><td>Nama Kejuaraan</td><td>Penyelenggaran</td><td>Peringkat</td><td>Tahun</td><td></td></tr>
													</thead>
													<tbody id='detail_achievement".$i."-tbody'>
														<tr id='row-1'>
														<td>
															<select name='bidang".$i."_".$j."' class='form-control' required>															
															".$bidang_kejuaraan_opts."
															</select>															
														</td>
														<td>
															<input type='text' name='nm_kejuaraan".$i."_".$j."' class='form-control' required/>
														</td>
														<td>
															<input type='text' name='penyelenggara".$i."_".$j."' class='form-control' required/>
														</td>
														<td>
															<input type='text' name='peringkat".$i."_".$j."' class='form-control numeric' required/>
														</td>
														<td>
															<input type='text' name='thn_kejuaraan".$i."_".$j."' class='form-control numeric' maxlength=4 required/>
														</td>
														<td></td>
														</tr>
													</tbody>
													<tfoot>
														<tr>
															<td colspan='5' align='right'>
															<a href='javascript:;' onclick=\"add_achievement_rows(".$i.")\" class='txt-btn'><i class='fa fa-plus'></i> Tambah Baris</a>
															</td>
														</tr>
													</tfoot>
												</table>
												<input type='hidden' id='input_n_prestasi".$i."' name='n_achievement_rows".$i."'/>
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
		</form>
	</fieldset>
	
</div>

<link rel="stylesheet" href="<?=$this->config->item('js_path');?>plugins/iCheck/all.css">
<script type="text/javascript" src="<?=$this->config->item('js_path');?>plugins/iCheck/icheck.min.js"></script>

<script type="text/javascript">	
	
    var $reg_form=$('#reg-form'), $submitLoader = $('#submit-loader'), $submitBtn = $('#submit-btn'), $submitNotify = $('#submit-notify'), $content = $('#data-view');

   	function validate_checkboxes(id){
   		var chks = document.querySelectorAll('input[id="'+id+'"]');
   		var hasChecked = false;
   		for(var i = 0;i < chks.length;i++){
   			if(chks[i].checked){
   				hasChecked = true;
   				break;
   			}
   		}
   		if(!hasChecked){
   			alert('Silahkan isikan data prestasi minimal satu tingkat kejuaraan!');
   		}
   		return hasChecked;
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
	                	errorElement:'control-label',
	                    error.addClass('error');
	                    error.insertAfter(element.parent());
	                }
	            }
        	);

    //     $reg_form.submit(function(){
    //         if(stat.checkForm())
    //         {
    //         	if(validate_checkboxes('tingkat_kejuaraan'))
    //         	{
	   //          	if(confirm('Anda yakin data inputan sudah benar?'))
	   //          	{
		  //               $.ajax({
		  //                 type:'POST',
		  //                 url:$reg_form.attr('action'),
		  //                 data:$reg_form.serialize(),
		  //                 beforeSend:function(){    
		  //                 	$submitNotify.hide();
		  //                   $submitLoader.show();
		  //                   $submitBtn.attr('disabled',true);
		  //                 },
		  //                 success:function(data){                    

		  //                   error=/ERROR/;

		  //                   if(data=='failed' || data.match(error))
		  //                   {
		  //                       if(data=='failed')
		  //                       {
		  //                           content_box = "Data gagal dikirim, silahkan ulangi lagi !";
		  //                       }else{
		  //                           x = data.split(':');
		  //                           content_box = x[1].trim();
		  //                       }
		                        
		  //                       $submitLoader.hide();
		  //                       $submitNotify.html(content_box);
		  //                       $submitNotify.show();
		  //                       $submitBtn.attr('disabled',false);
		  //                   }else{

		  //                   	$content.html(data);

		  //                   }
		  //                 }
		                  
		  //               });
				// 	}
				// }
    //             return false;
    //         }
    //     });
    });

	function init_jquery_plugin(){
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
    			  "<td><select name='bidang"+i+"_"+new_order+"' class='form-control' required>"+_bidang_kejuaraan_opts+"</select></td>"+
				  "<td><input type='text' name='nm_kejuaraan"+i+"_"+new_order+"' class='form-control' required/></td>"+
				  "<td><input type='text' name='penyelenggara"+i+"_"+new_order+"' class='form-control' required/></td>"+
				  "<td><input type='text' name='peringkat"+i+"_"+new_order+"' class='form-control numeric'  required/></td>"+
				  "<td><input type='text' name='thn_kejuaraan"+i+"_"+new_order+"' class='form-control numeric' required/></td>"+
				  "<td><button type='button' id='achievement_row"+i+"_"+new_order+"' class='btn btn-default btn-xs' onclick=\"delete_achievement_row('"+i+"','"+new_order+"');\"><i class='fa fa-trash-o'></i></button></td>"+
    			  "</tr>";
    	
    	$n_achievement_rows.val(new_order);
    	$tbody.append(new_row);
    	init_jquery_plugin();
	}	

	function count_tot_value(){
		var $pkn = $('#input_nil_pkn'), $bhs_indo = $('#input_nil_bhs_indonesia'), $bhs_inggris = $('#input_nil_bhs_inggris'), 
			$matematika = $('#input_nil_matematika'), $ipa = $('#input_nil_ipa'), $ips = $('#input_nil_ips'), $tot_nilai = $('#input_tot_nilai');

		var pkn = gnv($pkn.val()), bhs_indo = gnv($bhs_indo.val()), bhs_inggris = gnv($bhs_inggris.val()), matematika = gnv($matematika.val()), 
			ipa = gnv($ipa.val()), ips = gnv($ips.val()), tot_nilai = 0;

		tot_nilai = parseFloat(pkn)+parseFloat(bhs_indo)+parseFloat(bhs_inggris)+parseFloat(matematika)+parseFloat(ipa)+parseFloat(ips);    	
    	tot_nilai = (tot_nilai==0?0:number_format(tot_nilai,2,'.',','));
    	$tot_nilai.val(tot_nilai);
	}
</script>
