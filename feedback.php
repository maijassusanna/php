<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GiveFeedback</title>
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
	overflow: hidden;
	background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);
	border-radius: 10px;
	box-shadow: 5px 20px 50px #000;
}

#chk{
	display: none;
}

.feedback{
	position: relative;
	width:100%;
	height: 100%;
}

label{
	color: #fff;
	font-size: 2.3em;
	justify-content: center;
    text-align: center;
	display: flex;
	margin: 50px;
	font-weight: bold;
	cursor: pointer;
	transition: .5s ease-in-out;
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

h4 {
    text-align: center;
    color: white;
    margin: 30px;
    
}

button:hover {
        background: #6d44b8;
    }

textarea  {
        width: 65%;
        height: 40px;
        background: #e0dede;
        justify-content: center;
        display: flex;
        margin: 20px auto;
        padding: 10px;
        border: none;
        outline: none;
        border-radius: 5px;
}

select {
        width: 70%;
        height: 40px;
        background: #e0dede;
        justify-content: center;
        display: flex;
        margin: 20px auto;
        padding: 10px;
        border: none;
        outline: none;
        border-radius: 5px;
}


</style>
<body>  
<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="feedback">
				<form action="allfeedbacks.php" method="post">
					<label for="chk" aria-hidden="true">Give Feedback</label>
                    <h4>Give feedback about your school teachers and their teaching style</h4>
                    <select name="teacher" id="teacher" required="">
                        <option value="">Select Teacher</option>
                        <option value="teacher1">Kauko Hämäläinen - Historia</option>
                        <option value="teacher2">Päivi Kauppi - Kemia</option>
                        <option value="teacher3">Seppo Lindgren - Ohjelmointi</option>
                        <option value="teacher4">Marjatta Björn - Tietotekniikka</option>
                    </select>

					<textarea name="feedback" placeholder="Write your feedback..." required></textarea>

					<button type="submit">Submit</button>
				</form>
			</div>

</div>

</body>
</html>
