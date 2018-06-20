    <style type="text/css">
        .notify-message{
            display:none;
            color: red; 
            font-weight: bold; 
            font-size: 1.2em; 
        }
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
                <div class="navbar-brand" style="margin:0!important;padding:10px 0"><img src="<?=$this->config->item('img_path');?>logo_ppdb.png" width="160px"/></div>
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
                    
                    if(is_null($this->session->userdata('nopes')))
                        echo "<li><a href='#' data-toggle='modal' onclick=\"$('#login_nopes').val('-');$('#login_nopes').data('previousValue', null).valid();$('#login_nopes').val('')\" data-target='#loginModal'>Login</a></li>";
                    else
                    {
                        echo "
                        <li><a href='#' class='highlighted'>
                        ".$this->session->userdata('nopes')."
                        </a></li>
                        <li><a href='#' data-toggle='modal' data-target='#profilModal'><i class='fa fa-user' title='Lihat Profil'></i></a></li>
                        <li><a href='".base_url()."front/logout' title='Logout'><i class='fa fa-sign-out'></i></a></li>
                        ";
                    }
                    ?>

    			</ul>
    		</div>
    	</div>
    </div>
    <!-- END NAVIGATIONS -->

    <!-- Detail Modal -->    
   <div class="modal fade" id="profilModal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Login</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <?php
                            echo "
                            <tr><td>No. Peserta</td><td> : ".$this->session->userdata('nopes')."</td></tr>
                            <tr><td>Nama</td><td> : ".$this->session->userdata('nama')."</td></tr>
                            <tr><td>Alamat</td><td> : ".$this->session->userdata('alamat')."</td></tr>
                            <tr><td>Kab./Kota</td><td> : ".$this->session->userdata('nm_dt2')."</td></tr>
                            <tr><td>Sekolah Asal</td><td> : ".$this->session->userdata('sklh_asal')."</td></tr>";
                            ?>
                        </tbody>
                    </table>
                </div>            
            </div>
        </div>
    </div>

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
                        <label class="control-label col-md-4" for="login_nopes">No. Peserta</label>
                        <div class="col-md-8">
                            <div class="input">
                                <input class="form-control" id="login_nopes" type="text" name="login_nopes" required>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group">                        
                        <div class="col-md-8 col-md-offset-4">
                            <div class="input">                                
                                <input type="checkbox" name="check_akses_pertama" onclick="control_input_password($(this).prop('checked'))" id="check_akses_pertama" value="1"/><label for="check_akses_pertama"><span></span> Akses Pertama</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="container_input_password">
                        <label class="control-label col-md-4" for="login_password">Password</label>
                        <div class="col-md-5">
                            <div class="input">
                                <input class="form-control" id="login_password" type="password" name="login_password" required>
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label class="control-label col-md-4"></label>
                        <div class="col-md-5">
                            <?php                                 
                                echo "<img id='captcha' src='".site_url()."front/securimage'/>                                
                                <a href='#' onclick=\"document.getElementById('captcha').src = '".site_url()."front/securimage?'+Math.random();return false\">[ Different Image ]</a>
                                <br />
                                <input type='text' name='secure_code' id='secure_code' class='form-control'/>";
                            ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">

                        <div class="col-lg-6 col-md-6" align="left">
                            <div id="login-notify" class="notify-message">
                            </div>
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
                            System Penerimaan Peserta Didik Baru Secara Online merupakan <b>SUB SYSTEM dari E-PANRITA</b> 
                            yang <i>ter-integrasi</i> dengan <b>BIG DATA PENDIDIKAN</b> yang mencakup Data AKADEMIK dan NON AKADEMIK
                            sejak awal Pendaftaran hingga Akhir Pendidikan.</br></br> <h3><b>PPDB E-PANRITA</b></h3>
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
                    echo "<li><span class='badge badge-primary' id='active_item_breadcrumb'>".$item['text']."</span></li>";
                }
            }
        ?>
    </ul>    
    <!-- END BREADCRUMBS -->
    <?php } ?>

    <script type="text/javascript">
    
        var $form=$('#login-form'),$loginLoader = $('#login-loader'),$loginNotify = $('#login-notify');

        $(function() {
            // Validation
            var stat = $form.validate({
                // Rules for form validation
                rules : {
                    login_nopes : {
                        required : true 
                    }
                },

                // Messages for form validation
                messages : {
                    login_nopes : {
                        required : 'Silahkan masukkan Nomor Peserta anda' 
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
                        $loginNotify.html('');
                        $loginNotify.hide();
                        $loginLoader.show();
                      },
                      success:function(data){
                        $loginLoader.hide();
                        error=/ERROR/;
                        if(data=='failed' || data.match(error))
                        {
                            if(data=='failed')
                            {
                                content_box = "Maaf, Nomor Peserta salah !";
                            }else{
                                x = data.split(':');
                                content_box = x[1].trim();
                            }
                            
                            $loginNotify.html(content_box);
                            $loginNotify.show();
                            setTimeout("jQuery($loginNotify).fadeOut()", 10000);
                        }                        

                        if(data=='success')
                            window.location.assign($('#baseUrl').val());
                      }
                    });
                    return false;
                }
            });
        });

        function control_input_password(checked){
            var $password = $('#login_password'),$container_password = $('#container_input_password');
            if(checked){
                $container_password.hide();
                $password.attr('disabled',true);
                $password.attr('required',false);
            }else{
                $container_password.show();
                $password.attr('disabled',false);
                $password.attr('required',true);
            }

        }

    </script>