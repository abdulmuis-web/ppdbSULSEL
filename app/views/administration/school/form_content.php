<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form Sekolah</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_school_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>
	<input type="hidden" name="act" value="<?=$act?>"/>
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
	<input type="hidden" id="search_dt2" name="search_dt2" value="<?=$search_dt2;?>"/>
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">

				<div class="form-group">
					<label class="control-label col-md-3" for="input_sekolah_id">ID <font color="red">*</font></label>
					<div class="col-md-2">						
						<div class="input">
							<input class="form-control" id="input_sekolah_id" type="text" name="input_sekolah_id" onkeypress="return only_number(this,event);" value="<?=$sekolah_id;?>" <?=($act=='add'?'required':'readonly');?>/>
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_tipe_sekolah_id">Jenjang <font color="red">*</font></label>
					<div class="col-md-8">						
						<div class="input state-disabled">
							<select name="input_tipe_sekolah_id" id="input_tipe_sekolah_id" class="form-control" required>
								<option value=""></option>
								<?php
								foreach($jenjang_opts as $row){
									$selected = ($row['ref_tipe_sklh_id']==$curr_data['tipe_sekolah_id']?'selected':'');
									echo "<option value='".$row['ref_tipe_sklh_id']."' ".$selected.">".$row['nama_tipe_sekolah']." (".$row['akronim'].")</option>";
								}
								?>
							</select>
						</div>							
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_nama_sekolah">Nama Sekolah <font color="red">*</font></label>
					<div class="col-md-8">						
						<div class="input">
							<input class="form-control" id="input_nama_sekolah" type="text" name="input_nama_sekolah" value="<?=$curr_data['nama_sekolah'];?>" required/>
						</div>						
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_dt2_id">Kab./Kota <font color="red">*</font></label>
					<div class="col-md-8">						
						<div class="input state-disabled">
							<select name="input_dt2_id" id="input_dt2_id" class="form-control" required>
								<option value=""></option>
								<?php
								foreach($dt2_opts as $row){
									$selected = ($row['dt2_id']==$curr_data['dt2_id']?'selected':'');
									echo "<option value='".$row['dt2_id']."' ".$selected.">".$row['nama_dt2']."</option>";
								}
								?>
							</select>
							
						</div>						
					</div>
				</div>				

				<div class="form-group">
					<label class="control-label col-md-3" for="input_alamat">Alamat</label>
					<div class="col-md-8">						
						<div class="input">
							<input class="form-control" id="input_alamat" type="text" name="input_alamat" value="<?=$curr_data['alamat'];?>">
						</div>							
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_telepon">No. Telepon</label>
					<div class="col-md-8">						
						<div class="input">
							<input class="form-control" id="input_telepon" type="text" name="input_telepon" value="<?=$curr_data['telepon'];?>">
						</div>							
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_email">Email</label>
					<div class="col-md-8">						
						<div class="input">
							<input class="form-control" id="input_email" type="email" name="input_email" value="<?=$curr_data['email'];?>">
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
	
	var school_form_id = '<?=$form_id;?>';
    var $school_form=$('#'+school_form_id);
    var school_stat=$school_form.validate({    		
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});
   
    var act = "<?=$act;?>";

    $school_form.submit(function(){
    	var lbl_act = (act=='add'?'menambah':'merubah')+' data';
        if(school_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_plugin_datatable(true).set_content('#list_of_data')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($school_form)
                           .submit_ajax(lbl_act);
            $('#close-modal-form').click();
            return false;
        }
    });

	
</script>