<?php	
	echo "
	<table class='table table-bordered'>
		<thead>
			<tr><th>Tingkat Kejuaraan</th><th>Bobot Juara 1</th><th>Bobot Juara 2</th><th>Bobot Juara 3</th><th>Aksi</th></tr>
		</thead>
		<tbody>";
			$no = 0;
			foreach($rows as $row){
				$no++;
				
				echo "<tr>
				<td>".$row['tingkat_kejuaraan']."</td>
				<td align='right'>".$row['bobot_juara1']."</td>
				<td align='right'>".$row['bobot_juara2']."</td>
				<td align='right'>".$row['bobot_juara3']."</td>
				<td width='8%' align='center'>";
					
					if($update_access)
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' id='edit1_".$no."' onclick=\"load_form(this.id)\" data-toggle='modal' data-target='#remoteModal'>";
	                else
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' onclick=\"alert('anda tidak diijinkan untuk merubah data!');\">";
	                
	                echo "
	                <input type='hidden' id='ajax-req-dt' name='id' value='".$row['pengaturan_bobot_id']."'/>
	                <input type='hidden' id='ajax-req-dt' name='type' value='2'/>
	                <input type='hidden' id='ajax-req-dt' name='act' value='edit'/>	                
	            	<i class='fa fa-edit'></i></a>&nbsp";
				echo "</td></tr>";
			}
		echo "</tbody>
	</table>";
	
?>