<!-- MAIN PANEL -->
<div id="main" role="main" style="min-height:700px!important;">

	<!-- RIBBON -->
	<div id="ribbon">
		<span class="ribbon-button-alignment"> 
			<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
				<i class="fa fa-refresh"></i>
			</span> 
		</span>
		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>Home</li><li>Administrasi</li><li>Verifikasi</li>
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
						Verifikasi
					</span>
				</h1>
			</div>	
		</div>
		<!-- widget grid -->
		<section id="widget-grid" class="">

			<!-- row -->
			<div class="row">

				<?php
				if($this->session->userdata('latitude')!=0 && $this->session->userdata('longitude')!=0)
				{

				?>				
				<!-- NEW WIDGET START -->
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

					<div class="jarviswidget" id="wid-id-7" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-sortable="false">
						<!-- widget options:
						usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
		
						data-widget-colorbutton="false"
						data-widget-editbutton="false"
						data-widget-togglebutton="false"
						data-widget-deletebutton="false"
						data-widget-fullscreenbutton="false"
						data-widget-custombutton="false"
						data-widget-collapsed="true"
						data-widget-sortable="false"
		
						-->
						<header>
							<ul class="nav nav-tabs pull-left in">
		
								<li class="active">
									<a data-toggle="tab" href="#hr1"> <i class="fa fa-lg fa-check"></i> <span class="hidden-mobile hidden-tablet"> Form Verifikasi </span> </a>
								</li>
		
								<li>
									<a data-toggle="tab" onclick="load_list_of_data()" href="#hr2"> <i class="fa fa-lg fa-table"></i> <span class="hidden-mobile hidden-tablet"> Data Verifikasi </span></a>
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
		
								<div class="tab-content">
									<div class="tab-pane active" id="hr1">
										<form class="form-horizontal" id="<?=$form_id;?>" action="<?=base_url();?>backoffice/search_registration" method="POST">
											<fieldset>
												<?php
													$offset_nextCol = "col-md-offset-4";
													if($this->session->userdata('tipe_sekolah')=='2'){
														$offset_nextCol = "";

														echo "
														<div class='col-md-4 col-md-offset-2'>
															<select name='src_kompetensi' id='src_kompetensi' class='form-control' required>
																<option value=''></option>";														
																	foreach($kompetensi_rows as $row){
																		echo "<option value='".$row['kompetensi_id']."'>".$row['nama_kompetensi']."</option>";
																	}														
															echo "</select>
															<span class='help-block'>Jenis Kompetensi pilihan peserta</span>
														</div>";
													}else{
														echo "<input type='hidden' name='src_kompetensi' value=''/>";
													}
												?>
												
												<div class="col-md-4 <?=$offset_nextCol;?>">
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
									<div class="tab-pane" id="hr2">
										<input type="hidden" id="base_url" value="<?=base_url();?>"/>
										<div id="verification-list-loader" align="center">
											<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif" />
										</div>
										<div id="list_of_data">											
										</div>
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
				<?php 
				}else{
					echo "<div class='col-lg-12 col-md-12'>
						<div class='alert alert-warning'>
							<strong>Perhatian!</strong> <br />
							Koordinat Sekolah belum diatur. Sistem membutuhkan data tersebut untuk proses Verifikasi !<br />
							Silahkan masuk ke menu <b>Pengaturan &raquo; Koordinat Sekolah</b>. 
						</div>
					</div>";
				?>
				<?php
				}
				?>

			</div>

			<!-- end row -->			

		</section>
		<!-- end widget grid -->
		

	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->

<link rel="stylesheet" type="text/css" href="<?=$this->config->item('js_path');?>plugins/iCheck/all.css"/>

<script src="<?=$this->config->item('js_path');?>plugins/iCheck/icheck.min.js"></script>

<script src="<?=$this->config->item('js_path');?>plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key=<?=$api_key;?>&libraries=geometry" defer></script>

<script src="<?=$this->config->item("js_path");?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=$this->config->item("js_path");?>plugins/datatables/dataTables.colVis.min.js"></script>
<script src="<?=$this->config->item("js_path");?>plugins/datatables/dataTables.tableTools.min.js"></script>
<script src="<?=$this->config->item("js_path");?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?=$this->config->item("js_path");?>plugins/datatable-responsive/datatables.responsive.min.js"></script>

<script type="text/javascript">	
	
	$(document).ready(function() {
		pageSetUp();	
		
		oTable = $('#data-table-jq').dataTable({
            "oLanguage": {
            "sSearch": "Search :"
            },
            "aoColumnDefs": [
                {
                    'bSortable': false,
                    'aTargets': [0]
                } //disables sorting for column one
            ],
            'iDisplayLength': 10,
            "sPaginationType": "full_numbers"
        });
		/* END TABLETOOLS */
		
		$('#src_regnumb').mask('99.99.99.9999');
		load_list_of_data();

	})

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

    var base_url = $('#base_url').val();
    function load_list_of_data(){
    	ajax_object.reset_object();
        ajax_object.set_plugin_datatable(false).set_url(base_url+'backoffice/load_verification_list')
        		   .set_loading('#verification-list-loader')
        		   .set_content('#list_of_data').request_ajax();
    }

    function delete_record(id){
    	ajax_object.reset_object();
        ajax_object.set_url(base_url+'backoffice/delete_verification')
        		   .set_id_input(id).set_input_ajax('ajax-req-dt').set_data_ajax()
        		   .set_loading('#preloadAnimation	')
        		   .set_content('#list_of_data').update_ajax('menghapus data verifikasi');
    }

</script>