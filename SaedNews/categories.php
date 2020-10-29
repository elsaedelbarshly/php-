<?php require_once('./includes/header.php');?>
<?php 
  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $sql= " SELECT * FROM `categories` WHERE `cat_id`=$id " ;
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $count = $stmt->rowCount(); //echo " COUNT IS : $count";
    if($count == 0){
      $error = true ;
    }//if error
    while( $cat =  $stmt->fetch(PDO::FETCH_ASSOC) ) :
      $cat_id = $cat['cat_id'];
      $new_cat_title = $cat['cat_title'];
    endwhile;
  }//if isset id
?>
<?php require_once('./includes/navigation.php');?>
<?php
   if(isset($error)){
    echo "<h1 class='alert alert-danger text-center my-5'> NO POST FOUND </h1>";
    exit();
} ?>
      <section id="main" class="mx-5">
        <h2 class="my-3">Category: <?=$new_cat_title?></h2>

        <?php
          $sql = "SELECT * FROM `posts` WHERE `post_cat_id` =$id ";
          $stmt = $pdo->prepare($sql);
          $stmt ->execute();

          while( $post =  $stmt->fetch(PDO::FETCH_ASSOC) ) :
            $post_id = $post['post_id'];
            $post_title = $post['post_title'];
            // $post_contents = $post['post_contents'];
            $post_contents = substr($post['post_contents'],0,200) ;
            $post_image = $post['post_image'];
            $post_author = $post['post_author'];
            $post_date = $post['post_date'];
            $post_status = $post['post_status'];
            $post_cat_id = $post['post_cat_id'];
        
        ?>

<div class="row my-4 single-post">
          <img class="col col-lg-4 col-md-12" src="./img/<?=$post_image?>" alt="Image">
          <div class="media-body col col-lg-8 col-md-12">
            <!--  -->
            <h5 class="mt-0"><a href="single.php?id=<?=$post_id?>"> <?=$post_title?> </a></h5>
            <!--  -->
            <span class="posted">
              <a href="categories.php?id=<?=$post_cat_id?>" class="category">
                <!-- <?=$post_cat_id?> -->
                <?php 
                  // $sql1 = " SELECT * FROM `categories` WHERE cat_id =$post_cat_id ";
                  // $stmt1 = $pdo->prepare($sql1);
                  // $stmt1 ->execute();
                  $sql1 = " SELECT * FROM `categories` WHERE cat_id =:id ";
                  $stmt1 = $pdo->prepare($sql1);
                  $stmt1 ->execute([':id'=>$post_cat_id]);

                  while( $cat =  $stmt1->fetch(PDO::FETCH_ASSOC) ) :
                    $cat_id = $cat['cat_id'];
                    $cat_title = $cat['cat_title'];
                    echo $cat_title ;
                  endwhile;
                  ?>
              </a> 
              Posted by <?=$post_author?> at <?=$post_date?>
            </span>
            <p>
            <?=$post_contents?>
            </p>
            <!--  -->
            <span><a href="single.php?id=<?=$post_id?>" class="d-block">See more &rarr;</a></span>
            <!--  -->
          </div>
        </div><!-- 1 -->


        <?php   endwhile; ?>

      </section><!-- main -->




      <ul class="pagination px-5">
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item active">
          <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
        </li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#">Next</a>
        </li>
      </ul>

      <?php 
require_once('includes/footer.php');
?>