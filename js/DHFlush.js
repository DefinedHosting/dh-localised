jQuery('#posts-filter').after('<style>.btn-flush{margin-top:5px; float:right; margin-left:10px;}.btn-flush:hover{cursor:pointer;}</style>');
var listClass = jQuery('input[name="post_type"]').first().val();
jQuery('.row-actions').each(function(){
	var tr = jQuery(this).closest('tr');
	//console.log(tr);
	if(!tr.hasClass('level-0') && listClass == 'landing_page'){
		//console.log(tr.attr('id'));
		var p_id = tr.attr('id').replace('post-','');
		//console.log(p_id);
		jQuery(this).after('<button href="#" class="btn-flush" style="display:none;" title="Delete All LP\'s with same title" data-dh-clear-lp data-pid="'+p_id+'">Delete all LP\'s with same title</button> <button href="#" class="btn-flush" style="display:none;" title="Flush through and publish" data-dh-flush data-pid="'+p_id+'">Flush Through Holders and Publish</button>');
	}
});
jQuery('div[data-colname="Title"]').on('mouseover',function(){
});

jQuery( 'td[data-colname="Title"]').hover(
	function() {
		var button = jQuery(this).find('button.btn-flush');
		button.show();		
	},function() {
		var button = jQuery(this).find('button.btn-flush');
		button.hide();
	}
);


jQuery('button[data-dh-clear-lp]').on('click',function(event){
event.preventDefault();
var pid = jQuery(this).data('pid');
	jQuery.ajax({ url: '../wp-content/plugins/dh-localised/admin/DHFlush.php',
		data: {action: 'clearpages',post_id: pid},
		type: 'post',
		beforeSend: function(){
			jQuery('#output').append('<p>Starting</p>');
   		},
		success: function() {
			jQuery('#output').append('<p>done</p>');
			location.reload();
		},
		fail: function(){
			jQuery('#output').append('<p>no post to delete found</p>');
			alert('failed');
		}
	});
	return false;
});

jQuery('button[data-dh-flush]').on('click',function(event){
	event.preventDefault();
	var pid = jQuery(this).data('pid');
	jQuery.ajax({ url: '../wp-content/plugins/dh-localised/admin/DHFlush.php',
		data: {action: 'prep',post_id: pid},
		type: 'post',
		beforeSend: function(){
			jQuery('#output').append('<p>Starting</p>');
   		},
		success: function() {
			jQuery('#output').append('<p>Posts Deleted</p>');
			create(pid);
		},
		fail: function(){
			jQuery('#output').append('<p>no other post in holders found</p>');
//			create(pid);
			alert('failed');
		}
	});
	return false;
});
function create(pid){
	jQuery.ajax({ url: '../wp-content/plugins/dh-localised/admin/DHFlush.php',
		data: {action: 'create',post_id: pid},
		type: 'post',
		beforeSend: function(){
			jQuery('#output').append('<p>Starting Prep</p>');
   		},
		success: function() {
			jQuery('#output').append('<p>MySQL Prepped</p>');
			importSQL(pid);
		},
		fail: function(){
			jQuery('#output').append('<p>couldn\'t export data</p>');
		}
	});
}
function importSQL(pid){
	jQuery.ajax({ url: '../wp-content/plugins/dh-localised/admin/DHFlush.php',
		data: {action: 'import',post_id: pid},
		type: 'post',
		beforeSend: function(){
			//jQuery('#output').append('<p>Beginnning Import</p>');
   		},
		success: function(output) {
			//jQuery('#output').append('<p>MySQL Imported</p>');
		},
		fail: function(){
			//jQuery('#output').append('<p>couldn\'t import data for post: '+pid+'</p>');
		},
		complete: function(){
			//jQuery('#output').append('<p>done!</p>');
			location.reload();
		}
	});
}
