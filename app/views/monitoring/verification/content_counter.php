<?php
	echo "
	<div class='row'>
	<div class='col-md-6'>
	<h1 style='font-size:2.5em' id='counter".$i."'>".number_format($t)."</h1>Orang</div>
	<div class='col-md-6'>
	<table class='table table-bordered'>
	<tbody>
		<tr><td><b>".($type=='1'?'L':'SMA')."</b>:</td><td align='right'>".number_format($n1)."</td></tr>
		<tr><td><b>".($type=='1'?'P':'SMK')."</b>:</td><td align='right'>".number_format($n2)."</td></tr>
	</tbody>
	</table>
	</div>";
?>