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
			$kompetensi_id = '';
			foreach($rows as $row){
				$no++;
				echo "<tr>
				<td align='center'>".$no."</td>
				<td>".$row['no_pendaftaran']."</td>
				<td>".$row['nama']."</td>
				<td>".$row['alamat']."</td>
				<td>".$row['sekolah_asal']."</td>";

				if($tipe_sekolah=='2'){					
					echo "<td>".$row['nama_kompetensi']."</td>";
					$kompetensi_id = $row['kompetensi_id'];
				}

				echo "<td align='center'>
	                <a title='Hapus' class='btn btn-xs btn-default' id='delete_".$no."' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id)}\">
	                <input type='hidden' id='ajax-req-dt' name='id_pendaftaran' value='".$row['id_pendaftaran']."'/>
	                <input type='hidden' id='ajax-req-dt' name='kompetensi_id' value='".$kompetensi_id."'/>
	                <i class='fa fa-trash-o'></i></a>
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