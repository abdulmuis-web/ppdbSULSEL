<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Ketentuan Umum</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_condition_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>	
	<input type="hidden" name="type" value="1"/>	
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
	<input type="hidden" name="act" value="<?=$act;?>"/>
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">

				<div class="form-group">					
					<div class="col-md-12">
						<div class="input">
							<textarea type="text" class='ketentuan1_textarea' id="input_ketentuan" name="input_ketentuan" class="form-control" required>
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
		    selector: '.ketentuan1_textarea',
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

	var condition1_form_id = '<?=$form_id;?>';
    var $condition1_form=$('#'+condition1_form_id);
    var act = "<?=$act;?>";
    var condition1_stat=$condition1_form.validate({
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $condition1_form.submit(function(){
        if(condition1_stat.checkForm())
        {
        	ajax_object.reset_object();
            ajax_object.set_content('#list_condition1')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($condition1_form)
                           .submit_ajax((act=='add'?'menambah':'merubah')+' data');
            $('#close-modal-form').click();
            return false;
        }
    });

</script>