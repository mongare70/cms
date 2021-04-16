<?php 

    if(isset($_GET['edit_user'])){
        $the_user_id = escape($_GET['edit_user']);
        
        $query = "SELECT * FROM users WHERE user_id = $the_user_id";
        $select_users_query = mysqli_query($connection, $query);
        confirmQuery($select_users_query);
        
        while($row = mysqli_fetch_assoc($select_users_query)){
                $user_id = escape($row['user_id']);
                $username = escape($row['username']);
                $firstname = escape($row['user_firstname']);
                $lastname = escape($row['user_lastname']);
                $email = escape($row['user_email']);
                $image = escape($row['user_image']);
                $password = escape($row['user_password']);
                $role = escape($row['user_role']);
                $user_date = escape($row['user_date']);
        }
     

			if(isset($_POST['edit_user'])){
				$user_firstname = escape($_POST['user_firstname']);
				$user_lastname = escape($_POST['user_lastname']);
				$user_role = escape($_POST['user_role']);
				$username = escape($_POST['username']);

				$user_image = escape($_FILES['image']['name']);
				$user_image_temp = escape($_FILES['image']['tmp_name']);

				$user_email = escape($_POST['user_email']);
				$user_password = escape($_POST['user_password']);
				$user_date = escape(date('d-m-y'));

				//function to move image to temporary location
				move_uploaded_file($user_image_temp, "../images/user_images/$user_image");

				//Encrypting Password
				$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost'=> 10));

		//		$query = "SELECT randsalt FROM users";
		//		$select_randsalt_query = mysqli_query($connection, $query);
		//		if(!$select_randsalt_query){
		//			die("Query Failed!" . mysqli_error($connection));
		//		}
		//		
		//		$row = mysqli_fetch_array($select_randsalt_query);
		//		$salt = $row['randsalt'];
		//		$hashed_password = crypt($user_password, $salt);

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
		
		} else {
		header("Location: index.php");
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
            <option value="<?php echo $role?>"><?php echo $role?></option>
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
        <input autocomplete="off" type="password" class="form-control" name="user_password">
    </div>
    <br>
    <div class="form-group">
        <input type="submit" type="submit" class="btn btn-primary" name="edit_user" value="Update User">
    </div>
    
</form>