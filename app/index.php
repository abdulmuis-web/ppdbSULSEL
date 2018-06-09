<?php
    require_once "configs/__init.php";
    require_once "configs/db_connection.php";
    require_once "configs/app_param.php";
    require_once "libs/DAO.php";

    $db = Connection::get()->connect();
    $dao = new DAO('',$db);
    $_SYS_PARAMS = app_param::system_params($db);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/animate.css-master/animate.min.css">
    <title>Hello, world!</title>
  </head>
  <body>
    <!-- NAVIGATION -->
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
    				<li><a href="#header">home</a></li>
    				<li><a href="#conditions">Ketentuan</a></li>
    				<li><a href="#requirements">Persyaratan</a></li>
    				<li><a href="#path">Jalur</a></li>
    				<li><a href="#registration">Pendaftaran</a></li>
    				<li><a href="#contact">Kontak</a></li>
    			</ul>
    		</div>
    	</div>
    </div>
    <!-- END NAVIGATIONS -->

    <!-- HEADER -->
    <div id="header" class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 wow bounceInLeft">
                    <h1>Responsive Web Design</h1>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing typesetting industry. Lorem Ipsum has been the industry's 
                        standard dummy text ever since the 1500s, when an unknown printer took a gallery of type and scrambled it to make a 
                        type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting.                        
                    </p>                    
                </div>
                <div class="col-lg-6 col-md-6 wow bounceInRight">
                    <img src="assets/img/tutwurihandayani.png" alt="test"/>
                </div>
            </div>
        </div>
    </div>
    <!-- END HEADER -->

    <!-- SERVICES -->
    <div id="conditions" class="conditions">
        <div class="container">
            <h2>Ketentuan Umum</h2>
            <?php

                $sql = "SELECT * FROM ketentuan_umum WHERE thn_pelajaran='".$_SYS_PARAMS[1]."'";
                $stmt = $db->query($sql);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo "<ol type='1' align='left'>";
                foreach($rows as $row){
                    echo "<li>".$row['ketentuan']."</li>";
                }
                echo "</ol>";

            ?>

        </div>
    </div>
    <!-- END SERVICES -->

    <!-- REQUIREMENTS -->
    <div id="requirements" class="requirements">
        <div class="container">
            <div class="row">
                <h2>Persyaratan Calon Peserta Didik Baru</h2>

                <?php
                    $sql = "SELECT * FROM ref_tipe_sekolah";
                    $stmt1 = $db->query($sql);
                    $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                    $cw = 12/count($rows1);
                    $alp = "A";

                    $sql = "SELECT * FROM persyaratan_pendaftaran WHERE thn_pelajaran=:thn_ajaran AND tipe_sklh_id=:tipe_id";
                    $stmt2 = $db->prepare($sql);
                    $params = ['thn_ajaran'=>$_SYS_PARAMS[1]];

                    foreach($rows1 as $row1){

                        $params['tipe_id'] = $row1['ref_tipe_sklh_id'];
                        $stmt2->Execute($params);
                        $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                        echo "
                        <div class='col-lg-".$cw." col-md-".$cw." wow flipInY' data-wow-delay='.8s'>
                            <div class='packages' style='height:300px'>
                                <h4>".$alp.". ".$row1['nama_tipe_sekolah']." (".$row1['akronim'].")</h4><br />
                                <ol type='1' align='left'>";
                                    foreach($rows2 as $row2){
                                        echo "<li>".$row2['persyaratan']."</li>";
                                    }
                                echo "</ol>
                            </div>
                        </div>";

                        $alp++;
                    }
                ?>

                <!-- <div class="col-lg-6 col-md-3 wow flipInY" data-wow-delay=".8s">
                    <div class="packages">
                        <h4>Bronze</h4>
                        <h1>9.99</h1>
                        <b>Monthly</b>
                        <p>Lorem Ipsum passages, and more recently with desktop publishing software</p>
                        <hr>                        
                        <li>100 Users</li>
                        <li>SSL Certificates</li>
                        <li>Online Support</li>
                        <li>300GB Discspace</li>
                        <li>100 Email Address</li>
                        <li>MySQL Database</li>                        
                        <button class="btn btn-success">Get Started</button>
                    </div>
                </div> -->              

                
            </div>
        </div>
    </div>
    <!-- END REQUIREMENTS -->

    <!-- PATH -->
    <div id="path" class="path">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Jalur Penerimaan Peserta Didik Baru Online</h2>
                    <h3>Penerimaan Peserta Didik Baru (PPDB) Online untuk SMAN dan SMKN terdiri dari</h3>
                    <?php
                        $sql = "SELECT a.ref_jalur_id,a.nama_jalur,a.keterangan,b.nama_ktg_jalur FROM ref_jalur_pendaftaran as a
                                LEFT JOIN ref_ktg_jalur_pendaftaran as b ON (a.ktg_jalur_id=b.ktg_jalur_id)";
                        $stmt1 = $db->query($sql);
                        $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

                        $sql = "SELECT * FROM ketentuan_jalur WHERE thn_pelajaran=:thn_ajaran AND jalur_id=:jalur_id ORDER BY ketentuan_id ASC LIMIT 0,1";
                        $stmt2 = $db->prepare($sql);
                        $params = ['thn_ajaran'=>$_SYS_PARAMS[1]];

                        foreach($rows1 as $row1){

                            $params['jalur_id'] = $row1['ref_jalur_id'];
                            $stmt2->Execute($params);
                            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

                            echo "
                            <div class='row'>
                                <div class='col-lg-12'>
                                    <div class='packages'>
                                        <h4>".$row1['nama_jalur']."</h4>
                                        <div class='row'>
                                            <div class='col-lg-6 col-md-6 sub-part'>
                                                <h2>Ketentuan :</h2>
                                                <ol type='1'>
                                                    <li>".$row2['ketentuan']."
                                                    <a href='#'>read more</a>
                                                    </li>
                                                </ol>                                                
                                            </div>

                                            <div class='col-lg-6 col-md-6 sub-part'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                        }
                    ?>
                </div>

            </div>
        </div>
    </div>
    <!-- END PATH -->

    <!-- TEAM -->
    <div id="team" class="team">
        <div class="container">
            <div class="row">
                <h2>Meet Our Team</h2>
                <p>Lorem Ipsum is simply dummy text of the printing typesetting industry.</p>
                <div class="col-lg-3 col-md-3 wow fadeInLeft" data-wow-delay="2s">
                    <img src="assets/img/01.png" class="img-circle" alt="" width="250px"/>
                    <h4>Sheikh Saad</h4>
                    <b>CEO and Founder</b>
                    <p>Lorem Ipsum passages, and more recently with desktop publishing software</p>
                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                </div>
                
                <div class="col-lg-3 col-md-3 wow fadeInLeft" data-wow-delay="1.6s">
                    <img src="assets/img/02.jpg" class="img-circle" alt="" width="250px"/>
                    <h4>As Sudais</h4>
                    <b>CEO and Founder</b>
                    <p>Lorem Ipsum passages, and more recently with desktop publishing software</p>
                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                </div>

                <div class="col-lg-3 col-md-3 wow fadeInLeft" data-wow-delay="1.2s">
                    <img src="assets/img/03.png" class="img-circle" alt="" width="250px"/>
                    <h4>Sheikh Saad</h4>
                    <b>CEO and Founder</b>
                    <p>Lorem Ipsum passages, and more recently with desktop publishing software</p>
                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                </div>

                <div class="col-lg-3 col-md-3 wow fadeInLeft" data-wow-delay=".8s">
                    <img src="assets/img/04.png" class="img-circle" alt="" width="250px"/>
                    <h4>Sheikh Saad</h4>
                    <b>CEO and Founder</b>
                    <p>Lorem Ipsum passages, and more recently with desktop publishing software</p>
                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                    <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                </div>

            </div>
        </div>
    </div>
    <!-- END TEAM -->

    <!-- CONTACT -->
    <div id="contact" class="contact">
        <div class="container">
            <div class="row">
                <h2>Contact</h2>
                <p>Lorem Ipsum passages, and more recently with desktop publishing software</p> 
                <div class="col-lg-6 col-md-6">
                    <div class="input-group input-group-lg wow fadeInUp" data-wow-delay="0.8s">
                        <span class="input-group-addon" id="sizing-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" aria-describedby="sizing-addon1" placeholder="Full Name">
                    </div>

                    <div class="input-group input-group-lg wow fadeInUp" data-wow-delay="1.2s">
                        <span class="input-group-addon" id="sizing-addon2"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" aria-describedby="sizing-addon2" placeholder="Email Address">
                    </div>

                    <div class="input-group input-group-lg wow fadeInUp" data-wow-delay="1.6s">
                        <span class="input-group-addon" id="sizing-addon3"><i class="fa fa-phone" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" aria-describedby="sizing-addon3" placeholder="Phone Number">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="input-group wow fadeInUp" data-wow-delay="2s">
                        <textarea name="" id="" cols="80" rows="6" class="form-control"></textarea>
                    </div>
                    <button class="btn btn-lg wow fadeInUp" data-wow-delay="2.4s">Submit Your Message</button>
                </div>
            </div>
        </div>
    </div>

    <!-- END CONTACT -->

    <!-- FOOTER -->
    <div id="footer" class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <h4>Contact Us</h4>
                    <p><i class="fa fa-home" aria-hidden="true"></i> 111 Main Street, Washington DC, 22222</p>
                    <p><i class="fa fa-envelope" aria-hidden="true"></i> infomedia.com</p>
                    <p><i class="fa fa-phone" aria-hidden="true"></i> 0823 4807 1071</p>
                    <p><i class="fa fa-globe" aria-hidden="true"></i> www.media.com</p>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h4>About</h4>
                    <p><i class="fa fa-square-o" aria-hidden="true"></i> About Us</p>
                    <p><i class="fa fa-square-o" aria-hidden="true"></i> Privacy</p>
                    <p><i class="fa fa-square-o" aria-hidden="true"></i> Term & Condition</p>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h4>Stay in Touch</h4>
                    <i class="social fa fa-facebook" aria-hidden="true"></i>
                    <i class="social fa fa-twitter" aria-hidden="true"></i>
                    <i class="social fa fa-linkedin" aria-hidden="true"></i>
                    <i class="social fa fa-pinterest" aria-hidden="true"></i>
                    <i class="social fa fa-youtube" aria-hidden="true"></i>
                    <i class="social fa fa-github" aria-hidden="true"></i><br />
                    <input type="email" placeholder="sucribe for updates"/>
                    <button type="button" class="btn btn-success">Subscribe</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->    
     <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script type="text/javascript" src="assets/WOW-master/dist/wow.min.js"></script>
     <script type="text/javascript">
        new WOW().init();
     </script>
     <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  </body>
</html>