<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Pengaturan Dokumen Persyaratan</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_condition_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>	
	<input type="hidden" name="type" value="5"/>
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
	<input type="hidden" name="act" value="<?=$act;?>"/>
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-4" for="input_jalur_id">Jalur Pendaftaran <font color="red">*</font></label>
					<div class="col-md-8">
						<div class="input state-disabled">
							<select name="input_jalur_id" id="input_jalur_id" class="form-control" required>
								<option value=""></option>
								<?php
								foreach($jalur_opts as $row){
									$selected = ($row['ref_jalur_id']==$curr_data['jalur_id']?'selected':'');
									echo "<option value='".$row['ref_jalur_id']."' ".$selected.">".$row['nama_jalur']."</option>";
								}
								?>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-4" for="input_dokumen_id">Dokumen <font color="red">*</font></label>
					<div class="col-md-8">
						<div class="input state-disabled">
							<select name="input_dokumen_id" id="input_dokumen_id" class="form-control" required>
								<option value=""></option>
								<?php
								foreach($dokumen_opts as $row){
									$selected = ($row['ref_dokumen_id']==$curr_data['dokumen_id']?'selected':'');
									echo "<option value='".$row['ref_dokumen_id']."' ".$selected.">".$row['nama_dokumen']."</option>";
								}
								?>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-4" for="input_status">Status</label>
					<div class="col-md-8">
						<div class="input state-disabled">
							<select name="input_status" id="input_status" class="form-control">								
								<?php
								$opts = array('mandatory'=>'Wajib','optional'=>'Opsional');
								foreach($opts as $key=>$val){
									$selected = ($key==$curr_data['status']?'selected':'');
									echo "<option value='".$key."' ".$selected.">".$val."</option>";
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
	
	var condition5_form_id = '<?=$form_id;?>';
    var $condition5_form=$('#'+condition5_form_id);
    var act = "<?=$act;?>"
    var condition5_stat=$condition5_form.validate({
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $condition5_form.submit(function(){
        if(condition5_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_content('#list_condition5')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($condition5_form)
                           .submit_ajax((act=='add'?'menambah':'merubah')+' data');
            $('#close-modal-form').click();
            return false;
        }
    });

</script>