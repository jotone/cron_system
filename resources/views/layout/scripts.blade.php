<!-- SCRIPTS -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- build:js scripts/validate_script.js -->
<script type="text/javascript" src="{{ URL::asset('js/validate_script.js') }}"></script>
<!-- endbuild -->

<!-- build:js scripts/plagins.js -->
<script type="text/javascript" src="{{ URL::asset('js/plagins/device.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/plagins/jquery.fancybox.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/plagins/jquery.formstyler.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/plagins/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/plagins/maskInput.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/plagins/slick.js') }}"></script>
<!-- add you plagins js here -->
<script type="text/javascript" src="{{ URL::asset('js/plagins/jquery.jscrollpane.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/plagins/jquery.mousewheel.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCP6kzRzQA2exVf1tN-EudPZcTZVsgadi0"></script>
<script src="https://cdn.mapkit.io/v1/infobox.js"></script>

<!-- endbuild -->

<!-- build:js scripts/main.js -->
<script type="text/javascript" src="{{ URL::asset('js/basic_scripts.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/develop/develop_1.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/develop/develop_2.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/develop/develop_4.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/develop/develop_5.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/develop/develop_6.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/develop/develop_7.js') }}"></script>
<!-- add you develop js here -->
@if( (isset($allow_map)) && ($allow_map) )
<script>
	var removing_from_busket = "ajax.php";
	var show_more = "ajax.php";
	var mapMarker = "../images/marker-map.png";
	var coordinateMarkerY = 59.9364148;
	var coordinateMarkerX = 30.32613850000007;
	var mapCenterY = 59.936994264526696;
	var mapCenterX = 30.3297175429077;

	google.maps.event.addDomListener(window, 'load', init);
	var map, markersArray = [];

	function bindInfoWindow(marker, map, location) {
		google.maps.event.addListener(marker, 'click', function() {
			function close(location) {
				location.ib.close();
				location.infoWindowVisible = false;
				location.ib = null;
			}

			if (location.infoWindowVisible === true) {
				close(location);
			} else {
				markersArray.forEach(function(loc, index){
					if (loc.ib && loc.ib !== null) {
						close(loc);
					}
				});

				var boxText = document.createElement('div');
				boxText.style.cssText = 'background: #fff;';
				boxText.classList.add('md-whiteframe-2dp');

				function buildPieces(location, el, part, icon) {
					if (location[part] === '') {
						return '';
					} else if (location.iw[part]) {
						switch(el){
							case 'photo':
								if (location.photo){
									return '<div class="iw-photo" style="background-image: url(' + location.photo + ');"></div>';
								} else {
									return '';
								}
								break;
							case 'iw-toolbar':
								return '<div class="iw-toolbar"><h3 class="md-subhead">' + location.title + '</h3></div>';
								break;
							case 'div':
								switch(part){
									case 'email':
										return '<div class="iw-details"><i class="material-icons" style="color:#4285f4;"><img src="//cdn.mapkit.io/v1/icons/' + icon + '.svg"/></i><span><a href="mailto:' + location.email + '" target="_blank">' + location.email + '</a></span></div>';
										break;
									case 'web':
										return '<div class="iw-details"><i class="material-icons" style="color:#4285f4;"><img src="//cdn.mapkit.io/v1/icons/' + icon + '.svg"/></i><span><a href="' + location.web + '" target="_blank">' + location.web_formatted + '</a></span></div>';
										break;
									case 'desc':
										return '<label class="iw-desc" for="cb_details"><input type="checkbox" id="cb_details"/><h3 class="iw-x-details">Details</h3><i class="material-icons toggle-open-details"><img src="//cdn.mapkit.io/v1/icons/' + icon + '.svg"/></i><p class="iw-x-details">' + location.desc + '</p></label>';
										break;
									default:
										return '<div class="iw-details"><i class="material-icons"><img src="//cdn.mapkit.io/v1/icons/' + icon + '.svg"/></i><span>' + location[part] + '</span></div>';
										break;
								}
								break;
							case 'open_hours':
								var items = '';
								if (location.open_hours.length > 0){
									for (var i = 0; i < location.open_hours.length; ++i) {
										if (i !== 0){
											items += '<li><strong>' + location.open_hours[i].day + '</strong><strong>' + location.open_hours[i].hours +'</strong></li>';
										}
										var first = '<li><label for="cb_hours"><input type="checkbox" id="cb_hours"/><strong>' + location.open_hours[0].day + '</strong><strong>' + location.open_hours[0].hours +'</strong><i class="material-icons toggle-open-hours"><img src="//cdn.mapkit.io/v1/icons/keyboard_arrow_down.svg"/></i><ul>' + items + '</ul></label></li>';
									}
									return '<div class="iw-list"><i class="material-icons first-material-icons" style="color:#4285f4;"><img src="//cdn.mapkit.io/v1/icons/' + icon + '.svg"/></i><ul>' + first + '</ul></div>';
								} else {
									return '';
								}
								break;
						}
					} else {
						return '';
					}
				}

				boxText.innerHTML =
					buildPieces(location, 'photo', 'photo', '') +
					buildPieces(location, 'iw-toolbar', 'title', '') +
					buildPieces(location, 'div', 'address', 'location_on') +
					buildPieces(location, 'div', 'web', 'public') +
					buildPieces(location, 'div', 'email', 'email') +
					buildPieces(location, 'div', 'tel', 'phone') +
					buildPieces(location, 'div', 'int_tel', 'phone') +
					buildPieces(location, 'open_hours', 'open_hours', 'access_time') +
					buildPieces(location, 'div', 'desc', 'keyboard_arrow_down');

				var myOptions = {
					alignBottom: true,
					content: boxText,
					disableAutoPan: true,
					maxWidth: 0,
					pixelOffset: new google.maps.Size(-140, -40),
					zIndex: null,
					boxStyle: {
						opacity: 1,
						width: '280px'
					},
					closeBoxMargin: '0px 0px 0px 0px',
					infoBoxClearance: new google.maps.Size(1, 1),
					isHidden: false,
					pane: 'floatPane',
					enableEventPropagation: false
				};

				location.ib = new InfoBox(myOptions);
				location.ib.open(map, marker);
				location.infoWindowVisible = true;
			}
		});
	}

	function init() {
		var mapOptions = {
			center: new google.maps.LatLng(mapCenterY,mapCenterX),
			zoom: 16,
			gestureHandling: 'auto',
			fullscreenControl: false,
			zoomControl: true,
			disableDoubleClickZoom: true,
			mapTypeControl: false,
			scaleControl: false,
			scrollwheel: false,
			streetViewControl: false,
			draggable : true,
			clickableIcons: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.government","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.school","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry.fill","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#a0abb0"},{"visibility":"on"}]}]
		}
		var mapElement = document.getElementById('myMap');
		var map = new google.maps.Map(mapElement, mapOptions);
		var locations = [
			{"title":"наб. канала Грибоедова, 17","address":"наб. канала Грибоедова, 17, Санкт-Петербург, Россия, 191186","desc":"","tel":"","int_tel":"","email":"","web":"","web_formatted":"","open":"","time":"","lat":coordinateMarkerY,"lng":coordinateMarkerX,"vicinity":"наб. канала Грибоедова, 17, Санкт-Петербург, Россия, 191186","open_hours":"","marker":{"url":mapMarker,"scaledSize":{"width":55,"height":76,"j":"px","f":"px"},"origin":{"x":0,"y":0},"anchor":{"x":12,"y":42}},"iw":{"address":true,"desc":true,"email":true,"enable":true,"int_tel":true,"open":true,"open_hours":true,"photo":true,"tel":true,"title":true,"web":true}}
		];

		var layer = new google.maps.TransitLayer();
		layer.setMap(map);

		for (i = 0; i < locations.length; i++) {
			marker = new google.maps.Marker({
				icon: locations[i].marker,
				position: new google.maps.LatLng(locations[i].lat, locations[i].lng),
				map: map,
				title: locations[i].title,
				address: locations[i].address,
				desc: locations[i].desc,
				tel: locations[i].tel,
				int_tel: locations[i].int_tel,
				vicinity: locations[i].vicinity,
				open: locations[i].open,
				open_hours: locations[i].open_hours,
				photo: locations[i].photo,
				time: locations[i].time,
				email: locations[i].email,
				web: locations[i].web,
				iw: locations[i].iw
			});
			markersArray.push(marker);

			if (locations[i].iw.enable === true){
				bindInfoWindow(marker, map, locations[i]);
			}
		}
	}
</script>
@endif

<!-- endbuild -->

<!-- /SCRIPTS -->
</body>
</html>