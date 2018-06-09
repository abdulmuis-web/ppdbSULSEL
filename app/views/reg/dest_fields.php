<?php
	
	echo "
	<select name='input_kompetensi_tujuan".$i."' id='input_kompetensi_tujuan".$i."' class='form-control' ".($i==1?'required':'').">
		<option value=''></option>";
		foreach($kompetensi_smk_rows as $row){
			echo "<option value='".$row['kompetensi_id']."_".$row['nama_kompetensi']."'>".$row['nama_kompetensi']."</option>";
		}
	echo "</select>";
?>