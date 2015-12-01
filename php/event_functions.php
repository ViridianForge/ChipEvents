<?php 

// FUNCTIONS
if(!function_exists('my_curl')){
function my_curl($url, $timeout=2, $error_report=FALSE)
{
    $curl = curl_init();

    // HEADERS FROM FIREFOX - APPEARS TO BE A BROWSER REFERRED BY GOOGLE
    $header[] = "Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
    $header[] = "Cache-Control: max-age=0";
    $header[] = "Connection: keep-alive";
    $header[] = "Keep-Alive: 300";
    $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
    $header[] = "Accept-Language: en-us,en;q=0.5";
    $header[] = "Pragma: "; // browsers keep this blank.

    // SET THE CURL OPTIONS - SEE http://php.net/manual/en/function.curl-setopt.php
    curl_setopt($curl, CURLOPT_URL,            $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER,     $header);
    curl_setopt($curl, CURLOPT_ENCODING,       'gzip,deflate');
    curl_setopt($curl, CURLOPT_AUTOREFERER,    TRUE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curl, CURLOPT_TIMEOUT,        $timeout);

    // RUN THE CURL REQUEST AND GET THE RESULTS
    $htm = curl_exec($curl);
    $err = curl_errno($curl);
    $inf = curl_getinfo($curl);
    curl_close($curl);

    // ON FAILURE
    if (!$htm)
    {
        // PROCESS ERRORS HERE
        if ($error_report)
        {
            echo "CURL FAIL: $url TIMEOUT=$timeout, CURL_ERRNO=$err";
            var_dump($inf);
        }
        return FALSE;
    }

    // ON SUCCESS
    return $htm;
}
}

// Truncate a string only at a whitespace (by nogdog)
if(!function_exists('truncate')){
	function truncate($text, $length) {
	   $length = abs((int)$length);
	   //Ensure that the length of the string is the exact length we 
	   //specify.  This is a hack to ensure we don't get ugly story items
	   //due to underrunning the buffer.
	   if(strlen($text) > $length) {
		  $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
	   } else {
		   //This hack here is to ensure that strings to don't fully use
		   //the buffer are still able to hit our minimum height requirements.
		   $text .= json_decode('"'.'\u00a0'.'"');
	   }
	   return($text);
	}
}

if(!function_exists('date_compare')){
	function date_compare($a, $b){
		return strtotime($a["start_time"]) - strtotime($b["start_time"]);
	}
}

// Function to allow printing PHP debug information to the web browser's console.
// Original by:
// One level of array decompression added by Wayne. Server's PHP settings
// were preventing turning this into a true Recursive exploration of multi-arrays.
if(!function_exists('debug_to_console')){
	function debug_to_console( $data ) {

		if ( is_array( $data ) ){
			foreach ( $data as $value){
				if (is_array($value)){
					$output = "<script>console.log('Debug Value: " . implode(",", $value) . "' );</script>";
				}else{
					$output = "<script>console.log('Debug Value: " . $value . "' );</script>";
				}
			}
		} else {
			$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
		}
	
		echo $output;
	}
}

//Function to discover if an event name already exists in the list of events.
if(!function_exists('event_in_event_list')){
	function event_in_event_list( $eventList, $eventName ){
		if(!empty($eventList)){
			foreach($eventList as $eventSingle){
				if($eventSingle['name'] == $eventName){
					return true;
				}
			}
			return false;
		} else {
			return false;
		}
	}
}

// Get the events list for each show page.
// Add or remove fields here to expand or contract the query.
// Field list at: developers.facebook.com/docs/graph-api/reference/event
if (!$contents_allarray){
	$contents_allarray=my_curl('https://graph.facebook.com/events?ids='.$eventpages.'&access_token='.$access_token.'&fields=id,name,place,picture.type(large),owner,start_time,end_time,timezone,description');
}

$json_allarray = json_decode($contents_allarray,true);

$split_event_pages = explode(",",$eventpages);
$alt_event_rows = explode("\n",$additional_events);

/* Convert default timezone to JSON event timezone.
if($event_item["timezone"] == "America/Detroit"){		$timezone_offset = "+3 hours";}
if($event_item["timezone"] == "America/Chicago"){		$timezone_offset = "+3 hours";}
if($event_item["timezone"] == "America/Los_Angeles"){	$timezone_offset = "+3 hours";}
if($event_item["timezone"] == "America/New_York"){		$timezone_offset = "+3 hours";}
if($event_item["timezone"] == "America/Toronto"){		$timezone_offset = "+3 hours";}*/
$timezone_offset = "+2 hours";
$now = strtotime('now');

// Extract and equalize data for each event and create new $events array.
$events_upcoming = array();
foreach($split_event_pages as $pagename){
	foreach($json_allarray[$pagename]["data"] as $event_single){
		$eventPlaceData = $event_single["place"];
		$eventLocationData = $eventPlaceData["location"];
		$event_single["place"] = $eventPlaceData["name"];
	    $subLocation = "";
		if(!empty($eventLocationData["street"])){
			$subLocation = $subLocation . $eventLocationData["street"] . ", ";
		}
		if(!empty($eventLocationData["city"])){
			$subLocation = $subLocation . $eventLocationData["city"] . ", ";
		}
		if(!empty($eventLocationData["state"])){
			$subLocation = $subLocation . $eventLocationData["state"] . ", ";
		}
		if(!empty($eventLocationData["country"])){
			$subLocation = $subLocation . $eventLocationData["country"];
		}
		$event_single["subLoc"] = $subLocation;
		if(!event_in_event_list($events_upcoming, $event_single['name']) && !empty($event_single["start_time"])){
			if(empty($event_single["end_time"])){
				$end_time = strtotime($event_single["start_time"].' +2 hours');
			} else {
				$end_time = strtotime($event_single["end_time"]);
			}
			if($now < $end_time){
				//Add Each Individual UPCOMING event to the $events array.
				array_push($events_upcoming, $event_single);
			}
		}
	}
}

//Add our hand-written event data to the list.
for($i = 1; $i < count($alt_event_rows); $i++){
	$alt_event_data = explode("\t", $alt_event_rows[$i]);
	$alt_event_single["id"] = $alt_event_data[0];
	$alt_event_single["name"] = $alt_event_data[1];
	$alt_event_single["place"] = $alt_event_data[2];
	$alt_event_single["subLoc"] = $alt_event_data[3];
	$alt_event_single["start_time"] = $alt_event_data[4];
	$alt_event_single["end_time"] = $alt_event_data[5];
	$alt_event_single["description"] = $alt_event_data[6];
	$alt_event_single["url"] = $alt_event_data[7];
	$alt_event_single["picture"] = $alt_event_data[8];

	//Only add to the list of tests passed
	if(!event_in_event_list($events_upcoming, $alt_event_single["name"]) && !empty($alt_event_single["start_time"])){
		if(empty($alt_event_single["end_time"])){
			$end_time = strtotime($alt_event_single["start_time"].' +2 hours');
		} else {
			$end_time = strtotime($alt_event_single["end_time"]);
		}
		if($now < $end_time){
			// Add each individual UPCOMING event data to $events array.
			array_push($events_upcoming, $alt_event_single);
		}
	}
}

// Sort the array by the start_time function.
uasort($events_upcoming,'date_compare');

$event_count = count($events_upcoming);
?>
