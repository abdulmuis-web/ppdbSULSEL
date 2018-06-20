<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Kabupaten Perbatasan</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_border_regency_data" id="<?=$form_id?>" method="POST" class="form-horizontal">	
	<input type="hidden" name="act" value="<?=$act?>"/>
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
	<input type="hidden" id="search_dt2" name="search_dt2" value="<?=$search_dt2;?>"/>

	<input type="hidden" id="dt2_id" name="dt2_id" value="<?=$dt2_id;?>"/>
	<input type="hidden" id="dt2_sekolah_id" name="dt2_sekolah_id" value="<?=$dt2_sekolah_id;?>"/>
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">				

				<div class="form-group">
					<label class="control-label col-md-4" for="input_dt2_id">Kab./Kota <font color="red">*</font></label>
					<div class="col-md-8">
						<div class="input state-disabled">
							<select name="input_dt2_id" id="input_dt2_id" class="form-control" <?=($this->session->userdata('admin_type_id')=='3'?'disabled':'');?>>
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
					<label class="control-label col-md-4" for="input_dt2_sekolah_id">Kab./Kota Perbatasan <font color="red">*</font></label>
					<div class="col-md-8">						
						<div class="input state-disabled">
							<select name="input_dt2_sekolah_id" id="input_dt2_sekolah_id" class="form-control" required>
								<option value=""></option>
								<?php
								foreach($dt2_sekolah_opts as $row){
									$selected = ($row['dt2_id']==$curr_data['dt2_sekolah_id']?'selected':'');
									echo "<option value='".$row['dt2_id']."' ".$selected.">".$row['nama_dt2']."</option>";
								}
								?>
							</select>
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

	
</script>