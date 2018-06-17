<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Pengaturan Bobot Jarak</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_weights_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>	
	<input type="hidden" name="type" value="1"/>	
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
	<input type="hidden" name="act" value="<?=$act;?>"/>
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">

				<div class="form-group">
					<label class="control-label col-md-4">Jarak Min <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input type="text" class="form-control" name="input_jarak_min" value="<?=$curr_data['jarak_min'];?>" onkeypress="return only_number(this,event)" id="input_jarak_min" required>
						</div>						
					</div>					
				</div>

				<div class="form-group">
					<label class="control-label col-md-4">Jarak Max <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input type="text" class="form-control" name="input_jarak_max" value="<?=$curr_data['jarak_max'];?>" onkeypress="return only_number(this,event)" id="input_jarak_max" required>
						</div>						
					</div>					
				</div>

				<div class="form-group">
					<label class="control-label col-md-4">Bobot</label>
					<div class="col-md-4">
						<div class="input">
							<input type="text" id="input_bobot" name="input_bobot" class="form-control" value="<?=$curr_data['bobot'];?>" required>
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

	var weights1_form_id = '<?=$form_id;?>';
    var $weights1_form=$('#'+weights1_form_id);
    var weights1_stat=$weights1_form.validate({
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $weights1_form.submit(function(){
        if(weights1_stat.checkForm())
        {
        	ajax_object.reset_object();
            ajax_object.set_content('#list_weights1')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($weights1_form)
                           .submit_ajax('merubah data');
            $('#close-modal-form').click();
            return false;
        }
    });

</script>