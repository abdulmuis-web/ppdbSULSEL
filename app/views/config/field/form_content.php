<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Kompetensi SMK</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_field_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>
	<input type="hidden" name="act" value="<?=$act?>"/>
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
	<input type="hidden" id="search_dt2" name="search_dt2" value="<?=$search_dt2;?>"/>
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">

				<div class="form-group">
					<label class="control-label col-md-3" for="input_kompetensi_id">ID <font color="red">*</font></label>
					<div class="col-md-2">						
						<div class="input">
							<input class="form-control" id="input_kompetensi_id" type="text" name="input_kompetensi_id" onkeypress="return only_number(this,event);" value="<?=$kompetensi_id;?>" <?=($act=='add'?'required':'readonly');?>/>
						</div>						
					</div>
				</div>
				
				<div class="form-group">
					<label class="control-label col-md-3" for="input_nama_kompetensi">Kompetensi <font color="red">*</font></label>
					<div class="col-md-8">
						<div class="input">
							<input class="form-control" id="input_nama_kompetensi" type="text" name="input_nama_kompetensi" value="<?=$curr_data['nama_kompetensi'];?>" required/>
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_dt2_id">Kab./Kota <font color="red">*</font></label>
					<div class="col-md-8">						
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
					<div class="col-md-8">
						<div class="input state-disabled">
							<div id="loader_input_sekolah_id" style='display:none'>
								<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
							</div>
							<div id="content_input_sekolah_id">
								<select name="input_sekolah_id" id="input_sekolah_id" class="form-control" required>
									<option value="">-- Pilih Kab./Kota lebihdulu --</option>
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

<link rel="stylesheet" href="<?=$this->config->item('js_path');?>plugins/iCheck/all.css">
<script type="text/javascript" src="<?=$this->config->item('js_path');?>plugins/iCheck/icheck.min.js"></script>

<script type="text/javascript">
	
	var field_form_id = '<?=$form_id;?>';
    var $field_form=$('#'+field_form_id);
    var school_stat=$field_form.validate({    		
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $field_form.submit(function(){
        if(school_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_plugin_datatable(true).set_content('#list_of_data')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($field_form)
                           .submit_ajax('menyimpan data');
            $('#close-modal-form').click();
            return false;
        }
    });

	function get_schools(dt2_id){
		ajax_object.reset_object();
		var data_ajax = new Array('dt2_id='+dt2_id,'tipe_sekolah_id=2');
        ajax_object.set_url($('#baseUrl').val()+'config/get_schools').set_data_ajax(data_ajax).set_loading('#loader_input_sekolah_id').set_content('#content_input_sekolah_id').request_ajax();
	}
</script>