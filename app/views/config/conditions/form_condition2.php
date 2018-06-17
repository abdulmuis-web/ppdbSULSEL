<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Ketentuan Jalur</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_condition_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>	
	<input type="hidden" name="type" value="2"/>	
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
					<div class="col-md-12">
						<div class="input">
							<textarea type="text" class='ketentuan2_textarea' id="input_ketentuan" name="input_ketentuan" class="form-control" required>
								<?=$curr_data['ketentuan'];?>
							</textarea>
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
	$(function(){
		tinymce.remove();
    	tinymce.init({
		    selector: '.ketentuan2_textarea',
		     theme: "modern",
		     plugins: [
				        ["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker"],
				        ["searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking"],
				        ["save table contextmenu directionality emoticons template paste"]
				    ],
		  });

    	tinymce.init({
		    selector: '.ketentuan3_textarea',
		     theme: "modern",
		     plugins: [
				        ["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker"],
				        ["searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking"],
				        ["save table contextmenu directionality emoticons template paste"]
				    ],
		  });
    });	

	var condition2_form_id = '<?=$form_id;?>';
    var $condition2_form=$('#'+condition2_form_id);
    var act = "<?=$act;?>"
    var condition2_stat=$condition2_form.validate({
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $condition2_form.submit(function(){
        if(condition2_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_content('#list_condition2')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($condition2_form)
                           .submit_ajax((act=='add'?'menambah':'merubah')+' data');
            $('#close-modal-form').click();
            return false;
        }
    });

</script>