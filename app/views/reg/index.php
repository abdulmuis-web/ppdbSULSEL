<link rel="stylesheet" href="<?=$this->config->item('css_path');?>sidebar-style.css"/>
<div class="sidebar-content">
	<div class="wrapper">
	    <!-- Sidebar Holder -->
	    <nav id="sidebar">
	        <div class="sidebar-header">
	            <select class="form-control" onchange="location.href='<?php echo base_url()."reg/stage/";?>'+$(this).val();">
	            	<?php
	            		foreach($tipe_sekolah_rows as $row){
	            			$selected = ($stage==$row['ref_tipe_sklh_id']?'selected':'');
	            			echo "<option value='".$row['ref_tipe_sklh_id']."' ".$selected.">".$row['akronim']."</option>";
	            		}
	            	?>
	            </select>
	        </div>
	        <ul class="list-unstyled components">	            
	            <?php
	            	$active = ($path==''?"class='active'":"");
	            	echo "
	            	<li ".$active.">
		                <a href='".base_url()."reg/stage/".$stage."'>
		                    <i class='glyphicon glyphicon-home'></i>
		                    Info Umum
		                </a>
		            </li>";

	            	foreach($jalur_pendaftaran_rows as $row){
	            		$active = ($path==$row['ref_jalur_id']?"class='active'":"");
	            		echo "
	            			<li ".$active.">
				                <a href='".base_url()."reg/stage/".$stage."/".$row['ref_jalur_id']."'>
				                    <i class='glyphicon glyphicon-check'></i>".$row['nama_jalur']."
				                </a>
			            	</li>";
	            	}
	            ?>
	            
	            
	        </ul>

	    </nav>

	    <!-- Page Content Holder -->
	    <div id="content" style="width:100%">

	    	<?php
	    	if($path!='')
	    	{
	    	echo "
	        <nav>
	            <div class='container-fluid'>
	                <div class='navbar-header'>
	                	<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>
		    				<span class='icon-bar'></span>
		    				<span class='icon-bar'></span>
		     				<span class='icon-bar'></span>
		    			</button>
	                </div>
	                <div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
	                    <ul class='nav navbar-nav navbar-left' id='tab-menu'>
	                        <li>
	                        	<a href='javascript:;' onclick=\"tabMenu_navigation(this);\" id='tab-menu1'>
	                        		<input type='hidden' id='ajax-req-dt' name='tab_id' value='0'/>
	                        		<input type='hidden' id='ajax-req-dt' name='stage' value='".$stage."'/>
	                        		<input type='hidden' id='ajax-req-dt' name='path' value='".$path."'/>
	                        		<i class='fa fa-info-circle'></i> 
	                        		Panduan</a>
	                        </li>
	                        <li>
	                        	<a href='javascript:;' onclick=\"tabMenu_navigation(this);\" id='tab-menu2'>
	                        	<input type='hidden' id='ajax-req-dt' name='tab_id' value='1'/>
                        		<input type='hidden' id='ajax-req-dt' name='stage' value='".$stage."'/>
                        		<input type='hidden' id='ajax-req-dt' name='path' value='".$path."'/>
	                        	<i class='fa fa-book'></i> Aturan</a>
	                        </li>
	                        <li>
	                        	<a href='javascript:;' onclick=\"tabMenu_navigation(this);\" id='tab-menu3'>
	                        	<input type='hidden' id='ajax-req-dt' name='tab_id' value='2'/>
                        		<input type='hidden' id='ajax-req-dt' name='stage' value='".$stage."'/>
                        		<input type='hidden' id='ajax-req-dt' name='path' value='".$path."'/>
	                        	<i class='fa fa-calendar'></i> Jadwal</a>
	                        </li>
	                        <li>
	                        	<a href='javascript:;' onclick=\"tabMenu_navigation(this);\" id='tab-menu4'>
	                        	<input type='hidden' id='ajax-req-dt' name='tab_id' value='3'/>
                        		<input type='hidden' id='ajax-req-dt' name='stage' value='".$stage."'/>
                        		<input type='hidden' id='ajax-req-dt' name='path' value='".$path."'/>
	                        	<i class='fa fa-check-circle'></i> Prosedur</a>
	                        </li>
	                        <li>
	                        	<a href='javascript:;' onclick=\"tabMenu_navigation(this);\" id='tab-menu5'>
	                        	<input type='hidden' id='ajax-req-dt' name='tab_id' value='4'/>
                        		<input type='hidden' id='ajax-req-dt' name='stage' value='".$stage."'/>
                        		<input type='hidden' id='ajax-req-dt' name='path' value='".$path."'/>
	                        	<i class='fa fa-pencil-square-o'></i> Daftar</a>
	                        </li>
	                        <li>
	                        	<a href='javascript:;' onclick=\"tabMenu_navigation(this);\" id='tab-menu6'>
	                        	<input type='hidden' id='ajax-req-dt' name='tab_id' value='5'/>
                        		<input type='hidden' id='ajax-req-dt' name='stage' value='".$stage."'/>
                        		<input type='hidden' id='ajax-req-dt' name='path' value='".$path."'/>
	                        	<i class='fa fa-file-text-o'></i> Hasil</a>
	                        </li>
	                        <li>
	                        	<a href='javascript:;' onclick=\"tabMenu_navigation(this);\" id='tab-menu7'>
	                        	<input type='hidden' id='ajax-req-dt' name='tab_id' value='6'/>
                        		<input type='hidden' id='ajax-req-dt' name='stage' value='".$stage."'/>
                        		<input type='hidden' id='ajax-req-dt' name='path' value='".$path."'/>
	                        	<i class='fa fa-bar-chart-o'></i> Statistik</a>
	                        </li>
	                        <li>
	                        	<a href='javascript:;' onclick=\"tabMenu_navigation(this);\" id='tab-menu8'>
	                        	<input type='hidden' id='ajax-req-dt' name='tab_id' value='7'/>
                        		<input type='hidden' id='ajax-req-dt' name='stage' value='".$stage."'/>
                        		<input type='hidden' id='ajax-req-dt' name='path' value='".$path."'/>
	                        	<i class='fa fa-users'></i> Kuota</a>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	        </nav>";
	        } ?>

	        <div id="data-view-loader" align="center" style="display:none">
	        	<img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-7.gif"/><br />
	        </div>
	        <div id="data-view">	        	
	        	<?php $this->load->view($active_controller.'/guidance');?>
		    </div>
			
	    </div>
	</div>
</div>

<script src="<?=$this->config->item('js_path');?>my_scripts/ajax_object.js"></script>

<script type="text/javascript">
     $(document).ready(function () {
         $('#sidebarCollapse').on('click', function () {
             $('#sidebar').toggleClass('active');
         });
     });

     function tabMenu_navigation(obj){
     	ajax_object.reset_object();
        ajax_object.set_url($('#baseUrl').val()+'reg/content_tab_menu')
        	.set_id_input(obj.id)
        	.set_input_ajax('ajax-req-dt')
        	.set_data_ajax()
        	.set_loading('#data-view-loader')
        	.set_content('#data-view')
        	.request_ajax();

        $('#tab-menu > li a').removeClass('active');

        $(obj).addClass('active');
       
     }

 </script>