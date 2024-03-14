<?php

include_once 'config/db_config.php';

session_start();

$access_denied_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['login'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['pswd'];

        $sql = "SELECT id, username, email, password FROM users_table WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['username'];
                $_SESSION['user_email'] = $row['email'];

                header('Location: valisivu.php');
                exit;
            } else {
                $access_denied_error = "Access denied. Incorrect password.";
				echo "<script>alert('Access denied. Incorrect password.');</script>";
            }
        } else {
            $access_denied_error = "Access denied. User not found.";
			echo "<script>alert('Access denied. User not found.');</script>";
        }

        $stmt->close();
    } elseif (isset($_POST['signup'])) {
        $name = $conn->real_escape_string($_POST['txt']);
        $email = $conn->real_escape_string($_POST['email']);

         // Check if email already exists
         $sql_check_email = "SELECT id FROM users_table WHERE email = ?";
         $stmt_check_email = $conn->prepare($sql_check_email);
         $stmt_check_email->bind_param("s", $email);
         $stmt_check_email->execute();
         $result_check_email = $stmt_check_email->get_result();

         if ($result_check_email->num_rows > 0) {
            $access_denied_error = "Access denied. Email already exists.";
            echo "<script>alert('Access denied. Email already exists.');</script>";
        } else {
            $password = password_hash($_POST['pswd'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO users_table (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $email, $password);
            $result = $stmt->execute();

            if ($result) {
                // Registration successful
                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;

                header('Location: valisivu.php');
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
			//sulje lauseke
			$stmt->close();
        }

        $stmt_check_email->close();

    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoginOrCreate</title>
</head>
<style>

body{
	margin: 0;
	padding: 0;
	display: flex;
	justify-content: center;
	align-items: center;
	min-height: 100vh;
	font-family: 'Jost', sans-serif;
	background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
}
.main{
	width: 350px;
	height: 500px;
	background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
	overflow: hidden;
	border-radius: 10px;
	box-shadow: 5px 20px 50px #000;
}
#chk{
	display: none;
}

.signup{
	position: relative;
	width:100%;
	height: 100%;
}
label{
	color: #fff;
	font-size: 2.3em;
	justify-content: center;
	display: flex;
	margin: 60px;
	font-weight: bold;
	cursor: pointer;
	transition: .5s ease-in-out;
}
input{
	width: 60%;
	height: 20px;
	background: #e0dede;
	justify-content: center;
	display: flex;
	margin: 20px auto;
	padding: 10px;
	border: none;
	outline: none;
	border-radius: 5px;
}
button{
	width: 60%;
	height: 40px;
	margin: 10px auto;
	justify-content: center;
	display: block;
	color: #fff;
	background: #573b8a;
	font-size: 1em;
	font-weight: bold;
	margin-top: 20px;
	outline: none;
	border: none;
	border-radius: 5px;
	transition: .2s ease-in;
	cursor: pointer;
}
button:hover{
	background: #6d44b8;
}
.login{
	height: 460px;
	background: #eee;
	border-radius: 60% / 10%;
	transform: translateY(-180px);
	transition: .8s ease-in-out;
}
.login label{
	color: #573b8a;
	transform: scale(.6);
}

#chk:checked ~ .login{
	transform: translateY(-500px);
}
#chk:checked ~ .login label{
	transform: scale(1);	
}
#chk:checked ~ .signup label{
	transform: scale(.6);
}

h1 {
    text-align: center;
    color: white;
    margin-top: 20px;
    position: absolute;
    top: 0;
    width: 100%;
}

@media only screen and (max-width: 600px) {
            .form-container {
                max-width: 90%;
            }
		}




</style>
<body>  
    <h1> Welcome to Feedback App </h1>

<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form action="index.php" method="post">
					<label for="chk" aria-hidden="true">Sign up</label>
					<input type="text" name="txt" placeholder="User name" required="">
					<input type="email" name="email" placeholder="Email" required="">
					<input type="password" name="pswd" placeholder="Password" required="">
					<button type="submit" name="signup">Sign up</button>

				</form>
			</div>

			<div class="login">
				<form action="index.php" method="post">
					<label for="chk" aria-hidden="true">Login</label>
					<input type="email" name="email" placeholder="Email" required="">
					<input type="password" name="pswd" placeholder="Password" required="">
					<button type="submit" name="login">Login</button>

				</form>
			</div>


	</div>
    
</body>
</html>
