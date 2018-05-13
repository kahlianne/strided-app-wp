(function( $ ) {
	'use strict';

	$(document).ready( function() {

		function getParameterByName(name, url) {
			if (!url) url = window.location.href;
			name = name.replace(/[\[\]]/g, "\\$&");
			var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
			results = regex.exec(url);
			if (!results) return null;
			if (!results[2]) return '';
			return decodeURIComponent(results[2].replace(/\+/g, " "));
		}

		var horse = getParameterByName('horse-name');
		var arena = getParameterByName('arena-name');

		setTimeout(function(){
			$(".arena-select").val(arena);
			$(".horse-select").val(horse);
		}, 1000);

	})

})( jQuery );
