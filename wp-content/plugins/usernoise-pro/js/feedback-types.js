jQuery(function($){
	$('#icon').chosen({template: function(text, templateData){console.info(templateData); return "<i class='" + templateData.icon + "'></i>" + text;}});
});