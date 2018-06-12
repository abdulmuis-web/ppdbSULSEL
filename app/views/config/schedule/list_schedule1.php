<?php
	
	echo "
	<table class='table table-bordered'>
		<thead>
			<tr><th>Nama Jalur</th><th>Tgl. Buka</th><th>Tgl. Tutup</th><th>Status</th><th>Aksi</th></tr>
		</thead>
		<tbody>";
			$no = 0;
			foreach($rows as $row){
				$no++;
				$status = check_status_dateRange($row['tgl_buka'],$row['tgl_tutup']);
				switch($status){
					case 'pre':$lbl_status="<font color='orange'>Belum buka</font>";break;
					case 'on':$lbl_status="<font color='green'>Sedang berlangsung</font>";break;
					case 'finish':$lbl_status="<font color='red'>Tutup</font>";break;
				}
				echo "<tr><td>".$row['nama_jalur']."</td><td>".indo_date_format($row['tgl_buka'],'shortDate')."</td>
				<td>".indo_date_format($row['tgl_tutup'],'shortDate')."</td>
				<td>".$lbl_status."</td>
				<td align='center'>";

					if($update_access)
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' id='edit1_".$schedule_seq."_".$no."' onclick=\"load_form(this.id)\" data-toggle='modal' data-target='#remoteModal'>";
	                else
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' onclick=\"alert('anda tidak diijinkan untuk merubah data!');\">";
	                
	                echo "
	                <input type='hidden' id='ajax-req-dt' name='id' value='".$row['jadwal_id']."'/>
	                <input type='hidden' id='ajax-req-dt' name='type' value='1'/>
	                <input type='hidden' id='ajax-req-dt' name='act' value='edit'/>
	                <input type='hidden' id='ajax-req-dt' name='schedule_seq' value='".$schedule_seq."'/>
	                <input type='hidden' id='ajax-req-dt' name='tipe_sekolah_id' value='".$tipe_sekolah_id."'/>
	            	<i class='fa fa-edit'></i></a>&nbsp";
				echo "</td></tr>";
			}
		echo "</tbody>
	</table>";
	
?>