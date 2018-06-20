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
			<li>Home</li><li>Pengaturan</li><li>Pengumuman</li>
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
						Pengumuman
					</span>
				</h1>
			</div>
			
		</div>
		
		<!-- widget grid -->
		<section id="widget-grid" class="">
			<input type="hidden" id="base_url" value="<?=base_url();?>"/>
			<!-- row -->
			<div class="row">
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					
					<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false">
						<header>
							<span class="widget-icon"> <i class="fa fa-table"></i> </span>
							<h2>Daftar Pengumuman | </h2>
							<h2>
								<?php
								if($add_access)
									echo "<a class='btn btn-default btn-xs' onclick=\"load_form(this.id)\" id='add-button' data-toggle='modal' data-target='#remoteModal'>";
								else
									echo "<a class='btn btn-default btn-xs' onclick=\"alert('anda tidak diijinkan untuk menambah data!');\" id='add-button'/>";
								echo "<input type='hidden' name='act' value='add' id='ajax-req-dt'/>
								 <i class='fa fa-plus'></i> Tambah 
								</a>";
								?>
							</h2>
						</header>

						<!-- widget div-->
						<div>

							<!-- widget edit box -->
							<div class="jarviswidget-editbox">
								<!-- This area used as dropdown edit box -->
							</div>
							<!-- end widget edit box -->

							<!-- widget content -->
							<div class="widget-body no-padding" id="list_of_data">								
								<?php
									echo $list_of_data;
								?>
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

<!-- MODAL PLACE HOLDER -->
<div class="modal fade" id="remoteModal" tabindex="-1" role="dialog" aria-labelledby="remoteModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
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
	function load_form(id){
		ajax_object.reset_object();
        ajax_object.set_url(base_url+'config/load_announcement_form').set_id_input(id).set_input_ajax('ajax-req-dt').set_data_ajax().set_loading('#form-loader').set_content('#form-content').request_ajax();
	}

	function delete_record(id){
		ajax_object.reset_object();
        ajax_object.set_plugin_datatable(true).set_url(base_url+'config/delete_announcement_data').set_id_input(id).set_input_ajax('ajax-req-dt').set_data_ajax().set_loading('#preloadAnimation').set_content('#list_of_data').update_ajax('menghapus data');
	}

</script>