<?php
	echo "
	<table id='data-table-jq' class='table table-striped table-bordered table-hover' width='100%'>
		<thead>
			<tr>
				<th width='4%'>No.</th>
				<th>Username</th>
				<th>Tipe User</th>
				<th>Email</th>
				<th>Status</th>
				<th>Terakhir Dimodifikasi</th>
				<th>Aksi</th>
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
				<td>".$username."</td>
				<td>
				".$tipe_user.($type_fk=='3' || $type_fk=='4'?" <br /><b>".$nama_sekolah."</b>":"")."
				</td>
				<td>".$email."</td>
				<td>".($status=='0'?"<font color='red'>non active</font>":"<font color='green'>active</font>")."</td>
				<td>".(!is_null($last_modified)?$last_modified." oleh : <b>".$modified_by."</b>":"")."</td>
				<td align='center'>";

					if($update_access)
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' id='edit_".$no."' onclick=\"load_form(this.id)\" data-toggle='modal' data-target='#remoteModal'>";
	                else
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' id='edit_".$no."' onclick=\"alert('anda tidak diijinkan untuk merubah data!')\">";
	                
	                echo "
	                <input type='hidden' id='ajax-req-dt' name='id' value='".$admin_id."'/>
	                <input type='hidden' id='ajax-req-dt' name='search_user_type' value='".$search_user_type."'/>
	                <input type='hidden' id='ajax-req-dt' name='act' value='edit'/>
	            	<i class='fa fa-edit'></i></a>&nbsp";

	            	if($admin_id!=$this->session->userdata('admin_id')){
		            	if($delete_access)
		            		echo "<a href='#' title='Hapus' class='btn btn-xs btn-default' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id)}\" id='delete_".$no."'>";
		            	else
		            		echo "<a href='#' title='Hapus' class='btn btn-xs btn-default' onclick=\"alert('anda tidak diijinkan untuk menghapus data!')\">";

		            	echo "
		            	<input type='hidden' id='ajax-req-dt' name='id' value='".$admin_id."'/>
		            	<input type='hidden' id='ajax-req-dt' name='search_user_type' value='".$search_user_type."'/>
		            	<i class='fa fa-trash-o'></i></a>&nbsp";

						if($update_access)
		            		echo "<a href='#' title='".($status=='0'?'Aktifkan':'Nonaktifkan')."' class='btn btn-xs btn-default' onclick=\"control_activation(this.id)\" id='control_activation_".$no."'>";
		            	else
		            		echo "<a href='#' title='".($status=='0'?'Aktifkan':'Nonaktifkan')."' class='btn btn-xs btn-default' onclick=\"alert('anda tidak diijinkan untuk merubah data!')\">";

		            	echo "
		            	<input type='hidden' id='ajax-req-dt' name='id' value='".$admin_id."'/>
		            	<input type='hidden' id='ajax-req-dt' name='curr_status' value='".$status."'/>
		            	<input type='hidden' id='ajax-req-dt' name='search_user_type' value='".$search_user_type."'/>
		            	<i class='fa ".($status=='0'?'fa-unlock':'fa-lock')."'></i></a>";
		            }

	            echo "</td>
				</tr>";
			}
			
		echo "</tbody>
	</table>";
?>