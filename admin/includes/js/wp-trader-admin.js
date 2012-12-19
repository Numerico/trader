$(document).bind("mobileinit", function(){
	$.extend(  $.mobile , {
		ajaxEnabled: false,
		linkBindingEnabled: false
	});
});
$(document).bind('updatelayout',function() { 
	$('textarea').keyup(); 
});
$(document).delegate('#simpleraw', 'click', function(event) {
	var dialogName = $(this).attr('name');
	var wp_trader_dialog = $("[id^='" + dialogName + "']").html();
    $(this).simpledialog({
        'mode' : 'blank',
        'prompt': false,
		'cleanOnClose': true,
        'forceInput': false,
        'fullScreen': true,
        'fullHTML' : wp_trader_dialog + "<a rel='close' data-role='button' href='#' id='simpleclose'>Close</a>",
    })
	event.preventDefault();
	var tPosY = event.pageY - 100;
	$('html, body').animate({ scrollTop: $(".ui-simpledialog-container").offset({ top: tPosY }).top }, 500);
	$("#simpleclose").click(function(d) {
		d.preventDefault();
	});
});
$(function() {
	$( "[id^='sortable1_'], [id^='sortable2_']" ).sortable({
		connectWith: "[class^='connectedSortable_']",
		placeholder: "ui-state-highlight",
		update : function () {
			var thisId = $(this).attr('id');
			var serial = $(this).sortable("toArray");
			for(i=0; i<serial.length; i++) {
				var serialUpdate = serial;
				var divUpdate = serialUpdate.join(',')
			}
			var thisName = $(this).attr('name');
			$("input[id^='" + thisName + "']").val(divUpdate);
		}
	}).disableSelection();
});