<style type="text/css">
	#map{
		height:500px!important;
		width:100%;
		border;1px solid #cccccc;
	}
	.controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      .pac-container {
        font-family: Roboto;
      }

      #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
      }

      #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      #target {
        width: 345px;
      }
</style>
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
									
									<input id="pac-input" class="controls" type="text" placeholder="Search Box">
									<div id="map"></div><br />

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


<script src="https://maps.googleapis.com/maps/api/js?key=<?=$api_key;?>&libraries=geometry,places" defer></script>

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
		var latitude = -5.147665, longitude = 119.432732, slatitude = $('#school_latitude').val(), slongitude = $('#school_longitude').val();

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
				mapTypeId:'roadmap',
				gestureHandling: 'cooperative'
			});

			//create the search box and link it to the UI element
			var input = document.getElementById('pac-input');
	        var searchBox = new google.maps.places.SearchBox(input);
	        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

			//Bias the SearchBox results towards current map's viewport
			map.addListener('bounds_changed',function(){
				searchBox.setBounds(map.getBounds());
			});

			marker = new google.maps.Marker({
				position:schoolLatLang,
				map:map,
				title:$('#school_name').val(),
				draggable:true,
			});


			 // Listen for the event fired when the user selects a prediction and retrieve
        	// more details for that place.
			searchBox.addListener('places_changed',function(){
				var places = searchBox.getPlaces();

				if(places.length == 0){
					return;
				}				
		       

		        // For each place, get the icon, name and location.
		        var bounds = new google.maps.LatLngBounds();

		        var i = 0;

		        places.forEach(function(place){
		        	if(!place.geometry){
		        		console.log("Returned place contains no geometry");
		        		return;
		        	}		        	

		        	map.setCenter(place.geometry.location);
		        	marker.setPosition(place.geometry.location);
		        	marker.setMap(map)
		        	
		        	$('#input_koordinat').val(place.geometry.location.lat()+', '+place.geometry.location.lng());

		        	if(place.geometry.viewport){
		        		//only geocodes have viewport
		        		bounds.union(place.geometry.viewport);
		        	}else{
		        		bounds.extend(place.geometry.location);
		        	}

		        });
		        map.fitBounds(bounds);
			});

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