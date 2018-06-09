<script type="text/javascript" src="<?=$this->config->item('js_path');?>my_scripts/ajax_upload.js"></script>

<div class="container-fluid box">
	<div style="padding:15px">
		<div class="row">
			<div class="col-lg-4 col-md-4">
				<div id="registration-photo">
					<?php
						$this->load->view($this->active_controller.'/registration_photo');
					?>
				</div>
				<br />
				<center><button type="button" class="btn btn-default btn-xs" data-toggle="modal" onclick="$('#upload-form')[0].reset();$('#upload-notify').hide();$('#upload-loader').hide();" data-target="#uploadModal"><i class="fa fa-upload"></i> Unggah Foto</button></center>
				<br />
			</div>
			<div class="col-lg-8 col-md-8">
				<table class="table table-bordered">
					<thead>
						<th colspan="2"><i class="fa fa-file-text-o"></i> DATA PENDAFTARAN</th>
					</thead>
					<tbody>
						<?php
						echo "
						<tr><td>No. Peserta</td><td>".$no_peserta."</td></tr>
						<tr><td>No. Registrasi</td><td><b>".$no_registrasi."</b></td></tr>
						<tr><td>Nama</td><td>".$nama."</td></tr>
						<tr><td>J. Kelamin</td><td>".($jk=='L'?'Laki-laki':'Perempuan')."</td></tr>
						<tr><td>Sekolah Asal</td><td>".$sekolah_asal."</td></tr>
						<tr><td>Alamat</td><td>".$alamat."</td></tr>
						<tr><td>Kecamatan</td><td>".$kecamatan."</td></tr>						
						<tr><td>Kota/Kab.</td><td>".$nm_dt2."</td></tr>
						<tr><td>Jalur Pendaftaran</td><td>".$jalur_pendaftaran['nama_jalur']."</td></tr>
						<tr><td>Jenjang Sekolah Pilihan</td><td>".$tipe_sekolah['nama_tipe_sekolah']." (".$tipe_sekolah['akronim'].")</td></tr>
						<tr><td>".strtoupper($tipe_sekolah['akronim'])." Pilihan</td>
							<td>
								<ol type='1'>";
									foreach($sekolah_pilihan_arr as $item){
										echo "<li>".$item."</li>";
									}
								echo "</ol>
							</td>
						</tr>";
						?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2" align="right">
								<a href="<?=base_url()."reg/reg_data_pdf/".urlencode($encoded_nopes);?>" target="_blank" class="txt-btn"><b><i class="fa fa-file-pdf-o"></i> PDF</b></a>&nbsp;|&nbsp;
								<a href="<?=base_url()."reg/reg_data_print/".urlencode($encoded_nopes);?>" target="_blank" class="txt-btn"><b><i class="fa fa-print"></i> Cetak</b></a>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>

	<!-- Upload Modal -->
	<script type="text/javascript">
        ajax_upload.form_id[0]='upload-form';
        ajax_upload.loader_id[0]='upload-loader';
        ajax_upload.content_id[0]='registration-photo';
        ajax_upload.notify_id[0]='upload-notify';
    </script>

    <div class="modal fade" id="uploadModal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form method="POST" action="<?=base_url();?>reg/upload_photo" id="upload-form" class="form-horizontal" onsubmit="ajax_upload.upload_files(event,0);" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Unggah Foto</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">                        
                        <div class="col-md-12">
                            <div class="input">
                                <input class="form-control" id="file_foto" type="file" name="file_foto" onchange="ajax_upload.prepare_upload(event,['image/jpeg','image/png'],600000)" required>
                                <span class="help-block">Format : .jpg, .png | Maksimal : 600 Kb</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-6 col-md-6" align="left">
                            <div id="upload-notify" style="display:none"></div>
                            <div id="upload-loader" style="display:none">
                                <img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/> <b>Mohon tunggu ....</b>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btn-upload">Submit</button>
                        </div>
                    </div>  
                </div>
            </form>
            </div>
        </div>
    </div>
</div>