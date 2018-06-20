<!-- PAGE FOOTER -->
		<div class="page-footer" <?=($no_menu?"style='padding-left:15px!important'":"");?>>
			<div class="row">				

				<div class="col-xs-12 col-sm-6">
					<span class="txt-color-white">PPDB Online <span class="hidden-xs"> - Dinas Pendidikan Provinsi <?=$this->_SYS_PARAMS[2];?></span> © 2018</span>
				</div>

				<div class="col-xs-6 col-sm-6 text-right hidden-xs">
					<div class="txt-color-white inline-block">
						<i class="txt-color-blueLight hidden-mobile">Last account activity <i class="fa fa-clock-o"></i> <strong>0 mins ago &nbsp;</strong> </i>
					</div>
				</div>
			</div>
		</div>
		<!-- END PAGE FOOTER -->

		<!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
		Note: These tiles are completely responsive,
		you can add as many as you like
		-->
		<div id="shortcut">

			<ul>
				<li>
					<a href="<?=base_url()?>config/account" class="jarvismetro-tile big-cubes selected bg-color-pinkDark" style="width:300px!important"> 
						<span class="iconbox">
							<?php
							echo "
							<table class='table'>
							<tr><td align='left'>Username</td><td align='left'>: ".$this->session->userdata('username')."</td></tr>
							<tr><td align='left'>Role</td><td align='left'>: ".$this->session->userdata('admin_type')."</td></tr>";
							if($this->session->userdata('admin_type_id')=='3' or $this->session->userdata('admin_type_id')=='4'){
								echo "<tr><td align='left'>Sekolah</td><td align='left'>: ".$this->session->userdata('nama_sekolah')."</td></tr>";
							}
							echo "</table>
							";
							?>
						</span> 
					</a>
				</li>
			</ul>
		</div>
		<!-- END SHORTCUT AREA -->

		<!--================================================== -->

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="<?=$this->config->item('js_path');?>plugins/pace/pace.min.js"></script>


		<!-- IMPORTANT: APP CONFIG -->
		<script src="<?=$this->config->item("js_path");?>app.config.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
		<script src="<?=$this->config->item("js_path");?>plugins/jquery-touch/jquery.ui.touch-punch.min.js"></script> 

		<!-- BOOTSTRAP JS -->
		<script src="<?=$this->config->item("js_path");?>bootstrap.min.js"></script>

		<!-- CUSTOM NOTIFICATION -->
		<script src="<?=$this->config->item("js_path");?>notification/SmartNotification.min.js"></script>		

		<!-- JQUERY SELECT2 INPUT -->
		<script src="<?=$this->config->item("js_path");?>plugins/select2/select2.min.js"></script>

		<!-- JQUERY UI + Bootstrap Slider -->
		<script src="<?=$this->config->item("js_path");?>plugins/bootstrap-slider/bootstrap-slider.min.js"></script>

		<!-- browser msie issue fix -->
		<script src="<?=$this->config->item("js_path");?>plugins/msie-fix/jquery.mb.browser.min.js"></script>

		<!-- FastClick: For mobile devices -->
		<script src="<?=$this->config->item("js_path");?>plugins/fastclick/fastclick.min.js"></script>

		<!--[if IE 8]>

		<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

		<![endif]-->

		<!-- MAIN APP JS FILE -->
		<script src="<?=$this->config->item("js_path");?>app.min.js"></script>


		<?php
		if(isset($containsTable)){
		?>
		<script src="<?=$this->config->item("js_path");?>plugins/datatables/jquery.dataTables.min.js"></script>
		<script src="<?=$this->config->item("js_path");?>plugins/datatables/dataTables.colVis.min.js"></script>
		<script src="<?=$this->config->item("js_path");?>plugins/datatables/dataTables.tableTools.min.js"></script>
		<script src="<?=$this->config->item("js_path");?>plugins/datatables/dataTables.bootstrap.min.js"></script>
		<script src="<?=$this->config->item("js_path");?>plugins/datatable-responsive/datatables.responsive.min.js"></script>
		<?php } ?>

		<script>
			$(document).ready(function() {

				// DO NOT REMOVE : GLOBAL FUNCTIONS!
				pageSetUp();

				/*
				 * PAGE RELATED SCRIPTS
				 */

				$(".js-status-update a").click(function() {
					var selText = $(this).text();
					var $this = $(this);
					$this.parents('.btn-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
					$this.parents('.dropdown-menu').find('li').removeClass('active');
					$this.parent().addClass('active');
				});

				/*
				* TODO: add a way to add more todo's to list
				*/

				// initialize sortable
				$(function() {
					$("#sortable1, #sortable2").sortable({
						handle : '.handle',
						connectWith : ".todo",
						update : countTasks
					}).disableSelection();
				});

				// check and uncheck
				$('.todo .checkbox > input[type="checkbox"]').click(function() {
					var $this = $(this).parent().parent().parent();

					if ($(this).prop('checked')) {
						$this.addClass("complete");

						// remove this if you want to undo a check list once checked
						//$(this).attr("disabled", true);
						$(this).parent().hide();

						// once clicked - add class, copy to memory then remove and add to sortable3
						$this.slideUp(500, function() {
							$this.clone().prependTo("#sortable3").effect("highlight", {}, 800);
							$this.remove();
							countTasks();
						});
					} else {
						// insert undo code here...
					}

				})
				// count tasks
				function countTasks() {

					$('.todo-group-title').each(function() {
						var $this = $(this);
						$this.find(".num-of-tasks").text($this.next().find("li").size());
					});

				}

				<?php
				if(isset($containsTable)){
				?>
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
				<?php } ?>
			});

		</script>

		<!-- Your GOOGLE ANALYTICS CODE Below -->
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-XXXXXXXX-X']);
			_gaq.push(['_trackPageview']);

			(function() {
				var ga = document.createElement('script');
				ga.type = 'text/javascript';
				ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0];
				s.parentNode.insertBefore(ga, s);
			})();

		</script>

	
	</body>

</html>