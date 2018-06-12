<table id="data-table-jq" class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th width="4%">No.</th><th>No. Pendaftaran</th><th>Nama</th><th>Alamat</th><th>Sekolah Asal</th>
			<?php
			if($tipe_sekolah=='2')
				echo "<th>Kompetensi</th>";			
			?>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no = 0;
			
			foreach($rows as $row){
				$no++;

				$encoded_regid = base64_encode($row['id_pendaftaran']);
				$encoded_fieldid = base64_encode($row['kompetensi_id']);

				echo "<tr>
				<td align='center'>".$no."</td>
				<td>".$row['no_pendaftaran']."</td>
				<td>".$row['nama']."</td>
				<td>".$row['alamat']."</td>
				<td>".$row['sekolah_asal']."</td>";

				if($tipe_sekolah=='2'){					
					echo "<td>".$row['nama_kompetensi']."</td>";					
				}

				echo "<td align='center'>";

					if($delete_access)
	            		echo "<a href='#' title='Hapus' class='btn btn-xs btn-default' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id)}\" id='delete_".$no."'>";
	            	else
	            		echo "<a href='#' title='Hapus' class='btn btn-xs btn-default' onclick=\"alert('anda tidak diijinkan untuk menghapus data!')\">";

	            	echo "
	                <input type='hidden' id='ajax-req-dt' name='id_pendaftaran' value='".$row['id_pendaftaran']."'/>
	                <input type='hidden' id='ajax-req-dt' name='kompetensi_id' value='".$row['kompetensi_id']."'/>
	                <input type='hidden' id='ajax-req-dt' name='jalur_id' value='".$row['jalur_id']."'/>
	                <i class='fa fa-trash-o'></i></a>&nbsp;
	                <a class='btn btn-default btn-xs' href='".base_url().$active_controller."/print_verification/".urlencode($encoded_regid)."/".urlencode($encoded_fieldid)."' target='_blank'><i class='fa fa-print'></i></a>
				</td>
				</tr>";
			}
		?>
	</tbody>
</table>
<script type="text/javascript">
	$(function(){
		oTable = $('#data-table-jq').dataTable({
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