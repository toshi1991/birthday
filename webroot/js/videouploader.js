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
		var ajax_cnt = 0;

		for (var i = 0, I = this.files.length; i < I; i++) { // multiple
			var file  = this.files[i];
			console.log(file);

			if (file && (file.type && file.type.match(/^video*/))) {
				if (file.size > max_size) {
					var errorTag = $('<div>').addClass('message error').click(function(){$(this).addClass('hidden');});
					errorTag.text('ファイルサイズが大きすぎます。');
					this.value = "";
					$('.container').before(errorTag);
					return ;
				}

				var reader = new FileReader();
				reader.onload = function (file, i) { return function () {

				var fd = new FormData();
				fd.append('video', file);
				fd.append('message_id', message_id);

				// show overlay
				if($(".overlay").length == 0) {
					var overlay = $("<div>").addClass('overlay').hide();
					$("body").prepend(overlay);
				}
				$(".overlay").fadeIn();

				ajax_cnt++;

		        $.ajax({
		            url: root_url + 'movies/add',
		            type: 'POST',
		            data: fd,
		            processData: false,
		            contentType: false,
		            dataType: 'json'
		        }).done(function(data) {
					if (data['result'] == 'ok') {
						// append
						var tag = '<video poster="' + root_url + 'img/novideo.jpg"><source src="' + root_url + 'videos/' + data['filename'] + '"></video>';// alt="'+ file.name +'" title="'+ file.name +' ('+ Math.round( file.size / 1024 ) +'kb)' +'" class="video" />';
						$('.videoArea').prepend(tag);
					} else {
						// error
						console.log(data);
						var errorTag = $('<div>').addClass('message error').click(function(){$(this).addClass('hidden');});
						errorTag.text(data['error']);
						$('.container').before(errorTag);
					}
					ajax_cnt--;
					if (ajax_cnt == 0) {
						$('.overlay').fadeOut();
					}
		        }).fail(function(data) {
					var errorTag = $('<div>').addClass('message error').click(function(){$(this).addClass('hidden');});
					errorTag.text(data['error'] ? data['error'] : 'エラーが発生しました。');
					$('.container').before(errorTag);
					ajax_cnt--;
					if (ajax_cnt == 0) {
						$('.overlay').fadeOut();
					}
				});

				}}(file, i);
				reader.readAsDataURL(file);	// read image data


			} else {
				var errorTag = $('<div>').addClass('message error').click(function(){$(this).addClass('hidden');});
				errorTag.text('未対応のファイルです。');
				$('.container').before(errorTag);
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
	$('#addvideo').click(function(){
		$('#video_file').click();
	});
});
