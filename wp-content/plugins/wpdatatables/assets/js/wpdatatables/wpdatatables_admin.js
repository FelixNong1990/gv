/**
 * Common JS scripts for wpDataTables admin panel
 */
function wdtAlertDialog(str, title){
        	var alert_dialog_str = '<div class="remodal wpDataTables wdtRemodal"><h1>'+title+'</h1>';
        	alert_dialog_str += '<p>'+str+'</p>';
        	alert_dialog_str += '<button class="remodal-confirm btn" href="#">OK</button></div>';
        	jQuery(alert_dialog_str).remodal({
        		type: 'inline',
        		preloader: false,
        		modal: true
        	}).open();
            return;
}

function applySelecter(){
	jQuery('select').selecter('destroy');
	jQuery('select').selecter();
}