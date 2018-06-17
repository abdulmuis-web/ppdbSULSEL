<?php
	echo "<select name='input_kompetensi_id' id='input_kompetensi_id' class='form-control' required>";
	if(count($rows)==0){
		echo "<option value=''>-- Pilih Sekolah lebih dulu --</option>";
	}else{
		echo "<option value=''></option>";
	}
	foreach($rows as $row){
		echo "<option value='".$row['kompetensi_id']."'>".$row['nama_kompetensi']."</option>";
	}
	echo "</select>";
?>