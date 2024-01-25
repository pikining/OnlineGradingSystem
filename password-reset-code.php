<?php
    session_start();
    include('includes/dbconnection.php'); 
    error_reporting(0);
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    //Load Composer's autoloader
    require 'vendor/autoload.php';
    
    function send_password_reset($get_name,$get_email,$token){
        $mail = new PHPMailer(true);
        $mail ->SMTPDebug =2;
        
        $mail->isSMTP();       
        $mail->Host       = 'smtp.gmail.com';                                     //Send using SMTP
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        
                            //Set the SMTP server to send through
        $mail->Username   = 'danielajoycortez@gmail.com';                     //SMTP username
        $mail->Password   = 'ugxnjnlwemxzzplz';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('danielajoycortez@gmail.com', $get_name);
        $mail->addAddress($get_email);  
        $mail->addReplyTo('danielajoycortez@gmail.com', 'DONOTREPLY');
    
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Reset Password Notification";
        
        $email_template ="
            <h2>Hello</h2>
            <h3>You are receiving this email because we received a password reset request for your account.</h3>
            <br/><br/>
            <a href='https://mies-gvs.website/password_change.php?token=$token&email=$get_email'> Click Me </a>
        ";
        $mail->Body = $email_template;
        $mail->send();
    }
    
    
    if(isset($_POST['password_reset_link'])){
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $token = md5(rand());
        date_default_timezone_set("Asia/Singapore");
        $expiration = date('Y-m-d H:i:s', time() + (4 * 60 * 60)); // 4 hours in seconds
        
        $check_email= "SELECT * FROM tbladmin WHERE emailAddress='$email' LIMIT 1";
        $check_email_run= mysqli_query($con,$check_email);
        
        if(mysqli_num_rows($check_email_run) > 0){
            $row = mysqli_fetch_array($check_email_run);
            $get_name =$row['fullName'];
            $get_email =$row['emailAddress'];
            
            $update_token ="UPDATE tbladmin SET verify_token='$token',token_expire='$expiration' WHERE emailAddress='$get_email' LIMIT 1";
            $update_token_run =mysqli_query($con, $update_token);
            
            if($update_token_run){
                send_password_reset($get_name,$get_email,$token);
                $_SESSION['status'] ="We emailed you a password ret link.";
            header("Location: password-reset.php");
            exit(0);
            }
            else{
                $_SESSION['status'] ="Something went wrong!";
            header("Location: password-reset.php");
            exit(0);
            }
        }
        
        else{
            $_SESSION['status'] ="No Email Found!";
            header("Location: password-reset.php");
            exit(0);
        }
    }



    if(isset($_POST['password_update']))
    {
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
        $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);
        $re = "/^(?=.*[a-z])(?=.*\\d).{8,}$/i"; 
    
        $token = mysqli_real_escape_string($con, $_POST['password_token']);
    
        if(!empty($token))
        {
            if(!empty($email) && !empty($new_password) && !empty($confirm_password))
            {
                // Checking Token is Valid or not
                $check_token = "SELECT verify_token, token_expire FROM tbladmin WHERE verify_token='$token' LIMIT 1";
                $check_token_run = mysqli_query($con, $check_token);
                $token_data = mysqli_fetch_assoc($check_token_run);
    
                if (mysqli_num_rows($check_token_run) > 0) 
                {
                    $token_expire = new DateTime($token_data['token_expire'], new DateTimeZone('Asia/Singapore'));
                    $current_time = new DateTime();
                    if ($token_expire > $current_time)
                    {
                        if(preg_match($re, $new_password))
                        {
                            if($new_password == $confirm_password)
                            {
                                // Hash the password before storing it in the database
                                $update_password = mysqli_query($con,"UPDATE tbladmin SET staffpass='$new_password' WHERE verify_token='$token' LIMIT 1");
        
                                if($update_password)
                                {
                                    $new_token = md5(rand()). "funda";
                                    $update_to_new_token = mysqli_query($con,"UPDATE tbladmin SET verify_token='$new_token' WHERE emailAddress='$email' LIMIT 1");
                                    $_SESSION['status'] = "New Password Successfully Updated!";
                                    header("Location: index.php");
                                    exit(0);
                                }
                                else
                                {
                                    $_SESSION['status'] = "Did not update password. Something went wrong.";
                                    header("Location: password_change.php?token=$token&email=$email");
                                    exit(0);
                                }
                            }
                            else
                            {
                                $_SESSION['status'] = "Password and Confirm Password does not match.";
                                header("Location: password_change.php?token=$token&email=$email");
                                exit(0);
                            }
                        }
                        else{
                            $_SESSION['status'] = "Password must contain 8 characters, 1 uppercase, 1 lowercase , 1 number and 1 special character.";
                                header("Location: password_change.php?token=$token&email=$email");
                                exit(0);
                        }
                    }
                    else 
                    {
                        $_SESSION['status'] = "Token has expired.";
                        header("Location: password_change.php");
                        exit(0);
                    }
                }
                else
                {
                    $_SESSION['status'] = "Invalid Token.";
                    header("Location: password_change.php?token=$token&email=$email");
                    exit(0);
                }
            }
            else
            {
                $_SESSION['status'] = "All Field are Mandetory.";
                header("Location: password_change.php?token=$token&email=$email");
                exit(0);
            }
        }
        else
        {
            $_SESSION['status'] = "No Token Available";
            header("Location: password_change.php");
            exit(0);
        }
        
    }
?>