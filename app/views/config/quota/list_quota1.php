<?php
	
	echo "
	<table class='table table-bordered'>
		<thead>
			<tr><th>No.</th><th>Nama Jalur</th><th>Kategori</th><th>Jml. Sekolah Pilihan</th><th>Kuota (%)</th><th>Jml. Diterima</th><th>Aksi</th></tr>
		</thead>
		<tbody>";
			$no = 0;
			foreach($rows as $row){
				$no++;
				
				echo "<tr>
				<td align='center'>".$no."</td>
				<td>".$row['nama_jalur']."</td>
				<td>".$row['nama_ktg_jalur']."</td>
				<td align='right'>".$row['jml_sekolah']."</td>
				<td align='right'>".$row['persen_kuota']."</td>
				<td align='right'>".number_format($row['jumlah_kuota'],0,',','.')."</td>
				<td align='center'>";
					
					if($update_access)
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' id='edit1_".$quota_seq."_".$no."' onclick=\"load_form(this.id)\" data-toggle='modal' data-target='#remoteModal'>";
	                else
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' onclick=\"alert('anda tidak diijinkan untuk merubah data!');\">";
	                
	                echo "
	                <input type='hidden' id='ajax-req-dt' name='id' value='".$row['pengaturan_kuota_id']."'/>
	                <input type='hidden' id='ajax-req-dt' name='type' value='1'/>
	                <input type='hidden' id='ajax-req-dt' name='act' value='edit'/>
	                <input type='hidden' id='ajax-req-dt' name='quota_seq' value='".$quota_seq."'/>
	                <input type='hidden' id='ajax-req-dt' name='tipe_sekolah_id' value='".$tipe_sekolah_id."'/>
	                <input type='hidden' id='ajax-req-dt' name='tipe_sekolah' value='".$tipe_sekolah."'/>
	            	<i class='fa fa-edit'></i></a>&nbsp";
				echo "</td></tr>";
			}
		echo "</tbody>
	</table>";
	
?>