<!-- MAIN PANEL -->
<div id="main" role="main">

  <!-- RIBBON -->
  <div id="ribbon">
    <span class="ribbon-button-alignment"> 
      <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
        <i class="fa fa-refresh"></i>
      </span> 
    </span>
    <!-- breadcrumb -->
    <ol class="breadcrumb">
      <li>Home</li><li>Pengaturan</li><li>Koordinat Sekolah</li>
    </ol>   

  </div>
  <!-- END RIBBON -->

  <!-- MAIN CONTENT -->
  <div id="content">

    <div class="row">
      <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
        <h1 class="page-title txt-color-blueDark">    
          <!-- PAGE HEADER -->
          <i class="fa-fw fa fa-pencil-square-o"></i> 
            Pengaturan
          <span>>  
            Koordinat Sekolah
          </span>
        </h1>
      </div>  
    </div>

    
    <!-- widget grid -->
    <section id="widget-grid" class="">

      <!-- row -->
      <div class="row">

        <!-- NEW WIDGET START -->
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          
          <div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-3" data-widget-editbutton="false">           
            
            <header>
              <span class="widget-icon"> <i class="fa fa-gear"></i> </span>
              <h2>Pengaturan Koordinat/Lokasi Sekolah</h2>
            </header>

            <!-- widget div-->
            <div>

              <!-- widget edit box -->
              <div class="jarviswidget-editbox">
                <!-- This area used as dropdown edit box -->

              </div>
              <!-- end widget edit box -->

              <!-- widget content -->
              <div class="widget-body">

                <form class="form-horizontal" id="<?=$form_id;?>" action="<?=base_url().$active_controller;?>/set_school_latlang" method="POST">
                  <input type="hidden" id="school_latitude" value="<?=$this->session->userdata('latitude');?>"/>
                  <input type="hidden" id="school_longitude" value="<?=$this->session->userdata('longitude');?>"/>
                  <input type="hidden" id="school_name" value="<?=$this->session->userdata('nama_sekolah');?>"/>
                  <div id="map" style="height:500px!important;width:100%;border;1px solid #cccccc;"></div><br />

                  <div class="row">
                    <div class="col-md-12">
                      
                      <div class="form-group">
                        <label class="control-label col-md-3" for="input_koordinat">Koordinat</label>
                        <div class="col-md-8">
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="input">
                                <input class="form-control" type="text" name="input_koordinat" id="input_koordinat" value="<?=$sekolah_row['latitude'].', '.$sekolah_row['longitude'];?>" placeholder="Koordinat Sekolah" readonly/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3" for="input_alamat">Alamat Sekolah <font color="red">*</font></label>
                        <div class="col-md-8">
                          <div class="row">
                            <div class="col-sm-12">
                              <div class="input">
                                <input class="form-control" type="text" name="input_alamat" id="input_alamat" value="<?=$sekolah_row['alamat'];?>" required/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>


                    </div>
                  </div>

                  <div class="modal-footer" align="center">
                    <button type="submit" class="btn btn-primary">
                      Simpan
                    </button>                   
                  </div>
                </form>

              </div>
              <!-- end widget content -->

            </div>
            <!-- end widget div -->

          </div>
          <!-- end widget -->

        </article>
        <!-- WIDGET END -->       

      </div>

      <!-- end row -->      

    </section>
    <!-- end widget grid -->    

  </div>
  <!-- END MAIN CONTENT -->

</div>
<!-- END MAIN PANEL -->


<script src="https://maps.googleapis.com/maps/api/js?key=<?=$api_key;?>&libraries=geometry" defer></script>

<script type="text/javascript"> 
  var school_latLang_form_id = '<?=$form_id;?>';
    var $school_latLang_form=$('#'+school_latLang_form_id);
    var school_latLang_stat=$school_latLang_form.validate({
        // Do not change code below
                errorPlacement : function(error, element) {
                    error.addClass('error');
                    error.insertAfter(element.parent());
                }
      });

    $school_latLang_form.submit(function(){
        if(school_latLang_stat.checkForm())
        {         
          ajax_object.reset_object();
            ajax_object.set_content('#')                           
                           .set_loading('#preloadAnimation')
                           .enable_pnotify()
                           .set_form($school_latLang_form)
                           .submit_ajax('menyimpan data');
            return false;
        }

    });


    $(function(){
    'user strick';    

    var map,marker;
    var mapDiv = document.getElementById('map');
    var status = 'notset';
    var latitude = -4.651534, longitude = 120.023773, slatitude = $('#school_latitude').val(), slongitude = $('#school_longitude').val();

    
    if(parseFloat(slatitude)!=0 && parseFloat(slongitude)!=0)
    {
      latitude = slatitude;
      longitude = slongitude;
      status = 'set';
    }

    var schoolLatLang = new google.maps.LatLng(latitude,longitude);
    
    function initMap(){

      map = new google.maps.Map(mapDiv,{
        center:schoolLatLang,
        zoom:(status=='set'?15:12),
        zoomControl:true,
        streetViewControl:true,
        scrollwheel:true
      });

      marker = new google.maps.Marker({
        position:schoolLatLang,
        map:map,
        title:$('#school_name').val(),
        draggable:true,
      });

      if(status=='notset'){

        var infoWindow = new google.maps.InfoWindow({map: map});

        if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {
                var schoolLatLang = {
                  lat: position.coords.latitude,
                  lng: position.coords.longitude
                };                

                infoWindow.setPosition(schoolLatLang);
                infoWindow.setContent('Found your location.');

                map.setCenter(schoolLatLang);
                marker.setPosition(schoolLatLang);
                marker.setMap(map);

                $('#input_koordinat').val(position.coords.latitude+', '+position.coords.longitude);

              }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
              });
            } else {
              // Browser doesn't support Geolocation
              handleLocationError(false, infoWindow, map.getCenter());
            }
        }

      marker.addListener('drag',function(){
        $('#input_koordinat').val(marker.getPosition().lat()+', '+marker.getPosition().lng());
      })

    };

    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
          infoWindow.setPosition(pos);
          infoWindow.setContent(browserHasGeolocation ?
                                'Error: The Geolocation service failed.' :
                                'Error: Your browser doesn\'t support geolocation.');
        }

    initMap();
  });

</script>