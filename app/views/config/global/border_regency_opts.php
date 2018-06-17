<?php	
	$onchange = (isset($onchange)?$onchange:'');
	echo "<select name='input_dt2_perbatasan_id' id='input_dt2_perbatasan_id' ".$onchange." class='form-control' required>";
	if(count($rows)==0){
		echo "<option value=''>-- Pilih Kab./Kota lebih dulu --</option>";
	}else{
		echo "<option value=''></option>";
	}
	foreach($rows as $row){
		echo "<option value='".$row['dt2_sekolah_id']."'>".$row['nama_dt2']."</option>";
	}
	echo "</select>";
?>