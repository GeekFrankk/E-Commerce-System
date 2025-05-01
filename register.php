<?php
@ $db = new mysqli('localhost', 'deegann1_AllUser', 'AllUserPassword', 'deegann1_project');

  if (mysqli_connect_errno()) {
     echo '<div class="container"><p>Error: Could not connect to database. Please try again later.</p></div>';
     exit;
  }
  
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $user_type = $_POST['user_type'];
  
  $db->begin_transaction();

  try {
    $stmt = $db->prepare("INSERT INTO users (fname, lname, email, password, user_type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $fname, $lname, $email, $password, $user_type);
    $stmt->execute();

    $user_id = $db->insert_id;

    if ($user_type == 'employee' && !empty($_POST['employee_role'])) {
        $employee_role = $_POST['employee_role'];
        $stmt2 = $db->prepare("INSERT INTO employees (user_id, role) VALUES (?, ?)");
        $stmt2->bind_param("is", $user_id, $employee_role);
        $stmt2->execute();
    }

    $db->commit();
    
    echo '<script>
        alert("Registration successful!");
        window.location.href= "login_page.html";
        </script>';
    
    } catch (Exception $e) {
        $db->rollback();
        
        echo "Error: " . $e->getMessage();
  }

  $db->close();
?>


  