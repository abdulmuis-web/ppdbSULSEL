<?php
	
	echo "<select name='input_sekolah_id' id='input_sekolah_id' class='form-control' required>";
	if(count($rows)==0){
		echo "<option value=''>-- Pilih Kab./Kota lebih dulu --</option>";
	}else{
		echo "<option value=''></option>";
	}
	foreach($rows as $row){
		echo "<option value='".$row['sekolah_id']."'>".$row['nama_sekolah']."</option>";
	}
	echo "</select>";
?>