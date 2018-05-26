<?php

	$output = "";	

	for($i=1;$i<=$path_quota;$i++)
	{
		$output .= "<div class='form-group'>
					<label class='control-label col-md-4'>Sekolah-".$i." ".($i==1?"<font color='red'>*</font>":"")."</label>
					<div class='col-md-8'>
					<div class='input'>							
					<select name='input_sekolah_tujuan".$i."' id='input_sekolah_tujuan".$i."' class='form-control' ".($i==1?'required':'').">";

		if($district=='')
		{

			$output .= "<option value=''>- Pilih Kecamatan lebih dulu -</option>";
		}
		else{
			$output .= "<option value=''></option>";
			foreach($sekolah_rows as $row){
				$output .= "<option value='".$row['sekolah_id']."_".$row['nama_sekolah']."'>".$row['nama_sekolah']."</option>";
			}
		}
		
		$output .= "</select></div></div></div>";
	}

	$output .= "#%%#".(count($zona)==1?$zona[0]."_".$zona[1]:"");

	echo $output;

?>	