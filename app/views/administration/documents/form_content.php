<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Dokumen Kelengkapan</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_document_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>
	<input type="hidden" name="act" value="<?=$act?>"/>
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-3" for="input_nama_dokumen">Nama Dokumen <font color="red">*</font></label>
					<div class="col-md-8">
						<div class="input">
							<input class="form-control" id="input_nama_dokumen" type="text" name="input_nama_dokumen" value="<?=$curr_data['nama_dokumen'];?>" required/>
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
	
	var doc_form_id = '<?=$form_id;?>';
	var act = '<?=$act;?>';
    var $doc_form=$('#'+doc_form_id);
    var doc_stat=$doc_form.validate({    		

    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $doc_form.submit(function(){
        if(doc_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_plugin_datatable(true).set_content('#list_of_data')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($doc_form)
                           .submit_ajax((act=='add'?'menyimpan':'merubah')+' data');
            $('#close-modal-form').click();
            return false;
        }
    });
	
</script>