<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Pengumuman</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_announcement_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>
	<input type="hidden" name="act" value="<?=$act?>"/>
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-2" for="input_judul">Judul <font color="red">*</font></label>
					<div class="col-md-8">
						<div class="input">
							<input class="form-control" id="input_judul" type="text" name="input_judul" value="<?=$curr_data['judul'];?>" required/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2" for="input_deskripsi">Deskripsi</label>
					<div class="col-md-10">
						<div class="input">
							<textarea class="richTextarea" id="input_deskripsi" name="input_deskripsi" class="custom-scroll" style="max-height:250px;">
								<?=$curr_data['deskripsi'];?>
							</textarea>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-2" for="input_status">Status</label>
					<div class="col-md-3">
						<div class="input state-disabled">
							<select name="input_status" id="input_status" class="form-control">
								<?php
									foreach(array('0'=>'Nonaktif','1'=>'Aktif') as $key=>$val){

										$selected = ($curr_data['status']==$key?'selected':'');
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

<script src="<?=$this->config->item('js_path')?>plugins/tinymce/js/tinymce/tinymce.min.js"></script>

<script type="text/javascript">
	
	$(document).ready(function(){
		tinymce.remove();
		tinymce.init({
		    selector: '.richTextarea',
		     theme: "modern",
		     plugins: [
				        ["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker"],
				        ["searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking"],
				        ["save table contextmenu directionality emoticons template paste"]
				    ],
		  });
	});

	var announcement_form_id = '<?=$form_id;?>';
	var act = '<?=$act;?>';
    var $announcement_form=$('#'+announcement_form_id);
    var announcement_stat=$announcement_form.validate({    		

    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $announcement_form.submit(function(){
        if(announcement_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_plugin_datatable(true).set_content('#list_of_data')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($announcement_form)
                           .submit_ajax((act=='add'?'menyimpan':'merubah')+' data');
            $('#close-modal-form').click();
            return false;
        }
    });
	
</script>