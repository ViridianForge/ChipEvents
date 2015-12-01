    <div id="eventListContainer" class="event-list full-list">

        <?php

        if($events_upcoming){
            foreach($events_upcoming as $event_item){

                // Convert JSON time to human readble time output, plus 3 hours (Timezone offset).
                $start_time = strtotime($event_item["start_time"]);
                $end_time = strtotime($event_item["end_time"].' '.$timezone_offset);

                if($now < $end_time){

                    // Live Show Boolean
                    $live_active_show = false;
                    if( ($now >= $start_time) && ($now <= $end_time) ){
                         $live_active_show = true;
                    }

                    // Convert description text to excerpt
                    $event_item["description"] = truncate($event_item["description"],275);

                    // Check for valid Picture URL
					if(!isset($event_item["picture"]["data"]["is_silhouette"]) && !empty($event_item["picture"])){
						$event_img = $event_item["picture"];
					} else if($event_item["picture"]["data"]["is_silhouette"] !== "true"){
                        $event_img = $event_item["picture"]["data"]["url"];
                    } else {
						$event_img = "img/no-picture-1.jpg";
					}

					//Catch for NA stuff for now.
					if(is_string($event_item["picture"]) && strpos($event_item["picture"],"NA") !== FALSE){
						$event_img = "img/no-picture-1.jpg";
					}

					//Build the Event Link
					if(array_key_exists("url",$event_item)){
						$event_url = $event_item["url"];
					}else{
						$event_url = "https://facebook.com/events/" . $event_item["id"];
					}
        ?>

        <a href="<?php echo $event_url; ?>" target="_blank" >
			<div class="story-item <?php if($live_active_show == true){ echo " story-item-live";} ?>">
				<div class="story-item-img">
					<img src="<?php echo $event_img; ?>"/>
				</div>
				<div class="story-info">
					<div class="story-name"><?php echo $event_item["name"]; ?></div>
					<div class="story-location"><?php echo $event_item["place"];?></div>
					<div class="story-subLoc"><?php if(!empty($event_item["subLoc"])){echo $event_item["subLoc"];} ?></div>
					<div class="story-time"><?php if($live_active_show == true){ echo 'Happening Now!'; }else{ echo date('l, F jS @ g:i A', $start_time); } ?></div>
					<div class="story-desc"><?php echo $event_item["description"]; ?></div>
          <!-- Add to Calendar Stuff -->
          <!--<div title="Add to Calendar" class="addthisevent">
            <p style="color:#FFF;">Add to Calendar</p>
            <span class="start"><?php echo date('d/m/Y H:m', $start_time); ?></span>
            <span class="end"><?php echo date('d/m/Y H:m', $end_time); ?></span>
            <span class="timezone">Europe/Paris</span>
            <span class="title"><?php echo $event_item["name"]; ?></span>
            <span class="description"><?php echo $event_item["description"]; ?></span>
            <span class="location"><?php echo $event_item["place"];?></span>
            <span class="date_format">MM/DD/YYYY</span>
          </div>-->
				</div>
        <div class="distance">
          <script type="text/javascript">
            console.log(crds);
            if(crds === -1){
                console.log("No Coords!");
                document.write('<p></p>');
            }else{
              //var location = "<?php echo $event_item["subLoc"]; ?>";
              console.log("Coords?");
              document.write('<p>50 miles away!</p>');
            }
            console.log(location);
          </script>
        </div>
            </div>
        </a>

        <?php }}}else{ // If there's no events, then show this ?>
		<div class="story-item">
            <p class="story-name">There are no currently scheduled events.</p>
        	<p class="story-desc">Know about one coming up?  Let us know our <a href="mailto:events@chiptuneswin.com">event specialists</a> know!</p>
        </div>
		<?php } ?>

    </div>
