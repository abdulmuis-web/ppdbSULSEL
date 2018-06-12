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
			<li>Home</li><li>Pengaturan</li><li>Kuota</li>
		</ol>
	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">
		
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<h1 class="page-title txt-color-blueDark">
					<!-- PAGE HEADER -->
					<i class="fa-fw fa fa-pencil-square-o"></i> 
						Pengaturan
					<span>>  
						Kuota
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
					<!-- Widget ID (each widget will need unique ID)-->
					<div class="jarviswidget" id="wid-id-7" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">

						<header>
							
							<ul class="nav nav-tabs pull-left in">
		
								<li class="active">
									<a data-toggle="tab" href="#hr1"> Jalur </span> </a>
								</li>
		
								<li>
									<a data-toggle="tab" href="#hr2"> SMA </span></a>
								</li>

								<li>
									<a data-toggle="tab" href="#hr3"> SMK </span></a>
								</li>
		
							</ul>

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
								<input type="hidden" id="base_url" value="<?=base_url();?>"/>
								<div class="tab-content">
									<div class="tab-pane active" id="hr1">										
										<div id="loader-hr1" style="display:block" align="center">
											<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
										</div>
										<div id="content-hr1"></div>
									</div>
									<div class="tab-pane" id="hr2">
										<div id="loader-hr2" style="display:block" align="center">
											<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
										</div>
										<div id="content-hr2"></div>
									</div>
									<div class="tab-pane" id="hr3">
										<div id="loader-hr3" style="display:block" align="center">
											<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/>
										</div>
										<div id="content-hr3"></div>
									</div>
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

			<!-- end row -->

		</section>
		<!-- end widget grid -->

		

	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<!-- MODAL PLACE HOLDER -->
<div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" >
			<div id="form-content">
			</div>
			<div id="form-loader" style='display:none;margin:20px;' align="center">
				<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/> mohon tunggu ...
			</div>			
		</div>
	</div>
</div>
<!-- END MODAL -->

<script type="text/javascript">		
	
	var base_url = $('#base_url').val();

    function load_content(){
		ajax_object.reset_object();
        ajax_object.set_n_req(3)
        		   .set_url([base_url+'config/load_quota1',base_url+'config/load_quota2',base_url+'config/load_quota3'])
        		   .set_loading(['#loader-hr1','#loader-hr2','#loader-hr3'])
        		   .set_content(['#content-hr1','#content-hr2','#content-hr3'])
        		   .request_ajax();
	}

	function load_form(id){
		ajax_object.reset_object();
        ajax_object.set_url(base_url+'config/load_quota_form').set_id_input(id).set_input_ajax('ajax-req-dt').set_data_ajax().set_loading('#form-loader').set_content('#form-content').request_ajax();
	}

	function delete_record(id,quota_seq){
		ajax_object.reset_object();
        ajax_object.set_plugin_datatable(true).set_url(base_url+'config/delete_quota_data').set_id_input(id).set_input_ajax('ajax-req-dt').set_data_ajax()
        		   .set_loading('#preloadAnimation').set_content('#list_quota'+quota_seq).update_ajax('menghapus data');
	}

	$(function(){
		load_content();
	});

</script>