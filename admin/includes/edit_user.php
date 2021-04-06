<?php 

    if(isset($_GET['edit_user'])){
        $the_user_id = $_GET['edit_user'];
        
        $query = "SELECT * FROM users WHERE user_id = $the_user_id";
        $select_users_query = mysqli_query($connection, $query);
        confirmQuery($select_users_query);
        
        while($row = mysqli_fetch_assoc($select_users_query)){
                $user_id = $row['user_id'];
                $username = $row['username'];
                $firstname = $row['user_firstname'];
                $lastname = $row['user_lastname'];
                $email = $row['user_email'];
                $image = $row['user_image'];
                $password = $row['user_password'];
                $role = $row['user_role'];
                $user_date = $row['user_date'];
        }
        
    }


    if(isset($_POST['edit_user'])){
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];
        
        $user_image = $_FILES['image']['name'];
        $user_image_temp = $_FILES['image']['tmp_name'];
        
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        $user_date = date('d-m-y');
        
        //function to move image to temporary location
        move_uploaded_file($user_image_temp, "../images/user_images/$user_image");
        
        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$user_password}', ";
        $query .= "user_date = now(), ";
        $query .= "user_image = '{$user_image}' ";
        $query .= "WHERE user_id = {$the_user_id} ";
        
        $update_user = mysqli_query($connection, $query);
        confirmQuery($update_user);
    }
?>
   
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" value="<?php echo $firstname; ?>" class="form-control" name="user_firstname">
    </div>
    <br>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" value="<?php echo $lastname; ?>" class="form-control" name="user_lastname">
    </div>
    <br>
    <div class="form-group">
        <select name="user_role" id="user_role">
            <option value="subscriber"><?php echo $role?></option>
            <?php 
                if($role == 'admin'){
                    echo "<option value='subscriber'>subscriber</option>";
                }
                else{
                    echo "<option value='admin'>admin</option>";
                }
            ?>
        </select>
    </div>
    <br>
    <div class="form-group">
        <label for="user_image">User Image</label>
        <img width="100" src="../images/user_images/<?php echo $image; ?>" alt="">
        <input type="file" name="image">
    </div>
    <br>
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
    </div>
    <br>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" value="<?php echo $email; ?>" class="form-control" name="user_email">
    </div>
    <br>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" value="<?php echo $password; ?>" class="form-control" name="user_password">
    </div>
    <br>
    <div class="form-group">
        <input type="submit" type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>
    
</form>