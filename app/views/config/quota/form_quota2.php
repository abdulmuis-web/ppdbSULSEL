<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Pengaturan Kuota SMA</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_quota_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>	
	<input type="hidden" name="type" value="2"/>	
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
	<input type="hidden" name="act" value="<?=$act;?>"/>
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">
				
				<div class="form-group">
					<label class="control-label col-md-3" for="input_dt2_id">Kab./Kota <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input state-disabled">
							<select name="input_dt2_id" id="input_dt2_id" onchange="get_schools(this.value)" class="form-control" required>
								<option value=""></option>
								<?php
								foreach($dt2_opts as $row){
									$selected = ($row['dt2_id']==$dt2_id?'selected':'');
									echo "<option value='".$row['dt2_id']."' ".$selected.">".$row['nama_dt2']."</option>";
								}
								?>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_sekolah_id">Sekolah <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input state-disabled">
							<div id="loader_input_sekolah_id" style='display:none'>
								<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
							</div>
							<div id="content_input_sekolah_id">
								<select name="input_sekolah_id" id="input_sekolah_id" class="form-control" required>
									<option value="">-- Pilih Kab./Kota lebih dulu --</option>
									<?php
										foreach($sekolah_opts as $opt){
											$selected = ($opt['sekolah_id']==$curr_data['sekolah_id']?'selected':'');
											echo "<option value='".$opt['sekolah_id']."' ".$selected.">".$opt['nama_sekolah']."</option>";
										}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_jml_rombel">Jml. Rombel <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input">
							<input type="text" name="input_jml_rombel" id="input_jml_rombel" value="<?=number_format($curr_data['jml_rombel']);?>" onkeypress="return only_number(this,event);" class="form-control" required/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_jml_siswa_rombel">Jml. Siswa Rombel <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input">
							<input type="text" name="input_jml_siswa_rombel" id="input_jml_siswa_rombel" value="<?=number_format($curr_data['jml_siswa_rombel']);?>"  onkeypress="return only_number(this,event);" class="form-control" required/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_kuota_domisili">Domisili <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input">
							<input type="text" name="input_kuota_domisili" id="input_kuota_domisili" value="<?=number_format($curr_data['kuota_domisili']);?>" onkeyup="count_quota();" onkeypress="return only_number(this,event);" class="form-control" required/>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="input_kuota_afirmasi">Afirmasi <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input">
							<input type="text" name="input_kuota_afirmasi" id="input_kuota_afirmasi" value="<?=number_format($curr_data['kuota_afirmasi']);?>" onkeyup="count_quota();" onkeypress="return only_number(this,event);" class="form-control" required/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_kuota_akademik">Akademik <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input">
							<input type="text" name="input_kuota_akademik" id="input_kuota_akademik" value="<?=number_format($curr_data['kuota_akademik']);?>" onkeyup="count_quota();" onkeypress="return only_number(this,event);" class="form-control" required/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_kuota_prestasi">Prestasi <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input">
							<input type="text" name="input_kuota_prestasi" id="input_kuota_prestasi" value="<?=number_format($curr_data['kuota_prestasi']);?>" onkeyup="count_quota();" onkeypress="return only_number(this,event);" class="form-control" required/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_kuota_khusus">Khusus <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input">
							<input type="text" name="input_kuota_khusus" id="input_kuota_khusus" value="<?=number_format($curr_data['kuota_khusus']);?>" onkeyup="count_quota();" onkeypress="return only_number(this,event);" class="form-control" required/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_jml_kuota">Jml. Kuota <font color="red">*</font></label>
					<div class="col-md-9">
						<div class="input">
							<input type="text" name="input_jml_kuota" id="input_jml_kuota" value="<?=number_format($curr_data['jml_kuota']);?>" class="form-control" readonly/>
						</div>
					</div>
				</div>
			</div>
		</div>			
	</fieldset>
</div>
<div class="modal-footer">
	<button type="submit" class="btn btn-primary">
		Simpan
	</button>
	<button type="button" class="btn btn-default" id="close-modal-form" data-dismiss="modal">
		Batal
	</button>
</div>
</form>

<script type="text/javascript">
	
	var quota2_form_id = '<?=$form_id;?>';
    var $quota2_form=$('#'+quota2_form_id);
    var act = "<?=$act;?>"
    var quota2_stat=$quota2_form.validate({
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $quota2_form.submit(function(){
        if(quota2_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_content('#list_quota2')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($quota2_form)
                           .submit_ajax((act=='add'?'menambah':'merubah')+' data');
            $('#close-modal-form').click();
            return false;
        }
    });


    function count_quota(){
    	var $domisili = $('#input_kuota_domisili'), $afirmasi = $('#input_kuota_afirmasi'), $akademik = $('#input_kuota_akademik'), $prestasi = $('#input_kuota_prestasi'), 
    		$khusus = $('#input_kuota_khusus'), $kuota = $('#input_jml_kuota');
    	
    	var domisili = gnv($domisili.val()), afirmasi = gnv($afirmasi.val()), akademik = gnv($akademik.val()), prestasi = gnv($prestasi.val()),
    		khusus = gnv($khusus.val()), kuota = 0;

    	domisili = replaceall(domisili,',','');
    	afirmasi = replaceall(afirmasi,',','');
    	akademik = replaceall(akademik,',','');
    	prestasi = replaceall(prestasi,',','');
    	khusus = replaceall(khusus,',','');

		kuota = parseFloat(domisili)+parseFloat(afirmasi)+parseFloat(akademik)+parseFloat(prestasi)+parseFloat(khusus);

    	kuota = (kuota==0?0:number_format(kuota,0,'.',','));
    	$kuota.val(kuota);
    }

    function get_schools(dt2_id){
		ajax_object.reset_object();
		var data_ajax = new Array('dt2_id='+dt2_id,'tipe_sekolah_id=1');
        ajax_object.set_url($('#baseUrl').val()+'config/get_schools').set_data_ajax(data_ajax).set_loading('#loader_input_sekolah_id').set_content('#content_input_sekolah_id').request_ajax();
	}
</script>