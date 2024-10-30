jQuery(document).ready(function($){
	$(".db_slider input").mousemove(function() {
		 var slider_preview = $(this).parent().parent().children("th").children(".slider_preview");
         slider_preview.text(Math.round(this.value));
	});
    $('.ctcocb-color-field').wpColorPicker();
});


