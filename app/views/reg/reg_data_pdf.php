<?php
	if($this->session->userdata('gambar')==''){
        $src = $this->config->item('img_path').'default_photo.png';
    }else{
        $src = $this->config->item('upload_path').'registration/'.$this->session->userdata('gambar');
    }

	$html = "<!DOCTYPE html><html><head>
			 <link rel='stylesheet' type='text/css' href='".$this->config->item('css_path')."report-style.css'/>
			 <link rel='stylesheet' type='text/css' href='".$this->config->item('css_path')."report-table-style.css'/>			 
			 </head>
			 <body>
			 <div style='margin:5px;'>
			 <div class='fluid'>
			 <img src='".$this->config->item('img_path')."logo_ppdb.png' width='160px' style='float:left'/>
			 <div style='float:left'><h4>DATA PENDAFTARAN PPDB ONLINE<br />PROVINSI SULAWESI SELATAN TAHUN 2018</h4></div>
			 <div style='clear:both'></div>
			 </div><br />			 			 
			 
			 <table class='report' cellpadding='0' cellspacing='0'>
			 <tbody>			 
			 <tr><td width='30%'>No. Peserta</td><td class='bor-right'>".$no_peserta."</td></tr>
			 <tr><td>No. Registrasi</td><td class='bor-right'><b>".$no_registrasi."</b></td></tr>
			 <tr><td>Nama</td><td class='bor-right'>".$nama."</td></tr>
			 <tr><td>J. Kelamin</td><td class='bor-right'>".($jk=='L'?'Laki-laki':'Perempuan')."</td></tr>
			 <tr><td>Sekolah Asal</td><td class='bor-right'>".$sekolah_asal."</td></tr>
			 <tr><td>Alamat</td><td class='bor-right'>".$alamat."</td></tr>
			 <tr><td>Kecamatan</td><td class='bor-right'>".$kecamatan."</td></tr>						
			 <tr><td>Kota/Kab.</td><td class='bor-right'>".$nm_dt2."</td></tr>
			 <tr><td>Jalur Pendaftaran</td><td class='bor-right'>".$jalur_pendaftaran['nama_jalur']."</td></tr>
			 <tr><td>Jenjang Sekolah Pilihan</td><td class='bor-right'>".$tipe_sekolah['nama_tipe_sekolah']." (".$tipe_sekolah['akronim'].")</td></tr>
			 <tr><td valign='top' class='bor-bottom'>Sekolah Pilihan</td><td class='bor-right bor-bottom'><ol type='1'>";

	foreach($sekolah_pilihan_arr as $item){
		$html .= "<li>".$item."</li>";
	}
	$html .= "</ol></td></tr>
			  </tbody></table>
			 </div></body></html>";
	
	$mpdf->SetTitle('Data Registrasi');
	$mpdf->WriteHTML($html);
	$mpdf->Output('data_registras.pdf','I');	
?>