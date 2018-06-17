
<form action="<?=base_url().$active_controller;?>/submit_condition_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="act" value="edit"/>
	<input type="hidden" name="type" value="3"/>
	<input type="hidden" name="id" value=""/>
	<div class="form-group">
		<div class="col-md-12">
			<textarea class="ketentuan3_textarea" id="input_deskripsi" name="input_deskripsi" class="custom-scroll" style="max-height:180px;">
				<?=$deskripsi;?>
			</textarea>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" align="center">
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</div>
</form>

<script type="text/javascript">
	$(document).ready(function(){
		tinymce.remove();
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

	var condition3_form_id = '<?=$form_id;?>';
    var $condition3_form=$('#'+condition3_form_id);    
    var condition3_stat=$condition3_form.validate({
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $condition3_form.submit(function(){
        if(condition3_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_content('')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($condition3_form)
                           .submit_ajax('merubah data');
            $('#close-modal-form').click();
            return false;
        }
    });

</script>