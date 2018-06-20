<!-- MAIN PANEL -->
<div id="main" role="main">

	<!-- RIBBON -->
	<div id="ribbon">		
		<!-- breadcrumb -->
		<ol class="breadcrumb">
			<li>Monitoring</li><li>Verifikasi</li>
		</ol>
	</div>
	<!-- END RIBBON -->

	<!-- MAIN CONTENT -->
	<div id="content">
		
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h1 class="page-title txt-color-blueDark">
					<!-- PAGE HEADER -->
					<i class="fa-fw fa fa-desktop"></i> 
						Monitoring
					<span>>  
						Verifikasi <?=$nama_sekolah;?>
					</span>
					<button type="button" onclick="load_content();" class="btn btn-default pull-right">Refresh</button>
				</h1>
			</div>
			
		</div>
		
		<!-- widget grid -->
		<section id="widget-grid" class="">
			<!-- row -->
			<div class="row">
				<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<input type="hidden" id="base_url" value="<?=base_url();?>"/>
					<input type="hidden" id="n_path" value="<?=count($jalur_rows);?>"/>
					<div class="row">
						<?php
						$i=0;
						foreach($jalur_rows as $row)
						{
							$i++;
							echo "
							<div class='col-md-3'>
								<div class='jarviswidget' id='wid-id-6' data-widget-colorbutton='false' data-widget-editbutton='false' data-widget-fullscreenbutton='false' data-widget-custombutton='false' data-widget-sortable='false'>
									<input type='hidden' id='jalur_id".$i."' value='".$row['jalur_id']."'/>
									<header>
										<h2>Jalur ".$row['nama_jalur']."										
										</h2>
									</header>
					
									<!-- widget div-->
									<div>
					
										<!-- widget edit box -->
										<div class='jarviswidget-editbox'>
											<!-- This area used as dropdown edit box -->
					
										</div>
										<!-- end widget edit box -->
					
										<!-- widget content -->
										<div class='widget-body' align='center'>
											<div id='loader-counter".$i."' align='center' style='display:none'>
												<img src='".$this->config->item('img_path')."ajax-loaders/ajax-loader-1.gif'/>
											</div>
											<div id='content-counter".$i."'>
												<div class='row'>
												<div class='col-md-6'>
													<h1 style='font-size:2.5em' id='counter".$i."'>0</h1>
													Orang
												</div>
												<div class='col-md-6'>
													<table class='table table-bordered'>
													<tbody>
														<tr><td><b>".($type=='1'?'L':'SMA')."</b></td><td> : 0</td></tr>
														<tr><td><b>".($type=='1'?'P':'SMK')."</b></td><td> : 0</td></tr>
													</tbody>
													</table>
												</div>
												</div>
											</div>
										</div>
										<!-- end widget content -->
					
									</div>
									<!-- end widget div -->
					
								</div>
								<!-- end widget -->
							</div>";
						}
						?>
					</div>
				</div>

				<!-- end row -->

				<!-- end row -->

			</section>
			<!-- end widget grid -->
		</article>

	</div>
	<!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->


<script type="text/javascript">	

	var base_url = $('#base_url').val();
		
	function load_content(){
		ajax_object.reset_object();
		n = $('#n_path').val();
		var url = [], loaders = [], contents = [], data_ajax = [];

		for(i=1;i<=n;i++)
		{
			url.push(base_url+'monitoring/load_counter');
			loaders.push('#loader-counter'+i);
			contents.push('#content-counter'+i);
			_data_ajax = ['jalur_id='+$('#jalur_id'+i).val(),'status=3','i='+i];
			data_ajax.push(_data_ajax);
		}

        ajax_object.set_n_req(n)
        		   .set_data_ajax2(data_ajax)
        		   .set_url(url)
        		   .set_loading(loaders)
        		   .set_content(contents)
        		   .request_ajax();
        
	}


	function execute_counting(path)
    {    	
    	var $counter = $('#counter'+path);
    	var $content = $('#content-counter'+path);
    	var $jalur_id = $('#jalur_id'+path);
        _si=setInterval(function(){
            $.ajax({
                type:'POST',
                url:base_url+'monitoring/counter_listener',
                data:'curr_counter='+$counter.html()+'&jalur_id='+$jalur_id.val()+'&status=3',
                beforeSend:function(){
                },
                complete:function(){
                },
                success:function(data){
                    if(data!='')
                    {
                        $counter.html(data);
                    }
                }
            });
        },1000);
    }
	$(function(){
		load_content();
	});	
</script>