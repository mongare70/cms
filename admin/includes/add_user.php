<?php 
    if(isset($_POST['create_user'])){
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];
        
        $user_image = $_FILES['image']['name'];
        $user_image_temp = $_FILES['image']['tmp_name'];
        
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        $user_date = date('d-m-y');
        $randsalt = "xxx";
        
        //function to move image to temporary location
        move_uploaded_file($user_image_temp, "../images/user_images/$user_image");
        
        $query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_image, user_email, user_password, user_date, randsalt )";
        
        $query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_image}', '{$user_email}', '{$user_password}', now(), '{$randsalt}' )";
        
        $create_user_query = mysqli_query($connection, $query);
        confirmQuery($create_user_query);
    }
?>
   
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>
    <br>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>
    <br>
    <div class="form-group">
        <select name="user_role" id="user_role">
            <!-- Default -->
            <option value="subscriber">Select Options</option>
            
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
    <br>
    <div class="form-group">
        <label for="user_image">User Image</label>
        <input type="file" name="image">
    </div>
    <br>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>
    <br>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>
    <br>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>
    <br>
    <div class="form-group">
        <input type="submit" type="submit" class="btn btn-primary" name="create_user" value="Add User">
    </div>
    
</form>