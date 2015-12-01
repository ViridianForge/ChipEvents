    <div class="event-list mini-list">
        <h2>Upcoming Events</h2>
        
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
                    
                    // Check for valid Picture URL
                    if($event_item["picture"]["data"]["is_silhouette"] !== "true"){
                        $event_img = $event_item["picture"]["data"]["url"];
                    }else{
						// If there's no event photo, use this one
                        $event_img = "img/no-picture.jpg";
                    }
        ?>
                
        <a class="story-item <?php if($live_active_show == true){ echo " story-item-live";} ?>" href="http://facebook.com/events/<?php echo $event_item["id"]; ?>" target="_blank" >
            <div class="story-item-img">
                <img src="<?php echo $event_img; ?>" style=" <?php echo $eventimg_size; ?>" />
            </div>
            <div class="story-info">
                <p class="story-name"><?php echo $event_item["name"]; ?></p>
                <p class="story-time"><?php if($live_active_show == true){ echo 'Live Now!'; }else{ echo date('l, F jS @ g:i A', $start_time); } ?></p>
                <p class="story-desc">Created by <?php echo $event_item["owner"]["name"]; ?></p>
            </div>
        </a>
        
        <?php }}} ?>

    </div>
