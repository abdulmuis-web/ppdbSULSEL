<div class="container-fluid box">

	<div class="alert alert-warning">
		<strong>Aturan/Ketentuan</strong><br />
	  Berikut ini Aturan/Ketentuan PPDB Online yang berlaku untuk Jalur <?=$nama_jalur;?> :
	</div>

	<ol type="1">
		<?php
			foreach($ketentuan_jalur_rows as $row){
				echo "<li>".$row['ketentuan']."</li>";
			}
		?>
	</ol>

</div>