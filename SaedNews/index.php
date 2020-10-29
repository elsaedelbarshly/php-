<!-- header.php -->
<!-- navigation.php -->
<?php
require_once('./includes/header.php');
require_once('./includes/navigation.php');
?>

<?php
// pagination
$sql = "SELECT * FROM `posts` ";
$stmt = $pdo->prepare($sql);
$stmt ->execute();

$post_count = $stmt->rowCount();  //all posts count
//echo $post_count ;
$post_per_page = 1;               // count posts per one page
// $total_pager = $post_count / $post_per_page ;  // generate number pages
$total_pager = ceil($post_count / $post_per_page)  ;  

if(isset($_GET['page'])){
  $page = $_GET['page'];
  // echo ' page is :  '.$page;
  if($page== 1){
    $page_id = 0 ;
  }else{
    $page_id = ($post_per_page * $page) - $post_per_page ;
  }
  //
}//if isset page
//if is not set page
else{
  $page_id = 0 ;
  $page =1 ;
}
?>
      <section id="main" class="mx-5">
        <h2 class="my-3">All Posts</h2>
<?php
  $sql = "SELECT * FROM `posts`  LIMIT $page_id , $post_per_page ";
  $stmt = $pdo->prepare($sql);
  $stmt ->execute();
  // $count = $stmt->rowCount();
  // echo $count;
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

        <?php endwhile;?>

      </section><!-- #main -->

      <!-- pagination -->
<?php if($post_count > $post_per_page){ ?>

  <ul class="pagination px-5">

<!-- Previous -->
<?php if($page_id == 0){ ?> 
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
        <?php }else{ ?>
          <li class="page-item">
          <a class="page-link" href="index.php?page=<?=$page_id?>" tabindex="-1">Previous</a>
        </li>
     <?php   } ?>
<!-- Pages -->
<?php for($i=1; $i<=$total_pager;$i++): ?> 

  <?php 
  if($i == $page_id +1){ ?>
    <li class="page-item active"><a class="page-link" href="index.php?page=<?=$i?> "> <?= $i ?> </a></li>
  <?php } else {?>
    <li class="page-item "><a class="page-link" href="index.php?page=<?=$i?> "> <?= $i ?> </a></li>
    <?php } ?>

<?php endfor; ?>

<!-- Next -->
<?php
$next = $page_id +2;
if($page_id+1 == $total_pager){?> 
     <li class="page-item">
          <a class="page-link disabled" href="#">Next</a>
        </li>
<?php

}else{ ?>
  <li class="page-item">
          <a class="page-link" href="index.php?page=<?=$next?>">Next</a>
        </li>
        <?php
}
?>
   

      </ul>

<?php } ?>
     
<!-- End pagination -->


<!--  Footer -->
<?php 
require_once('includes/footer.php');
?>