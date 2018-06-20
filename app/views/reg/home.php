<div class="row">
	<div class="col-md-8">
		<div class="container-fluid box">
			<img src="<?=$this->config->item('img_path');?>flow1.png" width="100%"/>
			<hr></hr>
			<img src="<?=$this->config->item('img_path');?>flow2.png" width="100%"/>
		</div>
	</div>
	<div class="col-md-4">
		<div class="container-fluid box">
			<?php
				$x = explode(' ',$pengumuman_row['waktu_posting']);
				echo "<h4 style='margin:0!important'>".$pengumuman_row['judul']."</h4>
				<small><i class='fa fa-user'></i> Diposting oleh : ".$pengumuman_row['diposting_oleh'].", <i class='fa fa-calendar'></i> ".indo_date_format($x[0],'shortDate')." ".$x[1]."</small>
				<hr></hr>				
				".$pengumuman_row['deskripsi'];
			?>
		</div>
	</div>
</div>
