<ul class="nav nav-tabs">
	<?php
		$i = 0;
		foreach($tipe_sekolah_rows as $row){
			$i++;
			echo "
			<li ".($i==1?"class='active'":"").">
				<a href='#list_quota1_".$i."' data-toggle='tab'>".$row['akronim']."</a>
			</li>";
		}
	?>	
</ul>
<div class="tab-content padding-10">
	<?php
		$i = 0;
		foreach($tipe_sekolah_rows as $row){
			$i++;
			echo "
			<div class='tab-pane ".($i==1?'active':'')."' id='list_quota1_".$i."'>";
				echo $list_of_data[$i];
			echo "</div>";
		}		
	?>	
</div>