<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            StepX | Login
        </title>
        <link rel="stylesheet" href="styles/mystyles.css">
        <link rel="icon" href="img/icon.png">
        <script src="js/global.js"></script>
    </head>

    <?php
        session_start();
        // Database connection
        $servername = "localhost";
        $user = "root";
        $password = "";
        $dbname = "stepx_database";

        $conn = new mysqli($servername, $user, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check for the POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];
        
            // Basic query to check credentials
            $sql = "SELECT * FROM customer_info WHERE customer_name = '$username' AND password = '$password'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row["isAdmin"] == 1) {
                    header("Location: admin/admin-customers.php");
                    exit();
                }
            }
        
            if ($result->num_rows > 0) {
                // Credentials are correct
                $_SESSION['isLoggedin'] = true;
                $_SESSION['username'] = $username;
                echo json_encode(['isLoggedin' => true]);
                // Redirect to a new page after successful login
                header("Location: products.php");
                exit();
            } else {
                // Credentials are incorrect
                echo json_encode(['isLoggedin' => false, 'message' => 'Invalid username or password!']);
            }
        }

    ?>

    <body class="loginBody">
        <div class="BackgroundImage"></div> <!-- Background image container -->
        <div class="Navigation" id="navbar">
            <h1><a href="index.php">StepX</a></h1>
            <nav class="ClassForNav">
			    <?php include "nav.php"; ?>
		    </nav>
        </div>

        <div class="BoxForContents" id = "box">
            <h2>Login</h2>
            <div class="TableForLogin">
                <form action="login.php" method="POST">
                    <table>
                        <th>
                            <label for="CheckLogin">Invalid Username or Password!</label>                            
                        </th>
                        <tr>
                            <td>
                                <input 
                                type="text" 
                                placeholder="Username" 
                                class="inputBox" 
                                id="username" 
                                name = "username"
                                oninput="checkInputForLogin()" 
                                required 
                                autofocus>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input 
                                type="password" 
                                placeholder="Password" 
                                class="inputBox" 
                                id="password" 
                                name = "password"
                                oninput="checkInputForLogin()" 
                                required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type="submit" class="inputButton" id="SubmitLogin" disabled>Sign in</button>
                                <button class="inputButton" onclick="window.location.href='registration.php'">Register</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <?php $conn->close(); ?>
    </body>
</html>