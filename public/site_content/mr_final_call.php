<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
    <div class="container">
          
          <p>
             The current star-rating estimate you've given this match is: 
          </p>
           
           <?php
            if(isset($_POST['submit'])) {
                $score = calculateScore();
                $star_rating = convertToStarRating($score);
                echo "<h1 class='text-center'>{$star_rating}</h1>";
            }
            
           ?>
           <form action="match_rater.php?source=score_reveal" method="post">
               <br>
               <div class="form-group">
                       <label for="choice">What is your first impression of this rating?</label><br>
                       <input type="radio" checked="checked" name="choice" value="right"> This rating is just right<br>
                       <input type="radio" name="choice" value="low"> This rating should be a little bit higher<br>
                       <input type="radio" name="choice" value="high"> This rating is a little bit too high<br>
                       <input type="hidden" name="score" value="<?php echo $score; ?>">
                </div><br>
                <input type="submit" value="Submit" name="final_submit" class="btn btn-primary">
                <br><br><br><br>
          </form>
    </div>
</div>
    

