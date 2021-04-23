jQuery(document).ready(function($){
console.log(dh_events_script_vars.entrypage);
	$('a[href^="tel:"]').on('click', function(){
    console.log('clicked');
    $.ajax({
      url : dh_events_script_vars.ajaxurl,
      type : 'post',
      data : {
          action : 'dh_event',
          domain : window.location.host,
          url : window.location.pathname,
          subject: $(this).attr('href').replace('tel:',''),
          type: 'Phone Call',
					entrypage:dh_events_script_vars.entrypage
        }
	    });
  });
	$('a[href^="mailto:"]').on('click', function(){
    console.log('clicked');
    $.ajax({
      url : dh_events_script_vars.ajaxurl,
      type : 'post',
      data : {
          action : 'dh_event',
          domain : window.location.host,
          url : window.location.pathname,
          subject: 'Email link clicked',
          type: 'Email',
					entrypage:dh_events_script_vars.entrypage
        }
	   });
  });
	$('form').on('submit', function(){
		console.log('well were here');
		var formSubject = '';

		// woo-commerce
		if($(this).hasClass('woocommerce-checkout')){
				formSubject = 'Order Placed';
		}else{
			var subjectField = $('*.subject-field');
			if(subjectField.length > 0){
				if(subjectField.find('input').length > 0){
					formSubject = subjectField.find('input').first().val();
				}
				if(subjectField.find('select').length > 0){
					formSubject = subjectField.find('select').first().val();
				}
			}else{
				formSubject = $(this).find('select').first().val();
			}
		}

    $.ajax({
      url : dh_events_script_vars.ajaxurl,
      type : 'post',
      data : {
          action : 'dh_event',
          domain : window.location.host,
          url : window.location.pathname,
          subject: formSubject,
          type: 'Form Submission',
					entrypage:dh_events_script_vars.entrypage
        }
	   });
		 console.log('maybe not here');
  });
});
