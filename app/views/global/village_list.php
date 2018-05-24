<?php

	if($district=='')
	{
		if($type=='1'){
			echo "<option value=''>- Pilih Kecamatan lebih dulu -</option>";
		}
	}else{
		echo "<option value=''></option>";
		foreach($village_rows as $row){
			echo "<option value='".$row['kelurahan_id']."'>".$row['nama_kelurahan']."</option>";
		}
	}
?>	