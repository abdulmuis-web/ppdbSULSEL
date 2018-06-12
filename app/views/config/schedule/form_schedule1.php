<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Jadwal Jalur Pendaftaran</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_schedule_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>	
	<input type="hidden" name="type" value="1"/>	
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
	<input type="hidden" name="schedule_seq" value="<?=$schedule_seq;?>"/>
	<input type="hidden" name="tipe_sekolah_id" value="<?=$curr_data['tipe_sklh_id'];?>"/>
	<input type="hidden" name="act" value="<?=$act;?>"/>
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">

				<div class="form-group">
					<label class="control-label col-md-3">Tgl. Buka, Tutup <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input type="text" class="form-control" name="input_tgl_buka" value="<?=(!is_null($curr_data['tgl_buka'])?indo_date_format($curr_data['tgl_buka'],'shortDate'):'');?>" id="input_tgl_buka" placeholder="Tanggal Buka" required>
						</div>						
					</div>
					<div class="col-md-4">
						<div class="input">
							<input type="text" class="form-control" name="input_tgl_tutup" value="<?=(!is_null($curr_data['tgl_tutup'])?indo_date_format($curr_data['tgl_tutup'],'shortDate'):'')?>" id="input_tgl_tutup" placeholder="Tanggal Tutup" required>
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

<script src="<?=$this->config->item('js_path');?>plugins/masked-input/jquery.maskedinput.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){

		$("#input_tgl_buka").mask('99-99-9999');
		$("#input_tgl_tutup").mask('99-99-9999');

		// START AND FINISH DATE
		$('#input_tgl_buka').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#input_tgl_tutup').datepicker('option', 'minDate', selectedDate);
			}
		});
		
		$('#input_tgl_tutup').datepicker({
			dateFormat : 'dd-mm-yy',
			prevText : '<i class="fa fa-chevron-left"></i>',
			nextText : '<i class="fa fa-chevron-right"></i>',
			onSelect : function(selectedDate) {
				$('#input_tgl_buka').datepicker('option', 'maxDate', selectedDate);
			}
		});

	});

	var schedule1_form_id = '<?=$form_id;?>', schedule1_seq = '<?=$schedule_seq;?>', act = "<?=$act;?>";
    var $schedule1_form=$('#'+schedule1_form_id);
    var schedule1_stat=$schedule1_form.validate({
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $schedule1_form.submit(function(){
        if(schedule1_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_content('#list_schedule1_'+schedule1_seq)
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($schedule1_form)
                           .submit_ajax((act=='add'?'menambah':'merubah')+' data');
            $('#close-modal-form').click();
            return false;
        }
    });

</script>