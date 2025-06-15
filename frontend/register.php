<?php
 include '../dbconnect.php';
 session_start();
 $errors = [];

 if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['userName']);
    $email = htmlspecialchars($_POST['userEmail']);
    $password = htmlspecialchars($_POST['userPassword']);
    $confirmPassword = htmlspecialchars($_POST['userConfirmPassword']);

    //echo $name . ',' . $email. ',' . $password . ',' . $confirmPassword;  

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([
        'email' => $email
    ]);
    $user = $stmt->fetch();

    if($password != $confirmPassword) {
        $errors['password'] = 'Password not match';
       // header('Location: register.php');
       // exit();
    } else  if ($user) {
        $errors['email'] = 'Email already exist';
        //header('Location: register.php');
        //exit();
       
    } else {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt -> execute ([
            'name' => $name,
            'email' => $email, 
            'password' => $hashedPassword
        ]);
        header('Location: login.php');
    }
 }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Blog Home - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <?php include 'navbar.php'; ?>
        <!-- Page header with logo and tagline-->
        <!-- Page content-->
        <div class="container py-5">
            <div class="row justify-content-md-center">
                <!-- Blog entries-->
                <div class="col-lg-6">
                    <h3>Register</h3>
                    <form action="#" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInputNmae" placeholder="Name" name="userName" required >
                            <label for="floatingInputName">Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="userEmail" required>
                            <label for="floatingInput">Email address</label>
                            <div class="text-danger">
                                <?php if (isset($errors['email'])) {echo $errors['email']; } ?>
                            </div>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="userPassword" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingConfirmPassword" placeholder="Confirm Password" name="userConfirmPassword" required>
                            <label for="floatingConfirmPassword">Confirm Password</label>
                            <div class="text-danger">
                                <?php if (isset($errors['password'])) {echo $errors['password']; } ?>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit">Register</button>
                        </div>
                    </form>   
                </div>      
            </div>
        </div>
        <!-- Footer-->
          <?php include 'footer.php'; ?>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
