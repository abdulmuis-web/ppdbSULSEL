<?php
	echo "
	<table id='data-table-jq' class='table table-striped table-bordered table-hover' width='100%'>
		<thead>
			<tr>
				<th width='4%'>No.</th>
				<th>Kab./Kota</th>
				<th>Kab./Kota Perbatasan</th>
				<th width='8%'>Aksi</th>
			</tr>
		</thead>
		<tbody>";
			$no=0;			
			foreach($rows as $row)
			{
				foreach($row as $key => $val){
	                  $key=strtolower($key);
	                  $$key=$val;
	              }
				$no++;
				echo "
				<tr><td align='center'>".$no."</td>
				<td>".$nama_dt2."</td>
				<td>".$nama_dt2_perbatasan."</td>
				<td align='center'>";

					if($update_access)
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' id='edit_".$no."' onclick=\"load_form(this.id)\" data-toggle='modal' data-target='#remoteModal'>";
	                else
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' id='edit_".$no."' onclick=\"alert('anda tidak diijinkan untuk merubah data!');\">";
	                
	                echo "
	                <input type='hidden' id='ajax-req-dt' name='dt2_id' value='".$row['dt2_id']."'/>
	                <input type='hidden' id='ajax-req-dt' name='dt2_sekolah_id' value='".$row['dt2_sekolah_id']."'/>
	                <input type='hidden' id='ajax-req-dt' name='search_dt2' value='".$search_dt2."'/>
	                <input type='hidden' id='ajax-req-dt' name='act' value='edit'/>
	            	<i class='fa fa-edit'></i></a>&nbsp";

	            	if($delete_access)
	            		echo "<a href='#' title='Hapus' class='btn btn-xs btn-default' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id)}\" id='delete_".$no."'>";
	            	else
	            		echo "<a href='#' title='Hapus' class='btn btn-xs btn-default' onclick=\"alert('anda tidak diijinkan untuk menghapus data!')\">";

	            	echo "
	            	<input type='hidden' id='ajax-req-dt' name='dt2_id' value='".$row['dt2_id']."'/>
	                <input type='hidden' id='ajax-req-dt' name='dt2_sekolah_id' value='".$row['dt2_sekolah_id']."'/>
	            	<input type='hidden' id='ajax-req-dt' name='search_dt2' value='".$search_dt2."'/>
	            	<i class='fa fa-trash-o'></i></a>&nbsp
	            </td>
				</tr>";
			}
			
		echo "</tbody>
	</table>";
?>