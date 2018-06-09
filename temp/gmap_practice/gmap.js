$(function(){
	
	var map,marker1;
	var mapDiv = document.getElementById('map');
	var myLatLng = new google.maps.LatLng(-5.1840287,119.4567516);
	function initMap(){
		map = new google.maps.Map(mapDiv,{
			center:myLatLng,
			zoom:15,
			zoomControl:false,
			streetViewControl:false,
			scrollwheel:true,
			mapTypeId:google.maps.MapTypeId.ROADMAP
		});
		marker1 = new google.maps.Marker({
			position:myLatLng,
			map:map,
			title:'Hello World',
			draggable:true
		});

	};
	
	initMap();
});

