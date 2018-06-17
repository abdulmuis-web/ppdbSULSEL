<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Sekolah Perbatasan</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_border_school_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>
	<input type="hidden" name="act" value="<?=$act?>"/>
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
	<input type="hidden" id="search_dt2" name="search_dt2" value="<?=$search_dt2;?>"/>	
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">				

				<div class="form-group">
					<label class="control-label col-md-4" for="input_dt2_id">Kab./Kota <font color="red">*</font></label>
					<div class="col-md-8">
						<div class="input state-disabled">
							<select name="input_dt2_id" id="input_dt2_id" onchange="get_border_regencies(this.value)" class="form-control">								
								<?php
								if($this->session->userdata('admin_type_id')!='3')
									echo "<option value=''></option>";

								foreach($dt2_opts as $row){
									$selected = ($row['dt2_id']==$curr_data['dt2_id']?'selected':'');
									echo "<option value='".$row['dt2_id']."' ".$selected.">".$row['nama_dt2']."</option>";
								}
								?>
							</select>
						</div>							
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-4" for="input_sekolah_id">Kab./Kota Perbatasan <font color="red">*</font></label>
					<div class="col-md-8">						
						<div class="input state-disabled">
							<div id="loader_input_dt2_perbatasan_id" style='display:none'>
								<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
							</div>
							<div id="content_input_dt2_perbatasan_id">
								<select name="input_dt2_perbatasan_id" id="input_dt2_perbatasan_id" onchange="get_schools(this.value)" class="form-control" required>
									<option value=""><?=($act=='add' && $this->session->userdata('admin_type_id')!='3'?"-- Pilih Kab./Kota lebih dulu --":"");?></option>
									<?php
									foreach($dt2_sekolah_opts as $row){
										$selected = ($row['dt2_id']==$curr_data['dt2_perbatasan_id']?'selected':'');
										echo "<option value='".$row['dt2_id']."' ".$selected.">".$row['nama_dt2']."</option>";
									}
									?>
								</select>
							</div>
						</div>							
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-4" for="input_sekolah_id">Sekolah <font color="red">*</font></label>
					<div class="col-md-8">
						<div class="input state-disabled">
							<div id="loader_input_sekolah_id" style='display:none'>
								<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
							</div>
							<div id="content_input_sekolah_id">
								<select name="input_sekolah_id" id="input_sekolah_id" class="form-control" required>
									<option value=""><?=($act=='add'?"-- Pilih Kab./Kota Perbatasan lebih dulu --":"");?></option>
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
	
	var border_regency_id = '<?=$form_id;?>';
    var $border_regency=$('#'+border_regency_id);
    var border_regency_stat=$border_regency.validate({    		
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

   	var act = "<?=$act;?>";

    $border_regency.submit(function(){
    	var lbl_act = (act=='add'?'menambah':'merubah')+' data';
        if(border_regency_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_plugin_datatable(true).set_content('#list_of_data')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($border_regency)
                           .submit_ajax(lbl_act);
            $('#close-modal-form').click();
            return false;
        }
    });

    function get_schools(dt2_id){
		ajax_object.reset_object();
		var data_ajax = new Array('dt2_id='+dt2_id);
        ajax_object.set_url($('#baseUrl').val()+'config/get_schools').set_data_ajax(data_ajax).set_loading('#loader_input_sekolah_id').set_content('#content_input_sekolah_id').request_ajax();
	}

	function get_border_regencies(dt2_id){
		ajax_object.reset_object();
		var data_ajax = new Array('dt2_id='+dt2_id,'onchange=1');
        ajax_object.set_url($('#baseUrl').val()+'config/get_border_regencies').set_data_ajax(data_ajax).set_loading('#loader_input_dt2_perbatasan_id').set_content('#content_input_dt2_perbatasan_id').request_ajax();
	}
	
</script>