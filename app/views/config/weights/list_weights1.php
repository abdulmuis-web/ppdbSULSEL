<?php	
	echo "
	<div class='row' style='margin-bottom:5px;' align='center'>
		<div class='col-lg-12 col-md-12'>";

			if($add_access)
				echo "<a id='add-button1' onclick=\"load_form(this.id)\" class='btn btn-default btn-xs' data-toggle='modal' data-target='#remoteModal'>";
			else
				echo "<a onclick=\"alert('anda tidak diijinkan untuk menambah data');\" class='btn btn-default btn-xs'>";

			echo "<input type='hidden' name='act' value='add' id='ajax-req-dt'/>
				  <input type='hidden' id='ajax-req-dt' name='type' value='1'/>
				  <i class='fa fa-plus'></i> Tambah</a>&nbsp;";

		echo "</div>
	</div>
	<table class='table table-bordered'>
		<thead>
			<tr><th>Radius/Jarak</th><th>Bobot</th><th>Aksi</th></tr>
		</thead>
		<tbody>";
			$no = 0;
			foreach($rows as $row){
				$no++;
				if($row['jarak_min']==0 and $row['jarak_max']>0)				
					$jarak = '<= '.$row['jarak_max'];
				else if($row['jarak_min']>0 and $row['jarak_max']==0)
					$jarak = '>= '.$row['jarak_min'];
				else
					$jarak = $row['jarak_min'].' - '.$row['jarak_max'];
				echo "<tr>
				<td align='center'>".$jarak."</td>
				<td align='right'>".$row['bobot']."</td>				
				<td width='8%' align='center'>";
					
					if($update_access)
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' id='edit1_".$no."' onclick=\"load_form(this.id)\" data-toggle='modal' data-target='#remoteModal'>";
	                else
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' onclick=\"alert('anda tidak diijinkan untuk merubah data!');\">";
	                
	                echo "
	                <input type='hidden' id='ajax-req-dt' name='id' value='".$row['pengaturan_bobot_id']."'/>
	                <input type='hidden' id='ajax-req-dt' name='type' value='1'/>
	                <input type='hidden' id='ajax-req-dt' name='act' value='edit'/>	                
	            	<i class='fa fa-edit'></i></a>&nbsp";

	            	if($delete_access)
	            		echo "<a href='#' title='Hapus' class='btn btn-xs btn-default' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id,'1')}\" id='delete1_".$no."'>";
	            	else
	            		echo "<a href='#' title='Hapus' class='btn btn-xs btn-default' onclick=\"alert('anda tidak diijinkan untuk menghapus data!')\">";

	            	echo "
	            	<input type='hidden' id='ajax-req-dt' name='id' value='".$row['pengaturan_bobot_id']."'/>
	            	<input type='hidden' id='ajax-req-dt' name='type' value='1'/>
	            	<input type='hidden' id='ajax-req-dt' name='act' value='delete'/>
	            	<i class='fa fa-trash-o'></i></a>
				</td></tr>";
			}
		echo "</tbody>
	</table>";
	
?>