<?php include('includes/admin-header.php'); ?>
<?php 
  if(!isset($_COOKIE['userAuth'])){
    header("Location:sign-in.php");
  }
?>
    <div class="fluid-container">
    <?php include('includes/admin-navigation.php'); ?>       

        <section id="main" class="mx-lg-5 mx-md-2 mx-sm-2 pt-3">
            <h2 class="pb-3">Add New Post</h2>

<!-- insert Code -->

<?php
if(isset($_POST['create-post'])){
   $post_title = $_POST['post-title'];
   $post_author = $_POST['post-author'];
   $post_cat_id = $_POST['cat-id'];

   $post_status = $_POST['post-status'];
   $post_content = $_POST['post-content'];
   $post_date = date('j F Y');

   $post_image = $_FILES['post-image']['name'];
   $post_temp_image = $_FILES['post-image']['tmp_name'];
   move_uploaded_file($post_temp_image,"../img/$post_image");

   if(empty($post_title) || empty($post_author)  ||  empty($post_cat_id)  ||  empty($post_status)  ||  empty($post_content) ||  empty($post_image) ){
        echo "<div class='alert alert-danger'> Field Cant be Empty </div>";
   }else{
     $sql = "
     INSERT INTO `posts`
     (`post_title`, `post_contents`, `post_image`, `post_author`, `post_date`, `post_status`,  `post_cat_id`) 
     VALUES 
     ('$post_title','$post_content','$post_image','$post_author','$post_date','$post_status','$post_cat_id') ";

     $stmt = $pdo->prepare($sql);
      $stmt ->execute();
      echo "<div class='alert alert-success'> Post Created Successfuly </div>";
   }//else
}//if isset
?>
            <form action="new-post.php" method="post" enctype="multipart/form-data">
            
                <div class="form-group">
                    <label for="post-title">Post Title</label>
                    <input type="text" class="form-control" name="post-title" id="post-title" placeholder="Enter post title">
                </div>

                <div class="form-group">
                    <label for="post-author">Post Author</label>
                    <input type="text" class="form-control" name="post-author" id="post-author" placeholder="Enter post author">
                </div>

                <div class="form-group">
                    <label for="category">Select Category</label>
                    <select class="form-control" id="category" name="cat-id">
                    <?php 
                  $sql1 = " SELECT * FROM `categories` ";
                  $stmt1 = $pdo->prepare($sql1);
                  $stmt1 ->execute([':id'=>$post_cat_id]);

                  while( $cat =  $stmt1->fetch(PDO::FETCH_ASSOC) ) :
                    $cat_id = $cat['cat_id'];
                    $cat_title = $cat['cat_title'];
                    echo "<option value=$cat_id > $cat_title </option>" ;
                  endwhile;
                  ?> 
                    </select>
                </div>

                <div class="form-group">
                    <label for="category">Post Status</label>
                    <select class="form-control" name="post-status" id="post-status">
                        <option value="published">Publish</option>
                        <option value="draft" >Draft</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="post-image">Upload post image</label>
                    <input type="file" class="form-control-file" name="post-image" id="post-image">
                </div>

                <div class="form-group">
                    <label for="post-content">Post Content</label>
                    <textarea class="form-control" name="post-content" id="post-content" rows="6" placeholder="Your post content"></textarea>
                </div>

                <button type="submit" name="create-post" class="btn btn-primary">Submit</button>
            </form>
        </section>

    </div>
    <?php include('includes/admin-footer.php'); ?>