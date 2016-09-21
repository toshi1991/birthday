/*--------------------------------------*
 * [jQuery] Show thumbnails for any upload files
 *--------------------------------------*/
$.fn.uploadVideos = function () {
	this.change(function () {$.fn.uploadVideos.run.call(this);});

	this.each(function () {
		var $self = $(this);
	});
	return this;
};

// preview thumbnail images
$.fn.uploadVideos.run = function () {
	var $self = $(this);
	
	// Checking HTML5 ? (File API exist?)
	if (window.File && window.FileReader && this.files) {		
				
		for (var i = 0, I = this.files.length; i < I; i++) { // multiple
			var file  = this.files[i];
			console.log(file);
			
			if (file && (file.type && file.type.match(/^video*/)		// Checking image ?
			         || /* !file.type && file.name.match(/\.(jp[eg]+|png|gif|bmp)$/i) && */ $.browser.msie)) {
					 
				
				var reader = new FileReader();
				reader.onload = function (file, i) { return function () {
					
				var fd = new FormData();
				fd.append('video', file);
				fd.append('message_id', message_id);
		        $.ajax({
		            url: '/birthday/movies/add',
		            type: 'POST',
		            data: fd,
		            processData: false,
		            contentType: false,
		            dataType: 'json'
		        }).done(function(data) {
					// append
					var tag = '<video poster="/birthday/img/novideo.jpg"><soucer src="/birthday/videos/' + data['filename'] + '"></video>';// alt="'+ file.name +'" title="'+ file.name +' ('+ Math.round( file.size / 1024 ) +'kb)' +'" class="video" />';
					$('.addVideo').append(tag);
					console.log(tag);
		        }).fail(function(data) {
					$('body').append("fail");
				});
				
				}}(file, i);
				reader.readAsDataURL(file);	// read image data
				
				
			}
		}
	}
	// legacy IE
	else {
		console.log("未対応");
	}
};


$(function() {
	$('#video_file').uploadVideos();
});
