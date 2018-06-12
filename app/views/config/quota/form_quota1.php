<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Pengaturan Kuota Jalur</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_quota_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>	
	<input type="hidden" name="type" value="1"/>	
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
	<input type="hidden" name="quota_seq" value="<?=$quota_seq;?>"/>
	<input type="hidden" name="tipe_sekolah_id" value="<?=$tipe_sekolah_id;?>"/>
	<input type="hidden" name="tipe_sekolah" value="<?=$tipe_sekolah;?>"/>
	<input type="hidden" name="act" value="<?=$act;?>"/>
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">

				<div class="form-group">
					<label class="control-label col-md-4">Jml. Sekolah Pilihan <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input type="text" class="form-control" name="input_jml_sekolah" value="<?=$curr_data['jml_sekolah'];?>" onkeypress="return only_number(this,event)" id="input_jml_sekolah" required>
						</div>						
					</div>					
				</div>

				<div class="form-group">
					<label class="control-label col-md-4">Persentase Kuota <font color="red">*</font></label>
					<div class="col-md-4">
						<div class="input">
							<input type="text" class="form-control" name="input_persen_kuota" onkeyup="count_quota();" value="<?=number_format($curr_data['persen_kuota']);?>" onkeypress="return only_number(this,event)" id="input_persen_kuota" required>
						</div>						
					</div>					
				</div>

				<div class="form-group">
					<label class="control-label col-md-4">Daya Tampung <?=$tipe_sekolah;?></label>
					<div class="col-md-4">
						<div class="input">
							<input type="text" id="input_daya_tampung" class="form-control" value="<?=number_format($daya_tampung);?>" onkeypress="return only_number(this,event)" readonly>
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-4">Kuota Jalur</label>
					<div class="col-md-4">
						<div class="input">
							<input type="text" id="input_jumlah_kuota" name="input_jumlah_kuota" class="form-control" value="<?=number_format($curr_data['jumlah_kuota']);?>" readonly>
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

	var quota1_form_id = '<?=$form_id;?>', quota1_seq = '<?=$quota_seq;?>';
    var $quota1_form=$('#'+quota1_form_id);
    var quota1_stat=$quota1_form.validate({
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $quota1_form.submit(function(){
        if(quota1_stat.checkForm())
        {
        	ajax_object.reset_object();
            ajax_object.set_content('#list_quota1_'+quota1_seq)
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($quota1_form)
                           .submit_ajax('merubah data');
            $('#close-modal-form').click();
            return false;
        }
    });

    function count_quota(){
    	var $persen = $('#input_persen_kuota'), $tampung = $('#input_daya_tampung'), $kuota = $('#input_jumlah_kuota');
    	var persen = gnv($persen.val()), tampung = gnv($tampung.val()), kuota = 0;

    	persen = replaceall(persen,',','');
    	tampung = replaceall(tampung,',','');

		kuota = parseFloat(persen)*parseFloat(tampung)/100;

    	kuota = (kuota==0?0:number_format(kuota,0,'.',','));
    	$kuota.val(kuota);
    }

</script>