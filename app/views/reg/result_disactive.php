<style type="text/css">
	table.table tr.selected > td{		
		font-weight:bold!important;
	}
</style>
<div class="container-fluid box">
<?php
	echo "
	<ul class='nav nav-tabs tabs-left'>";	   	
	   	$i=0;
	    foreach($sekolah_pilihan_rows as $row){
	    	$i++;
	    	echo "<li ".($i==1?"class='active'":"")."><a data-toggle='tab' href='#menu".$i."'>(".$i.") ".$row['nama_sekolah']."</a></li>";
	    }

	echo "</ul>

	<div class='tab-content'>";
		$i=0;
		$j = 0;
		
    		foreach($sekolah_pilihan_rows as $row){			
    
    			$i++;
    
    			echo "<div id='menu".$i."' class='tab-pane ".($i==1?"fade in active":"fade")."'>";
    
    			if($tipe_sekolah=='1'){
    
    				$status = true;
    				$status = ($j>0?:'');
    				
    				$status = ($sekolah_pilihan_arr[$j][1]!='0'?true:false);
    				
    				if(($j>0 and $sekolah_pilihan_arr[$j-1][1]=='3'))
    					$status = false;
    				
                    $params = array();
                    
    				if($status or 1<2)
    				{
    				    
    					$params[0] = $row['sekolah_id'];
    					$hasil_seleksi_dao->set_sql_params($params);
    					$query = $hasil_seleksi_dao->execute(1);
    					$hasil_seleksi_rows = $query->result_array();
                        
                        $lbl_skor = ($path=='1' || $path=='2'?'Jarak':'Skor');
                        $satuan = ($path=='1' || $path=='2'?' m':'');

    					echo "
    				    <table class='table table-bordered table-striped table-hover'>
    				    	<thead>
    				    		<tr>
    				    			<td width='4%' align='center'><b>Peringkat</b></td><td align='center'><b>Nama</b></td>
    				    			<td align='center'><b>No. Registrasi</b></td><td align='center'><b>".$lbl_skor."</b></td>
    				    		</tr>
    				    	</thead>
    				    	<tbody>";
    				    	
    				    	$k = 0;
    				    	$line_printed = false;
    				    	foreach($hasil_seleksi_rows as $row2)
    				    	{
    
    				    		$k++;
    				    		$class = ($this->session->userdata('nopes')==$row2['id_pendaftaran']?"class='selected'":"");
    
    				    		if($k<=$row['kuota_jalur'])
    				    		{
    					    		echo "<tr ".$class.">
    					    		<td align='center'>".$row2['peringkat']."</td><td>".$row2['nama']."</td><td align='center'>".$row2['no_pendaftaran']."</td>
    					    		<td align='right'>".number_format($row2['score'],2,',','.')."</td>
    					    		</tr>";
    					    	}else{
    					    		if(!$line_printed){
    					    			echo "<tr>
    					    			<td colspan='4' align='center' style='background:#ff0000;color:#fff'>Yang berada di bawah garis merah tidak lulus dalam seleksi jalur ini.</td>
    					    			</tr>";
    					    			$line_printed = true;
    					    		}
    					    		echo "<tr ".$class.">
    					    		<td align='center'>".$row2['peringkat']."</td><td>".$row2['nama']."</td><td align='center'>".$row2['no_pendaftaran']."</td>
    					    		<td align='right'>".number_format($row2['score'],2,',','.').$satuan."</td>
    					    		</tr>";
    					    	}
    
    				    	}
    
    				    	echo "</tbody>
    				    </table>";
    				}else{
    					echo "
    						<div class='alert alert-warning'>
    						  <strong>Perhatian!</strong> Hasil Seleksi untuk Sekolah Pilihan ke-".$i." belum dirilis!
    						</div>";
    				}
    			}
    			else
    			{
    				echo "
    				<table class='table table-bordered table-striped table-hover'>
    			    	<thead>
    			    		<tr>
    			    			<td width='4%' align='center'><b>Peringkat</b></td><td align='center'><b>Nama</b></td>
    			    			<td align='center'><b>No. Registrasi</b></td><td align='center'><b>Skor</b></td>
    			    		</tr>
    			    	</thead>
    			    	<tbody>";
    			    		
    			    		$params = array($row['sekolah_id'],$row['sekolah_id']);			    		
    			    		
    						$kompetensi_dao->set_sql_params($params);
    						$query = $kompetensi_dao->execute(1);
    						$kompetensi_rows = $query->result_array();
    
    
    
    						foreach($kompetensi_rows as $row2){
    							echo "<tr>
    							<td colspan='4'><b>".$row2['nama_kompetensi']."</b></td>
    							</tr>";
    
    							$params = array($row2['kompetensi_id']);
    							$hasil_seleksi_dao->set_sql_params($params);
    							$query = $hasil_seleksi_dao->execute(1);
    							$hasil_seleksi_rows = $query->result_array();
    
    							$k = 0;
    					    	$line_printed = false;
    					    	foreach($hasil_seleksi_rows as $row3)
    					    	{
    
    					    		$k++;
    					    		$class = ($this->session->userdata('nopes')==$row3['id_pendaftaran']?"class='selected'":"");
    
    					    		if($k<=$row2['kuota_jalur'])
    					    		{
    						    		echo "<tr ".$class.">
    						    		<td align='center'>".$row3['peringkat']."</td><td>".$row3['nama']."</td><td align='center'>".$row3['no_pendaftaran']."</td>
    						    		<td align='right'>".number_format($row3['score'],2,',','.')."</td>
    						    		</tr>";
    						    	}else{
    						    		if(!$line_printed){
    						    			echo "<tr>
    						    			<td colspan='4' align='center' style='background:#ff0000;color:#fff'>Yang berada di bawah garis merah tidak lulus dalam seleksi jalur ini.</td>
    						    			</tr>";
    						    			$line_printed = true;
    						    		}
    						    		echo "<tr ".$class.">
    						    		<td align='center'>".$row3['peringkat']."</td><td>".$row3['nama']."</td><td align='center'>".$row3['no_pendaftaran']."</td>
    						    		<td align='right'>".number_format($row3['score'],2,',','.')."</td>
    						    		</tr>";
    						    	}
    
    					    	}
    
    						}
    			    	echo "</tbody>
    			    </table>";
    			}
    
    			$j++;
    
    		    echo "</div>";
    		}
		

	echo "</div>";
?>
</div>