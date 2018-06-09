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
			<li>Home</li><li>Pengaturan</li><li>Akun</li>
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
						Akun
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

								<form class="form-horizontal" id="<?=$form_id;?>" action="<?=base_url().$active_controller;?>/update_account" method="POST">									
									<fieldset>
										<div class="form-group">
											<label class="col-md-2 control-label">Username Baru</label>
											<div class="col-md-4">
												<input class="form-control" name="input_username" id="input_username" type="text">
												<span class="help-block">Kosongkan jika tidak ingin mengganti</span>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-2 control-label">Password Baru</label>
											<div class="col-md-4">
												<input class="form-control" type="password" name="input_password" id="input_password" required>												
											</div>
										</div>

										<div class="form-actions">
											<div class="row">
												<div class="col-md-6">
													<div id="account-form-loader" align="left" style="display:none">
														<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/> mohon tunggu sebentar ...														
													</div>
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
	
	var account_form_id = '<?=$form_id;?>';
    var $account_form=$('#'+account_form_id);
    var account_form_stat=$account_form.validate({
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $account_form.submit(function(){
        if(account_form_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_content('')                           
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($account_form)
                           .submit_ajax('merubah data');
            $account_form[0].reset();
            return false;
        }

    });



</script>