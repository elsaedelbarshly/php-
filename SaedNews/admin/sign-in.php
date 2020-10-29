<?php include('includes/admin-header.php'); ?>

<?php 
  if(isset($_COOKIE['userAuth'])){
    header("Location:index.php");
  }
?>

    <div class="container">
        <h2 class="text-uppercase mt-5 sign-in" style="text-align:center">Sign In</h2>

<?php
if(isset($_POST['submit'])){
    $user_name = $_POST['user-name'];
    $user_email = $_POST['user-email'];
    $user_password = $_POST['user-password'];

    if (empty($user_name) || empty($user_email)  || empty($user_password)  ){
        echo "<div class='alert alert-danger'>  Fields can not Empty </div>";
    }else{
        $sql = " SELECT * FROM users ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        while( $user =  $stmt->fetch(PDO::FETCH_ASSOC)){
            $name = $user['user_name'];
            $email = $user['user_email'];
            $password = $user['user_password'];

            // echo $name . ' ' .$email  . ' '.  $password ;

            if($user_name == $name &&  $user_email == $email  && $user_password == $password ){
                //code true
                //echo "<div class='alert alert-success'> Welcome </div>";
                setcookie('userAuth',md5(1),time()+60*200,"","","",true);
                header("Location:index.php");
            }else{
                echo "<div class='alert alert-danger'> Wrong Credintials </div>";
            }
        }
    }
}
?>

        <form class="py-2 d-flex justify-content-center flex-column" method="POST" action="sign-in.php">
            <div class="form-group m-3">
                <label for="username">Username</label>
                <input type="text" name="user-name" class="form-control" id="username" placeholder="Enter Username">
            </div>
            <div class="form-group m-3">
                <label for="email">Email address</label>
                <input type="email"  name="user-email" class="form-control" id="email" placeholder="Enter Email Address">
            </div>
            <div class="form-group m-3">
                <label for="password">Password</label>
                <input type="password"  name="user-password" class="form-control" id="password" placeholder="Enter Password">
            </div>
            <button type="submit" name="submit" class="btn btn-primary m-3 align-self-end">SIGN IN</button>
        </form>
    </div>

    <?php include('includes/admin-footer.php'); ?>
