<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
		&times;
	</button>
	<h4 class="modal-title">Form User</h4>
</div>
<form action="<?=base_url().$active_controller;?>/submit_user_data" id="<?=$form_id?>" method="POST" class="form-horizontal">
	<input type="hidden" name="id" value="<?=$id_value?>"/>
	<input type="hidden" name="act" value="<?=$act?>"/>
	<input type="hidden" id="baseUrl" value="<?=base_url()?>"/>
<div class="modal-body">
	<fieldset style="padding:15px;">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="control-label col-md-3" for="input_fullname">Nama <font color="red">*</font></label>
					<div class="col-md-8">
						<div class="input">
							<input class="form-control" id="input_fullname" type="text" name="input_fullname" value="<?=$curr_data['fullname'];?>" required/>
						</div>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_type_fk">Jenis User<?=($admin_type_id!='3'?" <font color='red'>*</font>":"");?></label>
					<div class="col-md-8">
						<div class="input state-disabled">
							<?php
							echo "
							<select name='input_type_fk' id='input_type_fk' onchange=\"control_school_input(this.value)\" class='form-control' required>";
								if($admin_type_id!='3'){
									echo "<option value=''></option>";
								}
								foreach($user_type_rows as $row){
									$selected = ($row['type_id']==$curr_data['type_fk']?'selected':'');
									echo "<option value='".$row['type_id']."' ".$selected.">".$row['name']."</option>";
								}
							echo "</select>";
							?>
						</div>
					</div>
				</div>
				
				<div id="school-input-container" style="display:<?=$display_schoolInputContainer;?>">
					<div class="form-group">
						<label class="control-label col-md-3" for="input_dt2_id">Kab./Kota<?=($admin_type_id!='3'?" <font color='red'>*</font>":"");?></label>
						<div class="col-md-8">
							<div class="input state-disabled">
								<select name="input_dt2_id" id="input_dt2_id" onchange="get_schools(this.value)" class="form-control" <?=$attr_inputDT2Id;?>>
									<?php
									if($admin_type_id!='3'){
										echo "<option value=''></option>";
									}
									foreach($dt2_opts as $opt){
										$selected = ($opt['dt2_id']==$dt2_id?'selected':'');
										echo "<option value='".$opt['dt2_id']."' ".$selected.">".$opt['nama_dt2']."</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-3" for="input_sekolah_id">Sekolah<?=($admin_type_id!='3'?" <font color='red'>*</font>":"");?></label>
						<div class="col-md-8">
							<div class="input state-disabled">
								<div id="loader_input_sekolah_id" style='display:none'>
									<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
								</div>
								<div id="content_input_sekolah_id">
									<select name="input_sekolah_id" id="input_sekolah_id" class="form-control"  <?=$attr_inputSekolahId;?>>
										<?php
											if($admin_type_id!='3'){
												echo "<option value=''>".($act=='add'?"-- Pilih Kab./Kota lebih dulu --":"")."</option>";
											}
											foreach($sekolah_opts as $opt){
												$selected = ($opt['sekolah_id']==$curr_data['sekolah_id']?'selected':'');
												echo "<option value='".$opt['sekolah_id']."' ".$selected.">".$opt['nama_sekolah']."</option>";
											}
										?>
									</select>
								</div>
							</div>
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

				<div class="form-group">
					<label class="control-label col-md-3" for="input_phone_number">No. Telepon</label>
					<div class="col-md-8">
						<div class="input">
								<input class="form-control" id="input_phone_number" type="text" name="input_phone_number" value="<?=$curr_data['phone_number'];?>">
						</div>								
					</div>
				</div>

				<?php
					if($act=='edit')
					{
						echo "
						<div class='form-group'>
							<label class='control-label col-md-3'>&nbsp;</label>
							<div class='col-md-8'>
								<input type='checkbox' name='check_username' id='check_username' onclick=\"control_authorization_input('username',$(this).prop('checked'))\"/> Ganti Username								
							</div>
						</div>
						";
					}
				?>
				<div class="form-group">
					<label class="control-label col-md-3" for="input_username">Username <font color="red">*</font></label>
					<div class="col-md-8">						
						<div class="input">
								<input class="form-control" id="input_username" type="text" name="input_username" <?=($act=='edit'?'disabled':'required');?>/>
						</div>							
					</div>
				</div>
				<?php
					if($act=='edit')
					{
						echo "
						<div class='form-group'>
							<label class='control-label col-md-3'>&nbsp;</label>
							<div class='col-md-8'>
								<input type='checkbox' name='check_password' id='check_password' onclick=\"control_authorization_input('password',$(this).prop('checked'))\"/> Ganti Password								
							</div>
						</div>
						";
					}
				?>
				<div class="form-group">
					<label class="control-label col-md-3" for="input_password">Password <font color="red">*</font></label>
					<div class="col-md-8">						
						<div class="input">
								<input class="form-control" id="input_password" type="password" name="input_password"  <?=($act=='edit'?'disabled':'required');?>>
						</div>							
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3" for="input_konf_password">Konf. Password <font color="red">*</font></label>
					<div class="col-md-8">
						<div class="input">
								<input class="form-control" id="input_konf_password" type="password" name="input_konf_password"  <?=($act=='edit'?'disabled':'required');?>>
						</div>							
					</div>
				</div>
                
                <?php
                if($admin_type_id=='1' or $admin_type_id=='2')
                {
                	echo "
					<div class='form-group'>
						<label class='control-label col-md-3'>Status</label>
						<div class='col-md-8'>							
							<div class='input'>
								<input type='radio' class='minimal' name='input_status' id='input_status1' value='1' ".($act=='add'?'checked':($curr_data['status']=='1'?'checked':''))."/>&nbsp;Aktif&nbsp;&nbsp;
								<input type='radio' class='minimal' name='input_status' id='input_status2' value='0' ".($curr_data['status']=='0'?'checked':'')."/>&nbsp;Non Aktif
							</div>								
						</div>
					</div>";
                }
                ?>
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

<link rel="stylesheet" href="<?=$this->config->item('js_path');?>plugins/iCheck/all.css">
<script type="text/javascript" src="<?=$this->config->item('js_path');?>plugins/iCheck/icheck.min.js"></script>

<script type="text/javascript">
	
	var user_form_id = '<?=$form_id;?>';
    var $user_form=$('#'+user_form_id);
    var user_stat=$user_form.validate({
    		rules: {
                input_password: {
                    required: true                                          
                },
                input_konf_password: {
                    required: true,
                    equalTo: "#input_password"
                },                                      
            },
            messages: {
                input_password: {
                    required: "This field is required."
                },
                input_konf_password: {
                    required: "This field is required.",
                    equalTo: "Please enter the same password as above"
                },
            },

    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $user_form.submit(function(){
        if(user_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_plugin_datatable(true).set_content('#list_of_data')
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($user_form)
                           .submit_ajax('');
            $('#close-modal-form').click();
            return false;
        }
    });


	$(function(){
		//iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
          checkboxClass: 'icheckbox_minimal-blue',
          radioClass: 'iradio_minimal-blue'
        });
	});

	function control_school_input(val){
		var $container = $('#school-input-container'), $dt2_id = $('#input_dt2_id'), $sekolah_id = $('#input_sekolah_id');

		if(val=='2' || val==''){
			$container.hide();
		}else{
			$container.show();
		}

		$dt2_id.attr('disabled',val=='2');
		$dt2_id.attr('required',val!='2');

		$sekolah_id.attr('disabled',val=='2');
		$sekolah_id.attr('required',val!='2');
	}

	function control_authorization_input(type,checked){
		if(type=='username'){
			$('#input_username').attr('disabled',!checked);
			$('#input_username').attr('required',checked);
		}else{
			$('#input_password').attr('disabled',!checked);
			$('#input_password').attr('required',checked);

			$('#input_konf_password').attr('disabled',!checked);
			$('#input_konf_password').attr('required',checked);
		}
	}

	function get_schools(dt2_id){
		ajax_object.reset_object();
		var data_ajax = new Array('dt2_id='+dt2_id);
        ajax_object.set_url($('#baseUrl').val()+'config/get_schools').set_data_ajax(data_ajax).set_loading('#loader_input_sekolah_id').set_content('#content_input_sekolah_id').request_ajax();
	}
</script>