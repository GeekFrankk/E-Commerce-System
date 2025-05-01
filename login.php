<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

@ $db = new mysqli('localhost', 'deegann1_AllUser', 'AllUserPassword', 'deegann1_project');

  if (mysqli_connect_errno()) {
     echo '<div class="container"><p>Error: Could not connect to database. Please try again later.</p></div>';
     exit;
  }
  
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $db->prepare("SELECT u.id, u.password, u.user_type, e.role 
                          FROM users u 
                          LEFT JOIN employees e ON u.id = e.user_id 
                          WHERE u.email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($userId, $hashed_pass, $user_type, $role);
    
    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_pass)) {
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $email;
            $_SESSION["user_type"] = $user_type;
            $_SESSION["userId"] = $userId;
            $_SESSION["role"] = $role; 
    
            if ($user_type === 'employee') {
                if ($role === 'admin') {
                    header("Location: admin.html");
                } elseif ($role === 'manager') {
                    header("Location: manager_products.php");
                } elseif ($role === 'business_owner') {
                    header("Location: owner_main.html");
                } else {
                    $error = "Unknown employee role.";
                }
            } else {
                header("Location: main.html");
            }
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }
    $stmt->close();
}

$db->close();

?>