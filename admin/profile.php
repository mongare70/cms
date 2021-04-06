<?php include "includes/admin_header.php"; ?>
    
   <?php
        if(isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            
            $query = "SELECT * FROM users WHERE username = '{$username}'";
            
            $select_user_profile_query = mysqli_query($connection, $query);
            
            while($row = mysqli_fetch_assoc($select_user_profile_query)) {
                $user_id = $row['user_id'];
                $username = $row['username'];
                $firstname = $row['user_firstname'];
                $lastname = $row['user_lastname'];
                $email = $row['user_email'];
                $image = $row['user_image'];
                $role = $row['user_role'];
                $password = $row['user_password'];
                $user_date = $row['user_date'];
            }
        }
    ?> 

    <div id="wrapper">

        <!-- Navigation -->
         <?php include "includes/admin_navigation.php"; ?>
          

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                         <h1 class="page-header">
                            Welcome to Admin
                            <small>Author</small>
                        </h1>
                          
                          <?php 

    if(isset($_POST['edit_user'])){
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_role = $_POST['user_role'];
        $username = $_POST['username'];
        
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];
        $user_date = date('d-m-y');
        
        $query = "UPDATE users SET ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$user_password}' ";
        $query .= "WHERE username = '{$username}' ";
        
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
        <input type="submit" type="submit" class="btn btn-primary" name="edit_user" value="Update Profile">
    </div>
    
</form>
                           
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        
        <!-- /#page-wrapper -->
        <?php include "includes/admin_footer.php"; ?>
