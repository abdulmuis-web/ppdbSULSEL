<?php
	
	echo "
	<div class='row' style='margin-bottom:5px;' align='center'>
		<div class='col-lg-12 col-md-12'>";

			if($add_access)
				echo "<a id='add-button_".$schedule_seq."' onclick=\"load_form(this.id)\" class='btn btn-default btn-xs' data-toggle='modal' data-target='#remoteModal'>";
			else
				echo "<a onclick=\"alert('anda tidak diijinkan untuk menambah data');\" class='btn btn-default btn-xs'>";

			echo "<input type='hidden' name='act' value='add' id='ajax-req-dt'/>
				  <input type='hidden' id='ajax-req-dt' name='type' value='2'/>
                  <input type='hidden' id='ajax-req-dt' name='schedule_seq' value='".$schedule_seq."'/>
                  <input type='hidden' id='ajax-req-dt' name='tipe_sekolah_id' value='".$tipe_sekolah_id."'/>
				  <i class='fa fa-plus'></i> Tambah</a>";

		echo "</div>
	</div>
	<table id='data-table-jq".$schedule_seq."' class='table table-bordered'>
		<thead>
			<tr><th>No.</th><th>Nama Kegiatan</th><th>Jalur</th><th>Tanggal</th><th>Lokasi</th><th>Keterangan</th><th>Aksi</th></tr>
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
				echo "<tr>
				<td align='center'>".$no."</td>
				<td>".$row['kegiatan']."</td>
				<td>".$row['nama_jalur']."</td>
				<td align='center'>".mix_2Date($row['tgl_buka'],$row['tgl_tutup'])."</td>
				<td>".$row['lokasi']."</td>
				<td>".$row['keterangan']."</td>
				<td align='center'>";
					if($update_access)
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' id='edit2_".$schedule_seq."_".$no."' onclick=\"load_form(this.id)\" data-toggle='modal' data-target='#remoteModal'>";
	                else
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' onclick=\"alert('anda tidak diijinkan untuk merubah data!');\">";
	                
	                echo "
	                <input type='hidden' id='ajax-req-dt' name='id' value='".$row['jadwal_id']."'/>
	                <input type='hidden' id='ajax-req-dt' name='type' value='2'/>
	                <input type='hidden' id='ajax-req-dt' name='act' value='edit'/>
	                <input type='hidden' id='ajax-req-dt' name='schedule_seq' value='".$schedule_seq."'/>
	                <input type='hidden' id='ajax-req-dt' name='tipe_sekolah_id' value='".$tipe_sekolah_id."'/>
	            	<i class='fa fa-edit'></i></a>&nbsp";

	            	if($delete_access)
	            		echo "<a href='#' title='Hapus' class='btn btn-xs btn-default' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id,'".$schedule_seq."')}\" id='delete2_".$schedule_seq."_".$no."'>";
	            	else
	            		echo "<a href='#' title='Hapus' class='btn btn-xs btn-default' onclick=\"alert('anda tidak diijinkan untuk menghapus data!')\">";

	            	echo "
	            	<input type='hidden' id='ajax-req-dt' name='id' value='".$row['jadwal_id']."'/>
	            	<input type='hidden' id='ajax-req-dt' name='type' value='2'/>
	            	<input type='hidden' id='ajax-req-dt' name='act' value='delete'/>
	                <input type='hidden' id='ajax-req-dt' name='schedule_seq' value='".$schedule_seq."'/>
	                <input type='hidden' id='ajax-req-dt' name='tipe_sekolah_id' value='".$tipe_sekolah_id."'/>
	            	<i class='fa fa-trash-o'></i></a>&nbsp
				</td></tr>";
			}
		echo "</tbody>
	</table>";
	
?>

<script type="text/javascript">
	$(function(){
		var schedule_seq = "<?=$schedule_seq;?>";
		$('#data-table-jq'+schedule_seq).dataTable({
            "oLanguage": {
            "sSearch": "Search :"
            },
            "aoColumnDefs": [
                {
                    'bSortable': false,
                    'aTargets': [0]
                } //disables sorting for column one
            ],
            'iDisplayLength': 10,
            "sPaginationType": "full_numbers"
        });
	});
</script>