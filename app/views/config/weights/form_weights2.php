<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Pengaturan Bobot Prestasi</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_weights_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>	
	<input type="hidden" name="type" value="2"/>
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
	<input type="hidden" name="act" value="<?=$act;?>"/>
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">

				<div class="form-group">
					<label class="control-label col-md-4" for="input_tkt_kejuaraan_id">Tingkat Kejuaraan <font color="red">*</font></label>
					<div class="col-md-8">
						<div class="input state-disabled">
							<select name="input_tkt_kejuaraan_id" id="input_tkt_kejuaraan_id" class="form-control" disabled>
								<option value=""></option>
								<?php
								foreach($tkt_kejuaraan_opts as $row){
									$selected = ($row['ref_tkt_kejuaraan_id']==$curr_data['tkt_kejuaraan_id']?'selected':'');
									echo "<option value='".$row['ref_tkt_kejuaraan_id']."' ".$selected.">".$row['tingkat_kejuaraan']."</option>";
								}
								?>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-4" for="input_bobot_juara1">Juara 1 <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input type="text" class="form-control" name="input_bobot_juara1" value="<?=$curr_data['bobot_juara1'];?>" onkeypress="return only_number(this,event)" id="input_bobot_juara1" required>
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-4" for="input_bobot_juara2">Juara 2 <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input type="text" class="form-control" name="input_bobot_juara2" value="<?=$curr_data['bobot_juara2'];?>" onkeypress="return only_number(this,event)" id="input_bobot_juara2" required>
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-4" for="input_bobot_juara3">Juara 3 <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input type="text" class="form-control" name="input_bobot_juara3" value="<?=$curr_data['bobot_juara3'];?>" onkeypress="return only_number(this,event)" id="input_bobot_juara3" required>
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
            ajax_object.set_content('#list_weights2')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($weights1_form)
                           .submit_ajax('merubah data');
            $('#close-modal-form').click();
            return false;
        }
    });

</script>