<?php

// get all admin
$get_posts_query_results = queryDatabase("SELECT * FROM admin ORDER BY id DESC");

?>      
<div class="row">
    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <div class="container">
       <?php while($row = mysqli_fetch_assoc($get_posts_query_results)){
        // sort the array in chronological order so that the last post shows up first   
    
        $post_id = $row['id']; 
        $post_title = $row['post_title']; 
        $post_subtitle = $row['post_subtitle']; 
        $post_author = $row['post_author'];                                       
        $post_image = $row['post_image'];
        $post_date = $row['post_date'];                                                                
        ?>
       
        
                <div class="post-preview">
                    <a href="post.php?id=<?php echo $post_id; ?>">
                        <h2 class="post-title">
                            <?php echo $post_title; ?>
                        </h2>
                        <h3 class="post-subtitle">
                            <?php echo $post_subtitle; ?>
                        </h3>
                    </a>
                    <p class="post-meta">Posted by <a href="#"><?php echo $post_author; ?></a> on <?php echo $post_date; ?></p>
                </div>
        <hr>       
        <?php } ?>
    
                <!-- Pager -->
                <ul class="pager">
                    <li class="next">
                        <a href="#">Older Posts &rarr;</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <hr>