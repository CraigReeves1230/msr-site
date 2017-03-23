<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
    <div class="container">
          
          <p class="text-center">
              <b>The star-rating for this match:</b> 
          </p>
           
           <?php
            if(isset($_POST['final_submit'])) {
                $score = $_POST['score'];
                $choice = $_POST['choice'];
                
                // calculate final score
                switch($choice) {
                    case "high";
                        $score -= 0.25;
                    break;
                    
                    case "low";
                        $score += 0.25;
                    break;
                        
                    default:
                        $score = $score;
                    break;
                }
                
                // Convert score to star rating
                $star_rating = convertToStarRating($score);
                
                // if star rating is already *****, user still thinks it's too high, make it SIX
                if($star_rating == "*****" && $choice == "low") $star_rating = "******";
                
                // Display score in the form of a star rating
                echo "<h1 class='text-center'>" . $star_rating . "</h1>";
            }
            
           ?>
    </div><br><br><br><br><br><br>
</div>
    

