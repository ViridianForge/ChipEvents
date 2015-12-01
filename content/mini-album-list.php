<?php $json_albums = json_decode($recent_albums,true); ?>
    <div class="event-list mini-list">
        <h2>Recent Albums</h2>
        
		<?php 
        
        $i = 1;
		$album_count = 0; 
        //added before to ensure it gets opened
        echo '<div id="mini-album-cycle">';
		
		foreach($json_albums as $album){
			if( $album_count < 12 ){
			if($i % 3 == 1) {echo '<div>';}
		?>
        
        <a class="story-item" href="<?php echo $album["link"]; ?>" target="_blank" >
            <div class="story-item-img">
                <img src="img/albums/<?php echo $album["art"]; ?>.gif" width="64" height="64" />
            </div>
            <div class="story-info">
                <p class="story-name"><?php echo $album["album"]; ?></p>
                <p class="story-artist">by <?php echo $album["artist"]; ?></p>
                <p class="story-date">Released <?php echo date('F jS, Y', strtotime($album["released"])); ?></p>
            </div>
        </a>
        
        <?php
            if($i % 3 == 0) {echo '</div>';}
			$i++;
        	$album_count++;}}
		echo '</div>';
        
		?>
                

        
    </div>
