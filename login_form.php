<!DOCTYPE html>
<html>
<head>
    <title>Logowanie do systemu hurtowni elektrycznej</title>
    <link rel="stylesheet" href="style.css">
    <style>
        
        body {
        font-family: Arial, Helvetica, sans-serif;    
        background: url('maga.png') no-repeat center center fixed;
        background-size: cover;
        background-position: center;
        filter: blur(0px);
        }

        form {
        background-color: #545454;
        background-size: cover;
        background-position: center center;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        opacity: 0.9;
        }


        
        
        label {
            display: block;
            margin-bottom: 10px;
        }
        
        input[type=text], input[type=password] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            width: 100%;
            margin-bottom: 20px;
        }
        
        button {
            background-color: #FFFFFF;
            color: black;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        
        button:hover {
            background-color: #FFFFFF;
        }
        
        .container {
        padding: 16px;
        border: 0px;
        text-align: center;
        width: 400px;
        margin: 0 auto;
        }

        
        .error {
            color: red;
            margin-bottom: 20px;
        }
        
       
</style>

        </style>
</head>
<body>
    <?php
        session_start();
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $do_bazy = new mysqli('localhost', 'root', '', 'hurt_ele_ms');
        mysqli_set_charset($do_bazy, "utf8");
        if (mysqli_connect_errno()) {
            echo "Nie moge polaczyc sie z serwerem MySQL. Kod błędu:" . mysqli_connect_error();
            exit;
        }

        $query = "SELECT * FROM uzytkownicy WHERE nazwa_uzytkownika='$username' AND haslo='$password'";
        $result = mysqli_query($do_bazy, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: menu.php");
            exit();
        } else {
            $error = "Niepoprawna nazwa użytkownika lub hasło.";
        }
    }
?>

<div class="container">
    <form class="form" action="login_form.php" method="POST">
        <h2 class="form__title">Logowanie do systemu hurtowni elektrycznej</h2>
        <?php
            if(isset($error)) {
                echo '<div class="form__error">' . $error . '</div>';
            }
        ?>
        <div class="form__group">
            <label class="form__label" for="username">Nazwa użytkownika:</label>
            <input class="form__input" type="text" id="username" name="username" required>
        </div>

        <div class="form__group">
            <label class="form__label" for="password">Hasło:</label>
            <input class="form__input" type="password" id="password" name="password" required>
        </div>

        <button class="btn" type="submit">Zaloguj</button>
    </form>
</div>
</body>
</html>