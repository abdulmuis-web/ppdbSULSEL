<?php
	echo "
	<table id='data-table-jq' class='table table-striped table-bordered table-hover' width='100%'>
		<thead>
			<tr>
				<th width='4%'>No.</th>
				<th>Nama Kompetensi</th>
				<th>SMK</th>				
				<th>ID</th>
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
				<td>".$nama_kompetensi."</td>
				<td>".$nama_sekolah."</td>				
				<td align='center'>".$kompetensi_id."</td>
				<td align='center'>
	                <a href='#' title='Edit' class='btn btn-xs btn-default' id='edit_".$no."' onclick=\"load_form(this.id)\" data-toggle='modal' data-target='#remoteModal'>
	                <input type='hidden' id='ajax-req-dt' name='id' value='".$row['kompetensi_id']."'/>
	                <input type='hidden' id='ajax-req-dt' name='search_dt2' value='".$search_dt2."'/>
	                <input type='hidden' id='ajax-req-dt' name='act' value='edit'/>
	            	<i class='fa fa-edit'></i></a>&nbsp
	            	<a href='#' title='Hapus' class='btn btn-xs btn-default' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id)}\" id='delete_".$no."'>
	            	<input type='hidden' id='ajax-req-dt' name='id' value='".$row['kompetensi_id']."'/>
	            	<input type='hidden' id='ajax-req-dt' name='search_dt2' value='".$search_dt2."'/>
	            	<i class='fa fa-trash-o'></i></a>&nbsp
	            </td>
				</tr>";
			}
			
		echo "</tbody>
	</table>";
?>