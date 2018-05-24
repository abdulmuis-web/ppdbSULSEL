    <style type="text/css">
        .error{color:red;}
    </style>
    <!-- NAVIGATION -->
    
    <input type="hidden" id="baseUrl" value="<?=base_url();?>"/>

    <div id="myNavbar" class="navbar navbar-default navbar-fixed-top" role="navigation">
    	<div class="container">
    		<div class="navbar-header">
    			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
    				<span class="icon-bar"></span>
    				<span class="icon-bar"></span>
     				<span class="icon-bar"></span>
    			</button>
                <a href="#" class="navbar-brand">PPDB 2018 SMA/SMK</a>
    		</div>
    		<div class="navbar-collapse collapse">
    			<ul class="nav navbar-nav navbar-right">
    				
                    <li><a href="<?=base_url();?>">home</a></li>

                    <?php
                    if($active_controller=='front')
                    {
                        echo "
        				<li><a href='#conditions'>Ketentuan</a></li>
        				<li><a href='#requirements'>Persyaratan</a></li>
                        <li><a href='#stage'>Jenjang</a></li>
        				<li><a href='#contact'>Kontak</a></li>";
                    }                    
                    
                    if(is_null($this->session->userdata('nun')))
                        echo "<li><a href='#' data-toggle='modal' onclick=\"$('#login_nun').val('-');$('#login_nun').data('previousValue', null).valid();$('#login_nun').val('')\" data-target='#loginModal'>Login</a></li>";
                    else
                        echo "<li><a href='".base_url()."front/logout'>Logout</a></li>";
                    ?>

    			</ul>
    		</div>
    	</div>
    </div>
    <!-- END NAVIGATIONS -->

    <?php

    
    if(!is_null($this->session->userdata('nun')))
    {
        if($this->session->userdata('gambar')==''){
            $src = $this->config->item('img_path').'default_photo.png';
        }else{
            $src = $this->config->item('upload_path').'pendaftar/'.$this->session->userdata('gambar');
        }
        echo "
        <div class='login-info row'>
            <div class='col-lg-3'>
                <img src='".$src."' alt='Profil' width='80px'/>     

            </div>
            <div class='col-lg-9'>
                <table border=0>
                    <tr><td>Nama</td><td>: ".$this->session->userdata('nama')."</td></tr>
                    <tr><td>Alamat</td><td>: ".$this->session->userdata('alamat')."</td></tr>
                    <tr><td>Kelurahan</td><td>: ".$this->session->userdata('nm_kel')."</td></tr>
                    <tr><td>Kecamatan</td><td>: ".$this->session->userdata('nm_kec')."</td></tr>
                    <tr><td>Kota/Kab.</td><td>: ".$this->session->userdata('nm_dt2')."</td></tr>
                </table>                
            </div>
        </div>";
    }
    

    ?>
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <form method="POST" action="<?=base_url();?>front/login" id="login-form" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Login</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-md-4" for="login_nun">No. Ujian Nasional</label>
                        <div class="col-md-8">
                            <div class="input">
                                <input class="form-control" id="login_nun" type="text" name="login_nun" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-6 col-md-6" align="left">
                            <div id="login-notify" style="display:none"></div>
                            <div id="login-loader" style="display:none">
                                <img src="<?=$this->config->item('img_path');?>ajax-loaders/ajax-loader-1.gif"/> <b>Mohon tunggu ....</b>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btn-login">Sign In</button>
                        </div>
                    </div>  
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- HEADER -->
    <div id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 wow bounceInLeft">
                    <div class="text-container">
                        <h1>Selamat Datang di PPDB Online</h1>
                        <h3>Dinas Pendidikan Provinsi Sulawesi Selatan</h3><br />
                        <p>
                            Lorem Ipsum is simply dummy text of the printing typesetting industry. Lorem Ipsum has been the industry's 
                            standard dummy text ever since the 1500s, when an unknown printer took a gallery of type and scrambled it to make a 
                            type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting.                        
                        </p> 
                    </div>                   
                </div>
                <div id="img-header" class="col-lg-6 col-md-6 wow bounceInRight">
                    <div class="row">                        
                        <div class="col-lg-6 col-md-6" align="center">
                            <img src="<?=$this->config->item('img_path');?>logo_sulsel.png" alt=""/>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div style="margin-top:150px">
                                <h2>Provinsi Sulawesi Selatan</h2>
                                <h3>Tahun Pelajaran 2018/2019</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END HEADER -->

    <?php
    if($active_controller=='reg')
    {
    ?>
    <!-- BREADCRUMBS -->    
    <ul class="breadcrumb" style="">
        <?php                
            foreach($breadcrumbs as $item){
                if(!$item['active']){
                    echo "<li><a href='".$item['url']."'>".$item['text']."</a></li>";
                }else{
                    echo "<li><span class='badge badge-primary'>".$item['text']."</span></li>";
                }
            }
        ?>
    </ul>    
    <!-- END BREADCRUMBS -->
    <?php } ?>

    <script src="<?=$this->config->item('js_path');?>plugins/jquery-validate/jquery.validate.min.js"></script>
    <script type="text/javascript">
        var $form=$('#login-form'),$loginLoader = $('#login-loader'),$loginNotify = $('#login-notify');

        $(function() {
            // Validation
            var stat = $form.validate({
                // Rules for form validation
                rules : {
                    login_nun : {
                        required : true 
                    }
                },

                // Messages for form validation
                messages : {
                    login_nun : {
                        required : 'Silahkan masukkan Nomor Ujian Nasional anda' 
                    },                    
                },

                // Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
            });

            $form.submit(function(){
                if(stat.checkForm())
                {
                    $.ajax({
                      type:'POST',
                      url:$form.attr('action'),
                      data:$form.serialize(),
                      beforeSend:function(){    
                        $loginLoader.show();
                      },
                      success:function(data){
                        
                        $loginLoader.hide();

                        error=/ERROR/;

                        if(data=='failed' || data.match(error))
                        {
                            if(data=='failed')
                            {
                                content_box = "Maaf, Nomor Ujian Sekolah salah !";
                            }else{
                                x = data.split(':');
                                content_box = x[1].trim();
                            }
                            
                            $loginNotify.html(content_box);
                            $loginNotify.show();
                        }                        

                        if(data=='success')
                            window.location.assign($('#baseUrl').val());
                      }
                    });
                    return false;
                }
            });
        });
    </script>