<?php
	$output = "<select name='input_kecamatan' class='form-control' required>";

	if(count($kecamatan_rows)>0)
	{
		$output .= "<option value=''></option>";
		foreach($kecamatan_rows as $row){
			$output .= "<option value='".$row['kecamatan_id']."_".$row['nama_kecamatan']."'>".$row['nama_kecamatan']."</option>";
		}
	}else{
		$output .= "<option value=''>- Pilih Kab./Kota lebih dulu -</option>";
	}
	$output .= "</select><span class='help-block'>Pilih Kecamatan sesuai Kartu Keluarga</span>";


	$output .= "#%%#";


	$output .= "<table class='table table-bordered'>
				<thead><tr><td width='4%' align='center'><b>#</b></td>";

	if($lintas_dt2!='0')
		$output .= "<td width='50%' align='center'><b>Kota/Kab.</b></td>";

	if($tipe_sekolah=='1')
		$output .= "<td align='center'><b>SMA Tujuan</b></td>";
	else
		$output .= "<td align='center'><b>SMK Tujuan</b></td><td align='center'>Jenis Kompetensi</td>";

	$output .= "</tr></thead><tbody>";


	for($i=1;$i<=$jml_sekolah;$i++)
	{

		$output .= "<tr><td align='center'>".$i."</td>";
	
		if($lintas_dt2!='0'){
			$output .= "<td><div id='cont_input_dt2_sekolah_tujuan".$i."'><select name='input_dt2_sekolah_tujuan".$i."' id='input_dt2_sekolah_tujuan".$i."' 
			onchange=\"get_destSchools($(this).val(),'".$dt2_id."','".$tipe_sekolah."','".$lintas_dt2."','".$i."');\" class='form-control' required>";

			$output .= "<option value=''></option>";
			foreach($pengaturan_dt2_sekolah_rows as $row){
				$selected = ($row['dt2_sekolah_id']==$dt2_id?'selected':'');
				$keterangan = ($lintas_dt2=='1'?" (".ucwords($row['status']).")":"");

				$output .= "<option value='".$row['dt2_sekolah_id']."' ".$selected.">".$row['nama_dt2'].$keterangan."</option>";
			}
			$output .= "</select></div></td>";
		}
		
		$output .= "<td><div id='dest-school-loader".$i."' style='display:none'><img src='".$this->config->item('img_path')."ajax-loaders/ajax-loader-1.gif'/></div>
					<div id='cont_input_sekolah_tujuan".$i."'>
					<select name='input_sekolah_tujuan".$i."' id='input_sekolah_tujuan".$i."' class='form-control' ".($i==1?'required':'').">";

		$output .= "<option value=''></option>";

		foreach($sekolah_rows as $row){
			$output .= "<option value='".$row['sekolah_id']."_".$row['nama_sekolah']."'>".$row['nama_sekolah']."</option>";
		}			
		
		$output .= "</select></div>";

		if($tipe_sekolah=='1')
		{
			$output .= "<input type='hidden' name='input_komptensi_tujuan' value='0_0'/></td>";
		}else{

			$output .= "<td><div id='dest-field-loader".$i."' style='display:none'><img src='".$this->config->item('img_path')."ajax-loaders/ajax-loader-1.gif'/></div>
						<div id='cont_input_kompetensi_tujuan".$i."'>
						<select name='input_kompetensi_tujuan".$i."' id='input_kompetensi_tujuan".$i."' class='form-control' ".($i==1?'required':'')."><option value=''>- Pilih SMK lebih dulu -</option></select></div></td>";
		}

		echo "</tr>";

	}
	

	echo $output;
?>