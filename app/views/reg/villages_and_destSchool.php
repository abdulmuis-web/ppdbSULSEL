<?php

	$output = "";
	if($district=='')
	{		
		$output .= "<option value=''>- Pilih Kecamatan lebih dulu -</option>";		
	}else{
		$output .= "<option value=''></option>";
		foreach($kelurahan_rows as $row){
			$output .= "<option value='".$row['kelurahan_id']."'>".$row['nama_kelurahan']."</option>";
		}
	}
	$output .= "#%%#";

	for($i=1;$i<=$path_quota;$i++)
	{
		$output .= "<div class='form-group'>
					<label class='control-label col-md-4'>Sekolah-".$i." ".($i==1?"<font color='red'>*</font>":"")."</label>
					<div class='col-md-8'>
					<div class='input'>							
					<select name='input_sekolah_tujuan".$i."' id='input_sekolah_tujuan".$i."' class='form-control' required>";

		if($district=='')
		{

			$output .= "<option value=''>- Pilih Kecamatan lebih dulu -</option>";
		}
		else{
			$output .= "<option value=''></option>";
			foreach($sekolah_rows as $row){
				$output .= "<option value='".$row['sekolah_id']."'>".$row['nama_sekolah']."</option>";
			}
		}
		
		$output .= "</select></div></div></div>";
	}

	echo $output;

?>	