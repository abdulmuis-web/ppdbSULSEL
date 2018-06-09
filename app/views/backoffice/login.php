<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Admin Panel PPDB Online Prov. Sulsel 2018 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="<?=$this->config->item('assets_path');?>css/bootstrap.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=$this->config->item('assets_path');?>css/font-awesome.min.css">
    
    <link rel="stylesheet" href="<?=$this->config->item('backoffice_assets_path');?>css/AdminLTE.min.css">    
    
    <!-- JQuery Js CDN -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="<?=$this->config->item('js_path');?>my_scripts/global_function.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
  <body style="background:url(<?=$this->config->item('img_path');?>login_background.png)">
    <?php
    ?>
    <div class="row" style="margin:10px!important;">
      <div class="col-md-6 col-md-offset-3">
        <div class="row">
          <div class="col-md-12" align="center" style="position:relative">            
          </div>
        </div>
            
              <h3 align="center" style="margin-top:20px;padding:0">ADMIN Panel PPDB Online<br />
                Provinsi Sulawesi Selatan</h3>
                          
                <div class="login-box" style="margin-top:10px!important;">
                  <div class="login-box-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    <input type="hidden" id="baseUrl" value="<?=base_url();?>"/>
                    <form id="login-form" action="<?=base_url();?>backoffice/login" method="post">
                      <div class="form-group has-feedback">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                      </div>
                      <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                      <div class="row">
                        <div class="col-xs-7">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> Remember Me
                            </label>
                          </div>
                        </div><!-- /.col -->
                        <div class="col-xs-5">
                          <button type="submit" id="login-btn" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div><!-- /.col -->
                      </div>
                    </form>

                  </div><!-- /.login-box-body -->
              </div><!-- /.login-box -->              
        
      </div>
  </div>
    
    
     <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="<?=$this->config->item('js_path')?>plugins/noty/jquery.noty.js"></script>
    <script src="<?=$this->config->item('js_path')?>plugins/noty/layouts/topRight.js"></script>
    <script src="<?=$this->config->item('js_path')?>plugins/noty/themes/default.js"></script>
    <script type="text/javascript" src="<?=$this->config->item('js_path')?>plugins/masked-input/jquery.maskedinput.min.js"></script>
    <script type="text/javascript" src="<?=$this->config->item('js_path')?>my_scripts/ajax_object.js"></script>

    <script type="text/javascript">

      (function($) {
        $(document).ready(function(){
          
          var $login_form=$('#login-form'),$btnLogin=$('#login-btn'),
              $loadImg="<?php echo "<img src='".$this->config->item('img_path')."ajax-loaders/ajax-loader-1.gif'/>";?>";
          
          $login_form.submit(function(){
            $.ajax({
              type:'POST',
              url:$login_form.attr('action'),
              data:$login_form.serialize(),              
              dataType:'json',
              beforeSend:function(){    
                $btnLogin.html($loadImg+"please wait...");
              },
              success:function(data){

                $btnLogin.html("Log in");

                if(data.status == 'success'){
                  noty({text: "I know you and I\'m redirecting you to Dasboard Page "+$loadImg, layout: 'topRight', type: 'success'})    
                  window.location.assign($('#baseUrl').val()+'backoffice/');
                }else{
                  
                  msg = (data.status =='failed1'?'Maaf, Username atau Password tidak dikenali !':'Akun anda tidak aktif, Silahkan hubungi Admin Dinas Pendidikan');
                  noty({text: msg, layout: 'topRight', type: 'error', timeout:2000});
                }

           
              },
              error: function(xhr, resp, text) {
                    console.log(xhr, resp, text);
                }
            });
            return false;
          });

        });        

      })(jQuery);
          

      
    </script>
  </body>
</html>
