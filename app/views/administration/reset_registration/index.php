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
			<li>Home</li><li>Administrasi</li><li>Reset Pendaftaran</li>
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
						Administrasi
					<span>>  
						Reset Pendaftaran
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
							<span class="widget-icon"> <i class="fa fa-search"></i> </span>
							<h2>Pencarian Data Registrasi</h2>
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
		
								<form class="form-horizontal" id="<?=$form_id;?>" action="<?=base_url();?>administration/search_registration_for_reset" method="POST">
									<fieldset>												
										<div class="col-md-4 col-md-offset-4">
											<div class="input-group">
												<input class="form-control" type="text" name="src_registrasi" id="src_registrasi" style="font-weight:bold;font-size:1.2em;" placeholder="Masukkan No. Registrasi ...." required/>
												<div class="input-group-btn">
													<button class="btn btn-default btn-primary" type="submit">
														<i class="fa fa-search"></i> Search
													</button>
												</div>
											</div>											
										</div>
									</fieldset>
								</form>

								<div id="data-view">
								</div>								
		
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
		

	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->


<script type="text/javascript">	

	var search_form_id = '<?=$form_id;?>';
    var $search_form=$('#'+search_form_id);
    var search_stat=$search_form.validate({
        // Do not change code below
        errorPlacement : function(error, element) {
            error.addClass('error');
            error.insertAfter(element.parent());
        }
    });

    $search_form.submit(function(){
        if(search_stat.checkForm())
        {        	
        	ajax_object.reset_object();
            ajax_object.set_content('#data-view')                           
                           .set_loading('#preloadAnimation')
                           .disable_pnotify()
                           .set_form($search_form)
                           .submit_ajax('');
            return false;
        }

    });	    

</script>