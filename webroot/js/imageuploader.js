/*--------------------------------------*
 * [jQuery] Show thumbnails for any upload files
 *--------------------------------------*/
$.fn.uploadThumbs = function (option) {
	option = $.extend({
		position  : 0,		// 0:before, 1:after, 2:parent.prepend, 3:parent.append,
							// any: arbitrarily jquery selector
		imgbreak  : false,	// append <br> after thumbnail images
		exclusion : true,	// do exclusion image control
		checkbox  : ':checkbox, label, .checked_images',	// selector to find checkbox for exclusion image control
		alternate : '.alt',	// selecter for alternate view input file names
	}, option || {});

	this.change(function () {$.fn.uploadThumbs.run.call(this, option) });

	this.each(function () {
		var $self = $(this);
	});
	return this;
};

// preview thumbnail images
$.fn.uploadThumbs.run = function (option) {
	var $self = $(this);

	// Checking HTML5 ? (File API exist?)
	if (window.File && window.FileReader && this.files) {

		for (var i = 0, I = this.files.length; i < I; i++) { // multiple
			var file  = this.files[i];
			if (file && (file.type && file.type.match(/^image/)		// Checking image ?
			         || !file.type && file.name.match(/\.(jp[eg]+|png|gif|bmp)$/i) && $.browser.msie)) {

				var reader = new FileReader();
				reader.onload = function (file, i) { return function () {
					// tmp画像挿入


					// (add)ajax
					var fd = new FormData();
					fd.append('image', file);
					fd.append('message_id', message_id);
					console.log(file);
			        $.ajax({
			            url: '/birthday/images/add',
			            type: 'POST',
			            data: fd,
			            processData: false,
			            contentType: false,
			            dataType: 'json'
			        })
			        .done(function(data) {
								var outertag = $('<a>');
								outertag.attr('href', '/birthday/images/show/' + data);
								var innertag = $('<img>').attr('src', '/birthday/images/show/' + data + '/1');
								innertag.css('margin-right', '4px');
								outertag.append(innertag);
								outertag.hide();
								//outertag.hide();
								$('#addimage').fadeOut(200,function(){
									$('#addimage').before(outertag);
									outertag.fadeIn(1000);
									$('#addimage').fadeIn();
								});
			      	});
				}}(file, i);
				reader.readAsDataURL(file);	// read image data


			}
		}
	}
	// legacy IE
	else {
		var file = this.value;
		if (file && !file.match('fakepath') && file.match(/\.(jp[eg]+|png|gif|bmp)$/i)) {
			var img = new Image();
			img.src = file;
			img.onload = function () {
				var filename = this.src.match(/([^\\\/]+)$/) ? RegExp.$1 : '';
				var tag = '<img src="'+ this.src +'" alt="'+ filename +'" title="'+ this.src +'" class="legacy thumb" />';

				// set thumbnail images
				$.fn.uploadThumbs.set.call($self, option, tag);
			};
			if (img.complete) img.onload();
		}

		// file names
		var alt = (!file) ? null : file.match(/([^\\\/]+)$/) ? RegExp.$1 : file;

		// exclusion control
		$.fn.uploadThumbs.exclusion.call($self, option, alt);
	}
};

// set thumbnail images
$.fn.uploadThumbs.set = function (option, tag) {
	var in_label = this.parent('label').length;
	var tag_br = (option.imgbreak) ? "<br />\n" : "\n";
	var $tag = (option.position == 1 || option.position == 3) ? $(tag_br + tag) :
																$(tag + tag_br);
	// append
	(option.position == 0) ? this.before($tag) :
	(option.position == 1) ? this. after($tag) :
	(option.position == 2) ? this.parent().prepend($tag) :
	(option.position == 3) ? this.parent(). append($tag) :
	                         $(option.position).append($tag).show();

	// as trigger in label ?
	if (in_label) {
		var $self = $(this);
		$tag.click(function (e) {
			$self.click();
			return false;
		});
	}
};

$(function() {
	$('#file').uploadThumbs({
		position : 0,      // 0:before, 1:after, 2:parent.prepend, 3:parent.append,
							   // any: arbitrarily jquery selector
		imgbreak : true    // append <br> after thumbnail images
	});

	$('#addimage').click(function() {
		$('#file').click();
	});
});
