<?php

//PHP Facebook Event Feed Page
//
//Original Version by Michael Caferelli (http://cafarellidigital.com/)
//Downloadable at: http://cafarellidigital.com/eventfeed/
//
//Modifications by Wayne Manselle (http://www.viridianforge.com)
//Downloadable at: ()

// Put the access token you get from Facebook here.
// https://developers.facebook.com/docs/facebook-login/access-tokens
// The one Arecibo Radio used was an App Access Token. Create a
// Facebook App (it can be blank, you're just using it for the token),
// and use that here to gain access to the FB API.
$access_token ="1456561407976728|b82834140d5939aef0f27aa265b041ce";

// List the FB Page ID's you want to see events for here. These are
// the Pages that will be scraped for upcoming events.
$eventpages = "8Static,NoiseChannelRadio,dwellingofduels,iochipmusic,magfest,8bitX,ThisWeekInChiptune,8bitla,Cheapbeats,ubiktune,ChiptunesWin,ptesquad,hyperwaverecords,DataPortPDX,bitgridonline,nintendoom,forestbookingru,BitGenGamerFest,PulsewaveSF,pulsewavenyc,toycompanymontreal,BOSTON8BIT,SquareSounds,superbytefestival,littlesoundassembly,BrKfest,ClipstreamWebShow,OpenCircuitRadio,areciboradio,eindbaas,56kbpsrecords,formatdf,8bitsf,GameChops,rockageSJ,ravertoothtiger,DjCUTMAN,lotekresistance,DenverChiptune,gamewavepodcast,TheDiamondExchangeShow,robktamusic,SuperSoulBros,OngakuOverdrive,UrizenOnline,protomen,bleepstreet,VConMX,calmdownkidder,NanodeMusic";

// You can place additional events in this file using a similar format
// to Facebook's API.
$additional_events=file_get_contents('https://docs.google.com/spreadsheets/d/1PeAel0ZiuKZlcQFYUVXHHKHR3jt2p1PN9YUD0ENE94M/pub?output=tsv');

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Welcome to the Chiptunes = WIN events page. Stop in to learn all about upcoming chiptune, vgm, and nerdcore related events happening world wide!">
	<title>Chiptunes = WIN Events Page</title>
	<link rel="icon" href="img/favicon.ico" >
	<link rel="icon" href="img/favicon.png" >
	<link rel="stylesheet" media="(max-width: 640px)" href="css/mobStyle.css" />
	<link rel="stylesheet" media="(min-width: 640px)" href="css/deskStyle.css" />
  <!--<link rel="stylesheet" media="(max-width: 640px)" href="css/addthisevent.theme5mini.css" />-->
  <!--<link rel="stylesheet" media="(min-width: 640px)" href="css/addthisevent.theme5.css" />-->
  <link rel="stylesheet" href="js/jScrollPane/jquery.jscrollpane.css" />
    <!--[if lt IE 9]>
        <script src="js/html5.js"></script>
    <![endif]-->

    <!-- Set up Geolocation Data
    <script type="text/javascript">
      var crds = -1;
      if("geolocation" in navigator){
        //Set up support functions
        var options = {
          timeout: 1500,
          maximumAge: 20000
        };

        function success(pos){
          crds = pos.coords;
        }

        function error(err){
          console.warn('ERROR: ' + err.code + ' ' + err.message);
        }

        //Ideally -- Loading Screen here
        /*Geolocation is available, ask permission, get data*/
        navigator.geolocation.getCurrentPosition(success, error, options);
        //Dismiss Loading Screen
      }
    </script> -->
</head>
<body>
<div id="header">
	<h1 id="pgTitle">THE CHIPWIN EVENTS CALENDAR</h1>
</div>
<?php include "php/event_functions.php"; ?>

<?php include "content/full-event-list.php"; ?>

<div id="footer">
	<a href="http://cafarellidigital.com/"><div id="cred-mike" class="credit">Based on Michael Cafarelli's original events list code.</div></a>
	<a href="http://www.viridianforge.com"><div id="cred-wayne" class="credit">Programming for Chiptunes = WIN by Viridian Forge.</div></a>
</div>

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript" ></script>
<script src="js/easing.js" type="text/javascript" ></script>
<script src="js/cycle.js" type="text/javascript" ></script>
<!-- AddThisEvent -->
<!--<script type="text/javascript" src="https://addthisevent.com/libs/1.6.0/ate.min.js"></script>-->

<!-- AddThisEvent Settings -->
<!-- <script type="text/javascript">
addthisevent.settings({
  license    : "replace-with-your-licensekey",
  css        : false,
  outlook    : {show:true, text:"Outlook"},
  google     : {show:true, text:"Google <em>(online)</em>"},
  yahoo      : {show:true, text:"Yahoo <em>(online)</em>"},
  outlookcom : {show:true, text:"Outlook.com <em>(online)</em>"},
  appleical  : {show:true, text:"Apple Calendar"},
  dropdown   : {order:"appleical,google,outlook,outlookcom,yahoo"}
});
</script> -->

<!-- Scrollbars come last -->
<script src="js/jScrollPane/jquery.jscrollpane.min.js" type="text/javascript"></script>
<script src="js/jquery.mousewheel.js" type="text/javascript"></script>
<script src="js/jquery.jscrollpane.min.js" type="text/javascript"></script>
<script type="text/javascript">
	$('#eventListContainer').jScrollPane({showArrows: true, arrowScrollOnHover: true, autoReinitialize: true});
	window.onresize = function(){
		window.location.reload(true);
	};
</script>

</body>
</html>
