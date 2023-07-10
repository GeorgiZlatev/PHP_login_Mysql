<?php 
    require_once 'includes/header.php';
?>

<div>
        <h1>Log in</h1>
    <p> No account? <a href="register.php"> Register here!</a></p>

    <form action="" method="post">
        <input type="text" name="username" placeholder="Username">   <input type="password" name="password" placeholder="Password">
<!--        <input type="email" name="email" placeholder="Email">-->
        <button type="submit">Login</button>
    </form>
</div>

<?php 
    require_once 'includes/footer.php';
 ?>
