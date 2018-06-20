<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">
		<span class="ribbon-button-alignment"> 
			<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
				<i class="fa fa-refresh"></i>
			</span> 
		</span>
		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>Home</li><li>Pengaturan</li><li>Sistem</li>
		</ol>		

	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">

		<div class="row">
			<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
				<h1 class="page-title txt-color-blueDark">		
					<!-- PAGE HEADER -->
					<i class="fa-fw fa fa-pencil-square-o"></i> 
						Pengaturan
					<span>>  
						Sistem
					</span>
				</h1>
			</div>	
		</div>

		
		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					
					<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false">						
						
						<header>
							<span class="widget-icon"> <i class="fa fa-gear"></i> </span>
							<h2>Perubahan Data Akun</h2>
						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->

							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body">

								<form class="form-horizontal" id="<?=$form_id;?>" action="<?=base_url().$active_controller;?>/update_system" method="POST">
									<input type="hidden" id="update_access" value="<?=($update_access?'1':'0');?>"/>
									<fieldset>
										<div class="form-group">
											<label class="col-md-2 control-label">Tahun Pelajaran</label>
											<div class="col-md-2">
												<div class="input">
													<input class="form-control" name="input_thn_pelajaran" id="input_thn_pelajaran" type="text" value="<?=$_SYS_PARAMS[0];?>">
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-2 control-label">Status Sistem</label>
											<div class="col-md-2">
												<div class="input state-disabled">
													<select name="input_status_sistem" id="input_status_sistem" class="form-control" required>
														<?php
															foreach(array('yes'=>'Terbuka','no'=>'Terkunci') as $key=>$val){
																$selected = ($_SYS_PARAMS[6]==$key?'selected':'');
																echo "<option value='".$key."' ".$selected.">".$val."</option>";
															}
														?>
													</select>
												</div>
											</div>
										</div>	

										<div class="form-actions">
											<div class="row">
												<div class="col-md-6">													
												</div>
												<div class="col-md-6">													
													<button class="btn btn-primary" type="submit">
														<i class="fa fa-save"></i>
														Submit
													</button>
												</div>
											</div>
										</div>									

									</fieldset>
								</form>

							</div>
							<!-- end widget content -->

						</div>
						<!-- end widget div -->

					</div>
					<!-- end widget -->

				</article>
				<!-- WIDGET END -->				

			</div>

			<!-- end row -->			

		</section>
		<!-- end widget grid -->

		<!-- widget grid -->
		<section id="widget-grid" class="">
			<!-- row -->
			<div id="data-view-loader" align="center" style="display:none">
				<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-7.gif"/>
			</div>
			<div class="row" id="data-view">
			</div>

			

			<!-- end row -->
		</section>
		<!-- end widget grid -->

	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<script type="text/javascript">	
	
	var system_form_id = '<?=$form_id;?>';
    var $system_form=$('#'+system_form_id);
    var system_form_stat=$system_form.validate({
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});   	

    $system_form.submit(function(){
    	if($('#update_access').val()=='1')
    	{
	        if(system_form_stat.checkForm())
	        {        	
	        	ajax_object.reset_object();
	            ajax_object.set_content('')
	                           .set_loading('#preloadAnimation')
	                           .enable_pnotify()
	                           .set_form($system_form)
	                           .submit_ajax('merubah data');	            
	        }
	    }else{
	    	alert('Anda tidak diijinkan merubah data');	    	
	    }
	    return false;
    });



</script>