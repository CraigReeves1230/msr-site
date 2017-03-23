<?php
if(isset($_POST['next'])) {
    $offense = $_POST['offense'];
    $timing = $_POST['timing'];
    $movement = $_POST['movement'];

    $action = $_POST['action'];
    $excitement = $_POST['excitement'];

    $time = $_POST['time'];
    $story = $_POST['story'];
    $selling = $_POST['selling'];
}

?>

<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <div class="container">
          
           <form action="match_rater.php?source=final_call" method="post" class="form-horizontal">
               <h1 class="text-center">CROWD INTERACTION</h1><br>
               
                <p>If you do not wish to factor the crowd interaction into the match rating, please select "DO NOT FACTOR".</p> 
                
               <div class="form-group">
                   <label for="crowd">Please provide your view of the crowd interaction during the match.</label><br>
                   <select name="crowd" id="" class="form-control">
                       <option value="0.5">Worst Ever</option>
                       <option value="1.0">Bad</option>
                       <option value="2.0">Mediocre</option>
                       <option selected="selected" value="2.5">Decent</option>
                       <option value="3.0">Good</option>
                       <option value="3.5">Very Good</option>
                       <option value="4.0">Great</option>
                       <option value="4.5">Amazing</option>
                       <option value="99.0">DO NOT FACTOR</option>
                   </select>
               </div>
               <input type="hidden" name="offense" value="<?php echo $offense; ?>">
               <input type="hidden" name="timing" value="<?php echo $timing; ?>">
               <input type="hidden" name="movement" value="<?php echo $movement; ?>">
               <input type="hidden" name="action" value="<?php echo $action; ?>">
               <input type="hidden" name="excitement" value="<?php echo $excitement; ?>">
               <input type="hidden" name="time" value="<?php echo $time; ?>">
               <input type="hidden" name="story" value="<?php echo $story; ?>">
               <input type="hidden" name="selling" value="<?php echo $selling; ?>">
               <input type="submit" value="Next" name="submit" class="btn btn-primary">
               <br><br><br><br><br>
           </form> 
        </div>
    </div>
    

