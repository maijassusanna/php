<?php


include_once 'config/db_config.php';

session_start(); // Aloita istunto skriptin alussa


// Tarkista, onko käyttäjä kirjautunut sisään
if (!isset($_SESSION["user_id"])) {
    header("Location: index.php"); // Uudelleenohjaa kirjautumis-/rekisteröintisivulle, jos ei ole kirjautunut sisään
    exit();
}

// Haetaan ja näytetään käyttäjänimi
$username = isset($_SESSION["user_name"]) ? $_SESSION["user_name"] : '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LoginOrCreate</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Jost', sans-serif;
            background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
            color: #fff;
            text-align: center;
        }

        .success-message {
            width: 350px;
	        height: 500px;
            background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
	        overflow: hidden;
	        border-radius: 10px;
	        box-shadow: 5px 20px 50px #000;
            
        }

        h2 {
            font-size: 30px;
            margin-top: 100px;
            margin-bottom: 40px;
        }


        p {
            margin-top: 150px;
            padding-top: 20px;
        }

        a {
            color: #fff;
            text-decoration: none;
            background: #573b8a;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        a:hover {
            background: #6d44b8;
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            background: #573b8a;
            padding: 10px;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background 0.3s;
            font-family: 'Jost', sans-serif;
            font-size: 16px;
            width: 38%;
        }

        input[type="submit"]:hover {
            background: #6d44b8;
        }
    </style>
</head>
<body>  
    
    <div class="success-message">  	

        <h2>Proceed to answer the feedback:</h2>
        <a href="feedback.php">Give Feedback</a>

        <form action="logout.php" method="post">
            <input type="submit" value="Logout">
        </form>
        <p>You are logged in as <?php echo $username; ?></p>
    </div>

</body>
</html>
