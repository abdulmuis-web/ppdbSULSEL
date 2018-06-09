<?php
	
	echo "
	<select name='input_sekolah_tujuan".$i."' id='input_sekolah_tujuan".$i."' onchange=\"get_destFields($(this).val(),'".$i."')\" class='form-control' ".($i==1?'required':'').">
		<option value=''>".(count($sekolah_rows)==0?"- Pilih Kab.Kota lebih dulu -":"")."</option>";
		foreach($sekolah_rows as $row){
			echo "<option value='".$row['sekolah_id']."_".$row['nama_sekolah']."'>".$row['nama_sekolah']."</option>";
		}
	echo "</select>";
?>