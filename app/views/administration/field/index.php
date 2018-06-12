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
			<li>Home</li><li>Administrasi</li><li>Kompetensi SMK</li>
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
						Administrasi
					<span>>  
						Kompetensi SMK
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
					<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-search"></i> </span>
							<h2>Pencarian Data Kompetensi SMK</h2>
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

								<form class="form-horizontal" id="<?=$form_id;?>" action="<?=base_url().$active_controller.'/search_field_data';?>" method="POST">
									<input type="hidden" id="base_url" value="<?=base_url();?>"/>
									<input type="hidden" id="_search_dt2"/>
									<fieldset>
										<div class="form-group" id="filter_dt2">
											<label class="control-label col-md-2" for="search_dt2">Kabupaten/Kota</label>
											<div class="col-md-4">
												<select class="form-control" name="search_dt2" id="search_dt2">
													<option value="" selected>- Semua Kabupaten -</option>
													<?php
														foreach($dt2_rows as $row){
															echo "<option value='".$row['dt2_id']."'>".$row['nama_dt2']."</option>";
														}
													?>
												</select>
												
											</div>
										</div>										
									</fieldset>
																
									
									<div class="form-actions">
										<div class="row">
											<div class="col-md-12">										
												<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Cari</button>
												<?php
												if($add_access)
													echo "<a id='add-button' onclick=\"load_form(this.id)\" class='btn btn-default' data-toggle='modal' data-target='#remoteModal'>";
												else
													echo "<a id='add-button' onclick=\"alert('anda tidak diijinkan untuk menambah data');\" class='btn btn-default'>";

												echo "<input type='hidden' name='act' value='add' id='ajax-req-dt'/>
													  <i class='fa fa-plus'></i> Tambah</a>";
												?>
											</div>
										</div>
									</div>

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

			<!-- end row -->

		</section>
		<!-- end widget grid -->


		<!-- widget grid -->
		<section id="widget-grid" class="">			
			<!-- row -->
			<div class="row" id="data-view"></div>
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
	
	var search_field_form_id = '<?=$form_id;?>';
    var $search_field_form=$('#'+search_field_form_id);
    var search_field_stat=$search_field_form.validate({
    		// Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
    	});

    $search_field_form.submit(function(){
        if(search_field_stat.checkForm())
        {
        	$('#_search_dt2').val($('#search_dt2').val());
        	ajax_object.reset_object();
            ajax_object.set_content('#data-view')
            		   .set_plugin_datatable(true)
                           .set_loading('#preloadAnimation')
                           .disable_pnotify()
                           .set_form($search_field_form)
                           .submit_ajax();
            return false;
        }

    });

    function load_form(id){
		ajax_object.reset_object();
		var data_ajax = ['search_dt2='+$('#_search_dt2').val()];
        ajax_object.set_url(base_url+'administration/load_field_form').set_id_input(id).set_input_ajax('ajax-req-dt').set_data_ajax(data_ajax).set_loading('#form-loader').set_content('#form-content').request_ajax();
	}

	function delete_record(id){
		ajax_object.reset_object();
        ajax_object.set_plugin_datatable(true).set_url(base_url+'administration/delete_field_data').set_id_input(id).set_input_ajax('ajax-req-dt').set_data_ajax()
        		   .set_loading('#preloadAnimation').set_content('#list_of_data').update_ajax('menghapus data');
	}

</script>