
<!-- ##### RIGHT SIDEBARE ##### -->

<div id="sidebar" class="sidebar sright section">
	<div class="widget">
		<div id="ad_3" class="ads-right"></div>
	</div>
	<div class="widget">
		<h4>Top Videos:</h4>
		<ul class="pm-ul-top-videos" id="pm-ul-top-videos">
		<div class="loadPlaylist"></div>
		</ul>
		<div class="clearfix"></div>
	</div>
</div>
<!-- ##### END RIGHT SIDEBARE ##### -->
<script>

	function loadTopVideo(){
		var topvdo = '{{Config::get('app.url')}}ajax?p=topvideo';
		$.ajax({
			url: topvdo,
			type: "GET",
			dataType: "json",
			beforeSend: function(){
				//$("#blockui").show();
			},
			complete: function(){
				$("#blockui").hide();
			},
			success: function(data){
				if(data) {
					//createHtmlTop(data);
					$("#pm-ul-top-videos").html(createHtmlTop(data));
				}
				//$("#getajax").html(data.result);
				//$("#byPage").html(data.page);
			},
			error: function(){} 	        
	   });
		callAfter();
	}

	function createHtmlTop(data) {
		var html ='';
		$.each(data, function (i, fb) {
			html += '<li>';
			html += '<div class="pm-li-top-videos">';
			html += '<span class="pm-video-thumb pm-thumb-106 pm-thumb-top border-radius2">';
			var part = '<span class="pm-label-duration border-radius3 opac7">'+fb.total+' Parts</span>';
			var populars = '';
			var setNew = '';
			if(fb.popular) {
				populars = '<span class="label label-pop">Popular</span>';
			}
			if(fb.new) {
				setNew = '<span class="label label-new">New</span>';
			}
			var setTopTarget = '';
			if(fb.tositeb) {
				setTopTarget = '_blank';
			}
			html += '<span class="pm-video-li-thumb-info">'+setNew+populars+part+'</span>';
			var image = '<span class="pm-thumb-fix-clip"> <img src="'+fb.thumb+'" width="145"> <span class="vertical-align"></span> </span>';
			html += '<a href="'+fb.link+'" target="'+setTopTarget+'" class="pm-thumb-fix pm-thumb-106">'+image+'</a>';
			html += '</span>';
			html += '<h3 dir="ltr"><a href="'+fb.link+'" target="" class="pm-title-link" title="'+fb.title+'">'+fb.title+'</a></h3>';
			html += '<span class="pm-video-attr-numbers"><small>'+fb.views+' Views</small></span> ';
			html += '</div>';
			html += '</li>';
		});
		return html;
	}
</script>