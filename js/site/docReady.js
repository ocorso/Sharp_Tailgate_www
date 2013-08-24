	/* Author: Owen Corso	*/

var disclaimer			= {};
var trackingController 	= {};
var cookieController	= {};
cookieController.c_name	= "sharp-disclaimer";

trackingController.track 	= function($cat, $action){
	log("track: category:"+ $cat+ ", action: "+$action);
							//category
	_gaq.push(['_trackEvent', $cat, $action]);
};
//=================================================
//================ DISCLAIMER
//=================================================
disclaimer.opts = {
	//maxWidth	: 500,
	//	maxHeight	: 500,
	//	fitToView	: true,
		topRatio	: .1,
		width		: 468,
		height		: 240,
	autoSize	:false,
	//	closeClick	: false,
	//	openEffect	: 'elastic',
	//	closeEffect	: 'elastic',
		//showCloseButton: 'false',
		type		: "iframe"
	};
disclaimer.click	= function (event){	
	disclaimer.href	= $(this).attr('href');
	log(disclaimer.href);
	disclaimer.open(environment.baseUrl + "disclaimer"); 
	return false;
};
disclaimer.open 	= function ($url){
	
	log("openDisclaimer: "+$url);
	$.fancybox.open({href:$url}, disclaimer.opts);
};
disclaimer.handleAccept		= function(){
	
	log("hi");
	$.fancybox.close();
	var cookie 		= "heck yeah";
	cookieController.setCookie(cookieController.c_name,cookie,365);
	ored.flashReady();
};

//=================================================
//================ COOKIE 
//=================================================
cookieController.checkCookie = function(){
	
	var cookie = cookieController.getCookie(cookieController.c_name);
	var result = (cookie!=null && cookie!="") ? true : false;
	return result;
};

cookieController.setCookie = function (c_name,value,exdays){
	var exdate=new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
	document.cookie=c_name + "=" + c_value;
};

cookieController.getCookie = function (c_name){
	var i,x,y,ARRcookies=document.cookie.split(";");
	for (i=0;i<ARRcookies.length;i++)
	{
	  x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
	  y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
	  x=x.replace(/^\s+|\s+$/g,"");
	  if (x==c_name)
	    {
	    return unescape(y);
	    }
	  }
};

//=================================================
//================ TWITTER
//=================================================
function fetchTwitter(){
	log("fetchTwitter");
	var twitter	= "//search.twitter.com/search.json";
	var url 	= twitter + "?q=%23"+ environment.hashtag;
	var data	= {};
	data.q		= "%23"+ environment.hashtag;
	data.callback='onFetchTwitter';
	
	var ajax	= {};
	ajax.type	= "GET";
	ajax.url	= twitter;
	ajax.data	= data;
	ajax.success= function($data){ alert("success");};
	ajax.dataType= "jsonp";
	ajax.jsonp	= false;
	ajax.jsonpCallback	= onFetchTwitter;
	
	$.ajax(ajax);
}	
function onFetchTwitter($data){
	if($data){
		
log("onFetchTwitter");
//log($data.results)
		var tweet 	= $data.results[0].text;
		log($data);
		var hashtag	= '#'+environment.hashtag;
		var html 	= tweet.replace(hashtag, "<span class='red'>"+ hashtag +"</span>")
		$("#twitter_feed").hide().html(html).fadeIn();	
	}
}

//*******************************************************************************
//*** DOC Ready ***
//*******************************************************************************
jQuery(function($) {

	log("doc is ready, yo");
	
	//environement vars in header
	configApp();

	if (typeof ored !='undefined'){ 
		
		//tailgate page: 
		ored.flashReady();
	}else{
		fetchTwitter();
		//disclaimer.open(environment.baseUrl + "disclaimer"); 
	}
	
	//oc: click handlers
	//$("#pinterest").click(function(event){   	window.top.location 	= "http://pinterest.com/sharpaquos/"; return false;});
	$("#twitter_section").click(function(event){   	window.open("https://twitter.com/#!/search/ultimatetailgate?q=ultimatetailgate","_blank");});
//	if(!cookieController.checkCookie())	$(".disclaimerable").click(disclaimer.click);
	
	
    //facebook
    var fbOpts 				= {};
    fbOpts.appId			= environment.facebook_app_id;
    fbOpts.status			= true;
    fbOpts.cookie			= true;
    fbOpts.xfbml			= true;
	FB.init(fbOpts);
	
	//set height of iFrame
	SetFrame();

});//end doc ready