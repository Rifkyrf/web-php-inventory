<?php
// app/controllers/AuthController.php
class AuthController {
    
    public function isLoggedIn() {
        return isset($_SESSION['login']) && $_SESSION['login'] === true;
    }
    
    public function login($email, $password) {
        global $conn;
        
        $email = mysqli_real_escape_string($conn, $email);
        $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        
        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['user_email'] = $user['email'];
                return true;
            }
        }
        return false;
    }
    
    public function logout() {
        session_start();
        session_destroy();
        header("Location: login.php");
        exit;
    }
}
?>