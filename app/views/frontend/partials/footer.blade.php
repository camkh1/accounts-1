<?php
switch (Config::get('app.url')) {
	case 'http://www.allkun.com/':
		$onlineCode = '5fwzh7grfigw';
		break;
	case 'http://www.roeung.com/':
		$onlineCode = '5mxx81rp6l8r';
		break;
	case 'http://www.sruol9.com/':
		$onlineCode = '5ci706948lej';
		break;
	case 'http://www.khmermovies.co/':
		$onlineCode = '2n8xaa7px423';
		break;
	case 'http://www.mkhmer.co/':
		$onlineCode = '0labq7f8qz29';
		break;
	case 'http://www.m-khmer.com/':
		$onlineCode = '3cad2v68jih7';
		break;
	case 'http://www.moviekhmer.co/':
		$onlineCode = '5gsd56x8oopd';
	break;
	default:
		$onlineCode = '3byg00xe65rx';
		break;
}
?>
<!-- Start footer -->
<div style="clear: both"></div>
<footer class="footer" style="z-index: 10000">
            <div class="container">
                 <div class="row">
                     <div class="col-lg-4 about">
                         <h5>Hora</h5>
                         <a href="http://hora.hot-kh.com/atta" title="Find who couples of yours" target="_blank"><img class="img-rounded" src="http://hora.hot-kh.com/image/banner/year_couples.gif" style="width: 100%;"></a>
                         <a href="http://hora.hot-kh.com/chhut?session=chhut" title="Tomra Chhat 3 Chun" target="_blank"><img class="img-rounded" src="http://hora.hot-kh.com/image/banner/chhut3.jpg" style="width: 100%;;margin-top:5px;"></a>
                         <a href="http://hora.hot-kh.com/phone" title="Check your Phone Number good or not" target="_blank"><img class="img-rounded" src="http://hora.hot-kh.com/image/banner/number-phone.gif" style="width: 100%;;margin-top:5px;"></a>
                     </div>
                     <div class="col-lg-4 recent-post">
                         <h5>Recent Posts</h5>
                         <ul>
                             <li>
                                 <a href="http://merltv.com/" target="_blank"><img style="width: 100%;" border="0" src="http://1.bp.blogspot.com/-UrrxzEwFspQ/U_nUeUdtx-I/AAAAAAAAIco/ukmKUYK_Uqo/s320/tvkhmer.jpg"></a>
                                 <a href="http://www.komsanchet.com/search/label/Comedy?max-results=15" target="_blank"><img style="width:100%;margin-top:5px;" border="0" src="http://3.bp.blogspot.com/-jeN2x_lyyUQ/U_nT8ZxiNoI/AAAAAAAAIcg/0TJ-_LpNzdI/s0/Krern-Peak-mi.jpg"></a>
                                 <a href="http://www.vcdkh.com/search/label/S%20--%20Preap%20Sovath?max-results=100" target="_blank"><img border="0" src="http://2.bp.blogspot.com/-MnFOCNuvOJM/U_nTfasy5uI/AAAAAAAAIcY/s84BYCd5THA/s320/cammv_banner.jpg" style="width:100%;margin-top:5px;"></a>
                             
                         </ul>
                     </div>
                     <div class="col-lg-4 recent-post">
                         <h5>Recent Posts</h5>
                         <ul>
                         	</li>                             
                                 <div class="row">
                                     <div class="col-lg-1">
                                         <a href="http://www.merltv.com/2015/07/raksmey-hang-meas-hdtv-khmer-live-tv-online-tv-cambodia.html" target="_blank"><img src="http://3.bp.blogspot.com/-qMEtjwyfRXc/VaV1-gQgAQI/AAAAAAAAKec/lV9fNFKUWCM/s80/rhm-logo%2B%25281%2529.png" alt="" /></a>
                                     </div>
                                     <div class="recent-body">
                                         <a href="http://www.merltv.com/2015/07/raksmey-hang-meas-hdtv-khmer-live-tv-online-tv-cambodia.html" target="blank">Raksmey Hang Meas HDTV - Khmer Live TV Online (TV Cambodia)</a><br />
                                         <em><small>Sattellite TV: Cambodia, Lao, Thailand and all other Asian country.</small></em>
                                     </div>
                                 </div>
                             </li>
                             <li>
                                 <a href="http://www.hot-kh.com/" target="_blank"><img style="width:100%" border="0" src="http://1.bp.blogspot.com/-hAOYEF6NSWc/U5cHmDlkphI/AAAAAAAAG4k/Y3t8eigd7-c/s1600/photo-animation.gif"></a>
                                 <a href="http://db.tt/lw2kktR5" rel="nofollow" target="_blank"><img border="0" src="http://1.bp.blogspot.com/-LWZvSC9WukE/UTFC6qkOewI/AAAAAAAAAS8/Eu0pjOSiU1w/s000/dropbox.gif" style="width:100%;margin-top:5px;"></a>
                                 <a href="http://whos.amung.us/stats/w90etiqe6ijo/" target="_blank" title="all">.</a>
                                 <a href="http://whos.amung.us/stats/{{$onlineCode}}/" target="_blank" title="this">.</a>
                             </li>
                         </ul>
                     </div>
                     
                 </div>
            </div>
        </footer>
        <!-- End footer -->
        
        <!-- Start socket -->
        <section class="socket">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <span>© 2013 . All rights reserved.</span>     
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-pills">
                            <li><a href="{{Config::get('app.url')}}p/policy.html">Policy</a></li>
                            <li><a href="{{Config::get('app.url')}}p/dmca.html">DMCA </a> </li>
                        </ul>
                    </div>
                    <div id="onlineView"></div>
                </div>     
            </div>
        </section>
        <!-- End socket -->                
{{HTML::script('frontend/defualt/js/bootstrap.min.js')}}
{{HTML::script('frontend/defualt/js/navigationleft/jquery-ui-1.10.1.custom.min.js')}}
{{HTML::script('frontend/defualt/js/navigationleft/jquery-migrate-1.1.1.min.js')}}
{{HTML::script('frontend/defualt/js/navigationleft/jquery.cookies.2.2.0.min.js')}}
{{HTML::script('frontend/defualt/js/navigationleft/jquery.hoverIntent.minified.js')}}
{{HTML::script('frontend/defualt/js/navigationleft/actions.js')}}
{{HTML::script('frontend/defualt/js/custom.js')}}
<script type='text/javascript'>
	var homePage = "{{Config::get('app.url')}}";
</script>
<link rel="apple-touch-icon-precomposed"
	href="frontend/images/ico/apple-touch-icon-57-precomposed.png" />
<!-- Modal -->
<div class="modal fade" id="dynamicModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel">Modal title</h4>
			</div>
			<div class="modal-body" id="overrideContent">
				<div id="ModalLoading" style="display: none; text-align: center;">
					<img
						src="{{Config::get('app.url')}}/frontend/images/upload_progress.gif"
						border="0" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@include('frontend.partials.player')
<script type='text/javascript'>
	function renderAds() {
		$("#ad_1 *").hide();
		$("#ad_2 *").hide();
		$("#ad_3 *").hide();

		var div1 = $('<div>');
		$("#ad_1").append(div1);
		var div2 = $('<div>');
		$("#ad_2").append(div2);
		var div3 = $('<div>');
		$("#ad_3").append(div3);
		var widthad = 300;
		var ads_id = aDs;
		postscribe(div1, '<style>.respondsive-ad-top { width: 300px; height: 250px;}@media(min-width: 1440px) '+
				'{ .respondsive-ad-top { width: 728px; height: 90px; }}@media(min-width: 1540px)'+
				' { .respondsive-ad-top { width: 300px; height: 250px; }}@media only screen and (min-width:768px) and (max-width:1439px) '+
				'{.respondsive-ad-top {width: 300px; height: 250px; }}@media(max-width: 727px)'+
				'{.respondsive-ad-top { width: 468px; height: 60px;  }}@media(max-width: 468px)'+
				'{.respondsive-ad-top { width: 320px; height: 50px;  }}'+
				'.respondsive-ad-related { width: 728px; height: 90px;}@media(min-width: 1620px) { '+
				'.respondsive-ad-related { width: 970px; height: 90px; }}@media(min-width: 1400px) and (max-width:1619px) { '+
				'.respondsive-ad-related { width: 728px; height: 90px;}}@media only screen and (min-width:940px) and (max-width:1339px) {.respondsive-ad-related { width: 468px; height: 60px;}}@media only screen and (min-width:728px) and (max-width:989px) {'+
				'.respondsive-ad-related {width: 336px; height: 280px; } }@media only screen and (min-width:468px) and (max-width:767px) {'+
				'.respondsive-ad-related {width: 468px; height: 60px; } }@media(max-width: 468px) { '+
				'.respondsive-ad-related { width: 320px; height: 50px;  }}'+
				'.respondsive-ad-side-left { width: 160px; height: 600px;}<\/style>'+
				'<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><\/script>'+
				'<ins class="adsbygoogle respondsive-ad-related" style="display:inline-block" '+
				'data-ad-client="ca-pub-' + ads_id + '" data-color-border="ffffff" data-color-bg="ffffff" '+
				'data-color-link="ff0066" data-color-text ="333333" data-color-url="ff0066"><\/ins>'+
				'<script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>');
		postscribe(div2, '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><\/script>'+
				'<ins class="adsbygoogle respondsive-ad-side-left" style="display:inline-block" '+
				'data-ad-client="ca-pub-' + ads_id + '" data-color-border="ffffff" data-color-bg="ffffff" '+
				'data-color-link="555555" data-color-text ="333333" data-color-url="555555"><\/ins>'+
				'<script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>');
		postscribe(div3, '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"><\/script>'+
				'<ins class="adsbygoogle respondsive-ad-top" style="display:inline-block" '+
				'data-ad-client="ca-pub-' + ads_id + '" data-color-border="ffffff" data-color-bg="ffffff" '+
				'data-color-link="555555" data-color-text ="333333" data-color-url="555555"><\/ins>'+
				'<script>(adsbygoogle = window.adsbygoogle || []).push({});<\/script>');
	}
</script>
<script type="text/javascript">
function hideTagFn(){
   $('.message-alert').fadeOut(500);
}

window.setInterval(function () {
    hideTagFn();
}, 5000);



jQuery(document).ready(function(){
	jQuery("#search-bar").click(function(){
		jQuery( "#h-search-form" ).toggleClass('open');
	});
	jQuery("#search-close").click(function(){
		jQuery( "#h-search-form" ).toggleClass('open');
	});


	  postscribe('#js-filter','<script id="facebook-jssdk" src="http://connect.facebook.net/en_US/sdk.jss#xfbml=1&appId=1456273291274751&version=v2.0&status=0"><\/script>\n'+
	  		'<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"><\/script>\n'+
	  		'<script src="http://sruol9.com/programs_file/app/player/yt/ytjqerylist/sly.js"><\/script>\n'+
			'<script src="'+ home_page +'frontend/js/audiojs-master/music-play.js"><\/script>');
	  callAfter();
});

function callAfter() {
	if(!copyright) {
	@if(Config::get('app.siteNoAd')!=1)
	//renderAds();
	@endif
	}
	postscribe("#onlineView",'<div style="height:1px;overflow:hidden;"><script id="_wau4iq">var _wau = _wau || []; _wau.push(["classic", "{{$onlineCode}}", "4iq"]);'+
            '(function() {var s=document.createElement("script"); s.async=true;'+
            's.src="http://widgets.amung.us/classic.js";'+
            'document.getElementsByTagName("head")[0].appendChild(s);'+
            '})();<\/script><\/div><div style="height:1px;overflow:hidden"><img src="http://whos.amung.us/cwidget/w90etiqe6ijo/ffc20e000000.png" title="all" height="29" border="0" width="81"/><\/div>');
	$("#blockui").hide();
}
</script>
</body>
</html>