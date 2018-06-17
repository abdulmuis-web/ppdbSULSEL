<?php
	
	echo "
	<div class='row' style='margin-bottom:5px;' align='center'>
		<div class='col-lg-12 col-md-12'>";

			if($add_access)
				echo "<a id='add-button4' onclick=\"load_form(this.id)\" class='btn btn-default btn-xs' data-toggle='modal' data-target='#remoteModal'>";
			else
				echo "<a onclick=\"alert('anda tidak diijinkan untuk menambah data');\" class='btn btn-default btn-xs'>";

			echo "<input type='hidden' name='act' value='add' id='ajax-req-dt'/>
				  <input type='hidden' id='ajax-req-dt' name='type' value='4'/>
				  <i class='fa fa-plus'></i> Tambah</a>&nbsp;";
		echo "</div>
	</div>
	<table id='data-table-jq4' class='table table-bordered'>
		<thead>
			<th>No.</th>
			<th>Jenjang</th>
			<th>Persyaratan</th>
			<th width='10%'>Aksi</th></tr>
		</thead>
		<tbody>";
			$no = 0;
			foreach($rows as $row){
				$no++;				
				echo "<tr>
				<td align='center'>".$no."</td>
				<td>".$row['akronim']."</td>
				<td>".$row['persyaratan']."</td>
				<td align='center'>";
					if($update_access)
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' id='edit4_".$no."' onclick=\"load_form(this.id)\" data-toggle='modal' data-target='#remoteModal'>";
	                else
	                	echo "<a href='#' title='Edit' class='btn btn-xs btn-default' onclick=\"alert('anda tidak diijinkan untuk merubah data!');\">";
	                
	                echo "
	                <input type='hidden' id='ajax-req-dt' name='id' value='".$row['persyaratan_id']."'/>
	                <input type='hidden' id='ajax-req-dt' name='type' value='4'/>
	                <input type='hidden' id='ajax-req-dt' name='act' value='edit'/>
	            	<i class='fa fa-edit'></i></a>&nbsp";

	            	if($delete_access)
	            		echo "<a href='#' title='Hapus' class='btn btn-xs btn-default' onclick=\"if(confirm('Anda yakin?')){delete_record(this.id,'4')}\" id='delete2_".$no."'>";
	            	else
	            		echo "<a href='#' title='Hapus' class='btn btn-xs btn-default' onclick=\"alert('anda tidak diijinkan untuk menghapus data!')\">";

	            	echo "
	            	<input type='hidden' id='ajax-req-dt' name='id' value='".$row['persyaratan_id']."'/>
	            	<input type='hidden' id='ajax-req-dt' name='type' value='4'/>
	            	<input type='hidden' id='ajax-req-dt' name='act' value='delete'/>
	            	<i class='fa fa-trash-o'></i></a>
				</td></tr>";
			}
		echo "</tbody>
	</table>";
	
?>

<script type="text/javascript">
	$(function(){
		$('#data-table-jq4').dataTable({
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