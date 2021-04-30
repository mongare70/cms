<?php
	
	//Query function
	function query($query){
		global $connection;
		return mysqli_query($connection, $query);
	}
	
	//function to check whether query failed or not
	function confirmQuery($result) {
        global $connection;
        if(!$result){
            die("Query failed!" . " " . mysqli_error($connection));
        }
    }
	

	//Function to check if a user has logged in
	function isLoggedIn(){
		session_start();
		if(isset($_SESSION['user_role'])){
			
			session_abort();
			return true;
			
		}
		session_destroy();
		return false;
		
	}

	
	//function that returns the ID of a logged in user
	function loggedInUserId(){
		
		if(isLoggedIn()){
        $result = query("SELECT * FROM users WHERE username='" . $_SESSION['username'] ."'");
        //confirmQuery($result);
        $user = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
    }
    return false;
		
	}

	
	function userLikedThisPost($post_id){
		
		$result = query("SELECT * FROM likes WHERE user_id=" .loggedInUserId() . " AND post_id={$post_id}");
    	//confirmQuery($result);
    	return mysqli_num_rows($result) >= 1 ? true : false;
	
	}


	function image_placeholder($image=null) {
		
		if(!$image){
			
			return "image_4.jpg";
			
		} else {
			
			return $image;	
			
		}
 		 
	}

	function getPostLikes($post_id){
		
		$result = query("SELECT * FROM  likes WHERE post_id = {$post_id}");
		
		confirmQuery($result);
		
		echo mysqli_num_rows($result);
		
	}


	function checkStatus($table, $column, $status){
		global $connection;
		$query = "SELECT * FROM $table WHERE $column = '{$status}'";
        $select_all = mysqli_query($connection, $query);
		return mysqli_num_rows($select_all);
	}

	function checkUserRole($table, $column, $role){
		global $connection;
		$query = "SELECT * FROM $table WHERE $column = '{$role}'";
        $select_all = mysqli_query($connection, $query);
		return mysqli_num_rows($select_all);
	}


	
	function recordCount($table){
		global $connection;
		$query = "SELECT * FROM " . $table;
        $select_all = mysqli_query($connection, $query);
		$result = mysqli_num_rows($select_all);
		
		confirmQuery($result);
		return $result;
	}

	
	//function to escape string
	function escape($string){
		global $connection;
		return mysqli_real_escape_string($connection, trim($string));
	}

	function users_online(){
		
		if(isset($_GET['onlineusers'])){
		
			global $connection; 
			
			if(!$connection){
				
				session_start();
				
				include("../includes/db.php");
				
				$session = session_id();
				$time = time();
				$time_out_in_seconds = 05;

				$time_out = $time - $time_out_in_seconds;

				$query = "SELECT * FROM users_online WHERE session = '{$session}'";
				$send_query = mysqli_query($connection, $query);
				$count = mysqli_num_rows($send_query);

					if($count == NULL){
						
						mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('{$session}', '{$time}')");
					
					} else {
						
						mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
					
					}

				$users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '{$time_out}'");
				echo $count_user = mysqli_num_rows($users_online_query);
				
			}
			
		} //get request isset()
	}

	users_online();


    function insert_categories() {
        
		if(isset($_POST['submit'])){
			
            global $connection;
            
			$cat_title = $_POST['cat_title'];
            
			if($cat_title == "" || empty($cat_title)){
               
				echo "This field should not be empty";
            
			} else {
				
				//Using prepared statement
				$stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?) ");
				
				//s = string
				mysqli_stmt_bind_param($stmt, 's', $cat_title);
				
				mysqli_stmt_execute($stmt);

                confirmQuery($stmt);
				
				mysqli_stmt_close($stmt);
            
			}
        }
    }
    
    function findAllCategories() {
        global $connection;
        $query = "SELECT * FROM categories";
        $categories = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($categories)){
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];
            echo "<tr>";
            echo "<td>{$cat_id}</td>";
            echo "<td>{$cat_title}</td>";
            echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
            echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
            echo "</tr>";
        }
    }

    function deleteCategory() {
        if(isset($_GET['delete'])){
            global $connection;
            $the_cat_id = $_GET['delete'];
            $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
            $delete_query = mysqli_query($connection, $query);
            header("Location: categories.php"); //Function to refresh the page
        }
    }

	function current_user(){
		if(isset($_SESSION['username'])){
			
			return $_SESSION['username'];
			
		}
		
		return false;
	}

	
	
	//Check if logged in user is an admin
	function is_admin($username=''){
		global $connection;
		
		if($username == null){
			return false;
		}
		
		$query = "SELECT user_role FROM users WHERE username = '{$username}' ";
		$result = mysqli_query($connection, $query);
		confirmQuery($result);
		
		$row = mysqli_fetch_array($result);
		if($row['user_role'] == 'admin'){
			return true;
		} else {
			return false;
		}
	}
	
	//Check if username exists on registration
	function username_exists($username){
		global $connection;
		
		$query = "SELECT username FROM users WHERE username = '{$username}' ";
		$result = mysqli_query($connection, $query);
		confirmQuery($result);
		
		if(mysqli_num_rows($result) > 0){
			return true;
		} else {
			return false;
		}
	}
	
	//Check if email exists on registration
	function email_exists($email){
			global $connection;

			$query = "SELECT user_email FROM users WHERE user_email = '{$email}' ";
			$result = mysqli_query($connection, $query);
			confirmQuery($result);

			if(mysqli_num_rows($result) > 0){
				return true;
			} else {
				return false;
			}
		}
	
	//Function to redirect to a specified page
	function redirect($location){
		
		return header("Location:" . $location);
		exit;
	}


	function ifItIsMethod($method=null){
		
		if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
			
			return true;
		
		}
		
		return false;
	
	}



	function checkIfUserIsLoggedInAndRedirect($redirectLocation = null){
		
		if(isLoggedIn()){
			
			redirect($redirectLocation);
			
		}
		
	}


	//Function to register new user
	function register_user($username, $email, $password){
		
		global $connection;
		
		//mysqli_real_escape_string() == used to prevent sql injection by hackers
		$username = mysqli_real_escape_string($connection, $username);
		$email = mysqli_real_escape_string($connection, $email);
		$password = mysqli_real_escape_string($connection, $password);

		//Encrypting Password
		$password = password_hash($password, PASSWORD_BCRYPT, array('cost'=> 12));

//				$query = "SELECT randsalt FROM users";
//				$select_randsalt_query = mysqli_query($connection, $query);
//
//				if(!$select_randsalt_query){
//					die("Query Failed!!" . mysqli_error($connection));
//				}

//				//Encrypting Password
//				$row = mysqli_fetch_array($select_randsalt_query);
//				$salt = $row['randsalt'];
//				$password = crypt($password, $salt);

		$query = "INSERT INTO users (username, user_email, user_password, user_role) ";
		$query .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber' )";
		$register_user_query = mysqli_query($connection, $query);

		confirmQuery($register_user_query);
	}
	

	//Function to login user 
	function login_user($username, $password){
		global $connection;
		
		//Remove whitespace
		$username = trim($username);
     	$password = trim($password);
		
		//Prevents SQL injection
        $username = mysqli_real_escape_string($connection, $username);
        $password = mysqli_real_escape_string($connection, $password);
        
        $query = "SELECT * FROM users WHERE username = '{$username}' ";
        $select_user_query = mysqli_query($connection, $query);
        
		confirmQuery($select_user_query);
        
        while($row = mysqli_fetch_array($select_user_query)){
            $db_user_id = $row['user_id'];
            $db_username = $row['username'];
            $db_user_password = $row['user_password'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_role = $row['user_role'];
			
			
			//$password = crypt($password, $db_user_password);
        
			if(password_verify($password, $db_user_password)){

				session_start();

				$_SESSION['username'] = $db_username;
				$_SESSION['firstname'] = $db_user_firstname;
				$_SESSION['lastname'] = $db_user_lastname;
				$_SESSION['user_role'] = $db_user_role;

				redirect("/cms/admin");
			}
			
			else {
				
				return false;
			
			}
            
        }
		
		return true;
		
	}
	

?>