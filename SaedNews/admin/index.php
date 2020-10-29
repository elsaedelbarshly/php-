<?php include('includes/admin-header.php'); ?>

<?php 
  if(!isset($_COOKIE['userAuth'])){
    header("Location:sign-in.php");
  }
?>

<div class="fluid-container">
<?php include('includes/admin-navigation.php'); ?>
     

      <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2">
        <div class="d-flex flex-row justify-content-between">
            <h2 class="my-3">All Posts</h2>
            <a class="btn btn-secondary align-self-center d-block" href="new-post.php">Add New Post</a>
        </div>
        
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Post Title</th>
                <th scope="col">Post Category</th>
                <th scope="col">Post Status</th>
                <th scope="col" class="d-none d-md-table-cell">Comments</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
                </tr>
            </thead>

            <tbody>
<?php
 $sql = " SELECT * FROM posts ";
 $stmt = $pdo->prepare($sql);
 $stmt->execute();

 $count = $stmt->rowCount();
if($count == 0){
  echo "<div class='alert alert-danger'> NO POSTS </div>"; 
}else{
  while( $post =  $stmt->fetch(PDO::FETCH_ASSOC)):
    $post_id = $post['post_id'];
    $post_title = $post['post_title'];
    $post_cat_id = $post['post_cat_id'];
    $post_status = $post['post_status'];
    $post_comments = $post['post_comments'];
?>
  <tr>
                <th><?=$post_id?></th>
                <td><?=$post_title?></td>

                <td>
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
              </td>

<!--                     NOT Complate                           -->
<!--                     NOT Complate                           -->
                <td><?=$post_status?></td>
                <td class="d-none d-md-table-cell">
                  <a href="comments.php"><?=$post_comments?></a>
                </td>
               
                <td>
                    <form action="#" method="POST">
                        <button>Edit</button>
                    </form>
                </td>


                <td>
                    <form action="index.php" method="POST">
                      <input type="hidden" name="val" value="<?=$post_id?>">
                        <button type="submit" name="delete_post" class="btn btn-danger">Delete</button>
                    </form>               
                </td>


                </tr>
<?php
  endwhile;
}//else


?>
              

              <?php
if(isset($_POST['delete_post'])){
  $pid = $_POST['val'];
  $sql_del = "DELETE FROM `posts` WHERE `post_id` = $pid";
  $post_delete = $pdo->prepare($sql_del);
  $post_delete ->execute();
  header("Location:index.php");
}
?>               
            </tbody>
        </table>
    
      </section>

      <ul class="pagination px-lg-5">
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item active">
          <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#">Next</a>
        </li>
      </ul>

    </div>

<?php include('includes/admin-footer.php'); ?>