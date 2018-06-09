$(function(){
	'user strick';

	var map,marker1,marker2,ruler1label,ruler2label;
	var mapDiv = document.getElementById('map');
	var schoolLatLang = new google.maps.LatLng($('#school_latitide').val(),$('#school_longitude').val());
	
	function initMap(){

		map = new google.maps.Map(mapDiv,{
			center:schoolLatLang,
			zoom:15,
			zoomControl:true,
			streetViewControl:true,
			scrollwheel:true,
			mapTypeId:google.maps.MapTypeId.ROADMAP,
			mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},

		});			

	};		

	/*
		javascript ruler for google maps V3

		by Giulio Pons. http://www.barattalo.it
		this function uses the label class from Marc Ridley Blog

	*/

	function addruler() {

		var ruler1 = marker1;
		var ruler2 = marker2;

		ruler1label = new Label({ map: map });
		ruler2label = new Label({ map: map });

		ruler1label.bindTo('position', ruler1, 'position');
		ruler2label.bindTo('position', ruler2, 'position');

		var rulerpoly = new google.maps.Polyline({
			path: [ruler1.position, ruler2.position] ,
			strokeColor: "#FFFF00",
			strokeOpacity: .7,
			strokeWeight: 7
		});

		rulerpoly.setMap(map);
		
		_distance = distance( ruler1.getPosition().lat(), ruler1.getPosition().lng(), ruler2.getPosition().lat(), ruler2.getPosition().lng());
		_distance = number_format(_distance,0,'.',',')+' m';		
		set_distanceCalculation(_distance)

		google.maps.event.addListener(ruler1, 'drag', function() {
			rulerpoly.setPath([ruler1.getPosition(), ruler2.getPosition()]);

			_distance = distance( ruler1.getPosition().lat(), ruler1.getPosition().lng(), ruler2.getPosition().lat(), ruler2.getPosition().lng());
			_distance = number_format(_distance,0,'.',',')+' m';
			set_distanceCalculation(_distance);
		});

		google.maps.event.addListener(ruler2, 'drag', function() {
			rulerpoly.setPath([ruler1.getPosition(), ruler2.getPosition()]);

			_distance = distance( ruler1.getPosition().lat(), ruler1.getPosition().lng(), ruler2.getPosition().lat(), ruler2.getPosition().lng());
			_distance = number_format(_distance,0,'.',',')+' m';
			set_distanceCalculation(_distance);
		});
	}

	function set_distanceCalculation(distance){
		document.getElementById('distance').value = distance;
		ruler1label.set('text',distance);
		ruler2label.set('text',distance);
	}


	function distance(lat1,lon1,lat2,lon2) {
		var R = 6371; // km (change this constant to get miles)
		var dLat = (lat2-lat1) * Math.PI / 180;
		var dLon = (lon2-lon1) * Math.PI / 180; 
		var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
			Math.cos(lat1 * Math.PI / 180 ) * Math.cos(lat2 * Math.PI / 180 ) * 
			Math.sin(dLon/2) * Math.sin(dLon/2); 
		var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
		var d = R * c;		

		return Math.round(d*1000);
		
	}

	// Define the overlay, derived from google.maps.OverlayView
	function Label(opt_options) {
		// Initialization
		this.setValues(opt_options);

		// Label specific
		var span = this.span_ = document.createElement('span');
		span.style.cssText = 'position: relative; left: 0%; top: -8px; ' +
				  'white-space: nowrap; border: 0px; font-family:arial; font-weight:bold;' +
				  'padding: 2px; background-color: #ddd; '+
					'opacity: .75; '+
					'filter: alpha(opacity=75); '+
					'-ms-filter: "alpha(opacity=75)"; '+
					'-khtml-opacity: .75; '+
					'-moz-opacity: .75;';

		var div = this.div_ = document.createElement('div');
		div.appendChild(span);
		div.style.cssText = 'position: absolute; display: none';
	};
	Label.prototype = new google.maps.OverlayView;

	// Implement onAdd
	Label.prototype.onAdd = function() {
		var pane = this.getPanes().overlayLayer;
		pane.appendChild(this.div_);

		
		// Ensures the label is redrawn if the text or position is changed.
		var me = this;
		this.listeners_ = [
			google.maps.event.addListener(this, 'position_changed',
			function() { me.draw(); }),
			google.maps.event.addListener(this, 'text_changed',
			function() { me.draw(); })
		];
		
	};

	// Implement onRemove
	Label.prototype.onRemove = function() { this.div_.parentNode.removeChild(this.div_ );
		// Label is removed from the map, stop updating its position/text.
		for (var i = 0, I = this.listeners_.length; i < I; ++i) {
			google.maps.event.removeListener(this.listeners_[i]);
		}
	};

	// Implement draw
	Label.prototype.draw = function() {
		var projection = this.getProjection();
		var position = projection.fromLatLngToDivPixel(this.get('position'));

		var div = this.div_;
		div.style.left = position.x + 'px';
		div.style.top = position.y + 'px';
		div.style.display = 'block';

		this.span_.innerHTML = this.get('text').toString();
	};





	// processing the results
	function changeMapLocation(locations) {
		if(locations && locations.length) {

			marker1 = new google.maps.Marker({
				position: map.getCenter() ,
				map: map,
				draggable: false
			});

			marker2 = new google.maps.Marker({
				map: map,
				position: locations[0].location,
				title:'Alamat Calon Siswa',
				draggable:true,
			});
			
			map.panTo(locations[0].location);
			map.setZoom(15);
		} 
		else 
		{
			marker1 = new google.maps.Marker({
				position: map.getCenter(),
				map:map,
				draggable:true
			});

			marker2 = new google.maps.Marker({
				position: map.getCenter(),
				map:map,
				draggable:true
			});
			
		}

		addruler();
	}

	// converting the address's string to a google.maps.LatLng object
	function addressToLocation(address, callback) {

		var geocoder = new google.maps.Geocoder();
		geocoder.geocode(
			{
				address: address
			}, 
			function(results, status) {
				
				var resultLocations = [];
				
				if(status == google.maps.GeocoderStatus.OK) {
					if(results) {
						var numOfResults = results.length;
						for(var i=0; i<numOfResults; i++) {
							var result = results[i];
							resultLocations.push(
								{
									text:result.formatted_address,
									addressStr:result.formatted_address,
									location:result.geometry.location
								}
							);
						};
					}
				} 
				else if(status == google.maps.GeocoderStatus.ZERO_RESULTS) {
					// address not found
				}
				
				if(resultLocations.length > 0) {
					callback(resultLocations);
				} else {
					callback(null);
				}
			}
		);
	}

	// adding events
	$("#startDistanceCalculation").on('click',function(){
		$(this).attr('disabled',true);
		var address = $("#reg_address").val();		
		addressToLocation(address, changeMapLocation);		
	})

	initMap();
});