<?php
require_once('./includes/header.php');
require_once('./includes/navigation.php');
?>
<section id="main">
  <div class="post-single-information">

    <?php
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
      $sql = "SELECT * FROM `posts` WHERE `post_id` =$id ";
      $stmt = $pdo->prepare($sql);
      $stmt->execute();

      $count = $stmt->rowCount();
      //echo $count;
      if ($count == 0) {
        echo "<h1 class='alert alert-danger text-center my-5'> NO POST FOUND </h1>";
      } else {
        while ($post =  $stmt->fetch(PDO::FETCH_ASSOC)) :
          $post_id = $post['post_id'];
          $post_title = $post['post_title'];
          $post_contents = $post['post_contents'];
          // $post_contents = substr($post['post_contents'],0,200) ;
          $post_image = $post['post_image'];
          $post_author = $post['post_author'];
          $post_date = $post['post_date'];
          $post_status = $post['post_status'];
          $post_cat_id = $post['post_cat_id'];
    ?>

          <div class="post-single-info">
            <div class="post-single-80">
              <h1 class="category-title">Category:

                <?php
                $sql1 = " SELECT * FROM `categories` WHERE cat_id =$post_cat_id ";
                $stmt1 = $pdo->prepare($sql1);
                $stmt1->execute();
                while ($cat =  $stmt1->fetch(PDO::FETCH_ASSOC)) :
                  $cat_id = $cat['cat_id'];
                  $cat_title = $cat['cat_title'];
                  echo $cat_title;
                endwhile;

                ?>

              </h1>
              <h2 class="post-single-title"><?= $post_title ?></h2>
              <div class="post-single-box">
                Posted by <?= $post_author ?> at <?= $post_date ?>
              </div>
            </div>
          </div>

          <div class="post-main">
            <img class="d-block" style="width:100%;height:400px" src="./img/<?= $post_image ?>" alt="photo" />
            <p class="mt-4">
              <?= $post_contents ?>
            </p>
          </div>

    <?php
        endwhile;
      } //else
    } //if isset
    ?>

  </div><!-- post-single-information -->




  <div class="comments">
    <?php
    $sql2 = "SELECT * FROM `comments` WHERE comment_post_id = $id  ";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute();
    $count = $stmt2->rowCount();
    if ($count == 0) {
      echo '<h1 class="text-center text-danger"> NO COMMENTS</h1>';
    } else {
      echo '<h2 class="comment-count"> ' . $count . ' Comments</h2>';
    }

    while ($comment =  $stmt2->fetch(PDO::FETCH_ASSOC)) :
      $comment_author = $comment['comment_author'];
      $comment_date = $comment['comment_date'];
      $comment_desc = $comment['comment_desc'];
    ?>
      <div class="comment-box">
        <img src="./img/js.png" style="width:88px;height:88px;border-radius:50%" alt="Author photo" class="comment-photo">
        <div class="comment-content">
          <span class="comment-author"><b> <?= $comment_author ?></b></span>
          <span class="comment-date"><?= $comment_date ?></span>
          <p class="comment-text"> <?= $comment_desc ?> </p>
        </div>
      </div>
    <?php endwhile; ?>

    <h3 class="leave-comment">Leave a comment</h3>
    <?php
    if (isset($_POST['submit-comment'])) {
      $name = $_POST['name'];
      $comment = $_POST['comment'];
      $date = date('j Y F');

      if (empty($name)  || empty($comment)) { ?>

        <div class="alert alert-danger">
          <strong>Danger!</strong> Please fill this form.
        </div>

    <?php } else { //if empty
$sql4 = "
INSERT INTO `comments`
(`comment_desc`, `comment_author`, `comment_date`, `comment_post_id`)
VALUES
('$comment','$name','$date','$id')
  ";
$stmt4 = $pdo->prepare($sql4);
$stmt4->execute();


$sql5 = " UPDATE `posts` SET `post_comments`= `post_comments`+1 WHERE `post_id` = '$id' ";
$stmt5 = $pdo->prepare($sql5);
$stmt5->execute();

header("Location:single.php?id=$id");
      }
    } // if isset


    ?>
    <div class="comment-submit">
      <form action="http://localhost/ZienhomNews/single.php?id=<?= $id ?>" class="comment-form" method="post">
        <input class="input" type="text" name="name" placeholder="Enter Full Name">
        <textarea name="comment" id="" cols="20" rows="5" placeholder="Comment text"></textarea>
        <input type="submit" value="Submit" name="submit-comment" class="comment-btn">
      </form>
    </div>
  </div>
</section>

<?php
require_once('includes/footer.php');
?>