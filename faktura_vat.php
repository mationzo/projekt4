<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <style>
        .usun-przycisk {
        	margin: 1px;
        	background-color: #FF0000;
        	color: white;
        	border-radius: 10px;
        	width: 70px;
        }

        .inputprzycisk {
			width: 200px;
			background-color: #454545;
			color: white;
			border-radius: 10px;
			text-align: center;
		}

		.divprzycisk {
            text-align: center;
        }

		.przycisk {
            margin: 1px;
            background-color: #454545;
            color: white;
            border-radius: 10px;
            width: 70px;

        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #DFD6B9;
            font-family: Arial, sans-serif;
        }

        ul {
            list-style-type: none;
            background-color: #333;
            padding: 20px;
            display: flex;
            justify-content: space-between;
        }

        li {
            display: inline-block;
            margin-right: 10px;
        }

        li a {
            display: block;
            color: #FFF;
            padding: 8px 16px;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        li a:hover {
            background-color: #555;
        }

        .container {
            margin: 50px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #AAA;
            border-color: black;
            padding: 10px;
            font-size: 16px;
            text-align: left;
        }

        th {
            background-color: #555;
            color: white;
        }

        .form-container {
            margin-top: 20px;
            background-color: #EEE;
            padding: 20px;
        }

        .form-container label {
            font-size: 18px;
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }

        .form-container input[type="text"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #AAA;
            margin-bottom: 10px;
        }

        .form-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #555;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
    <ul>
        <li><a href="menu.php" class="active">Strona Główna</a></li>
        <li><a href="imiona.php">Imiona</a></li>
        <li><a href="nazwiska.php">Nazwiska</a></li>
        <li><a href="klient.php">Klient</a></li>
        <li><a href="miasto.php">Miasto</a></li>
        <li><a href="ulice.php">Ulice</a></li>
        <li><a href="kod pocztowy.php">Kod pocztowy</a></li>
        <li><a href="faktura_vat.php">Faktura VAT</a></li>
    </ul>

    <div class="container">
    <h1>Lista faktur VAT:</h1>
<table>
    <tr>
        <th>ID</th>
        <th>ID klienta</th>
        <th>Data faktury</th>
        <th>Numer faktury</th>
        <th>Akcje</th>
    </tr>
    <?php
    $do_bazy = new mysqli('localhost', 'root', '', 'hurt_ele_ms');
    mysqli_set_charset($do_bazy, "utf8");
    if (mysqli_connect_errno()) {
        echo "Nie mogę połączyć się z serwerem MySQL. Kod błędu:" . mysqli_connect_error();
        exit;
    }

    if (isset($_POST['delete_id'])) {
        $delete_id = $_POST['delete_id'];
        $sql = "DELETE FROM ulice WHERE ID_Ul = $delete_id";

        if (mysqli_query($do_bazy, $sql)) {
            echo '<script>window.location.href = "ulice.php";</script>';
            exit;
        } else {
            echo "Błąd: " . mysqli_error($do_bazy);
        }
    }

    if (!empty($_POST['id_klienta']) && !empty($_POST['data_faktury']) && !empty($_POST['numer_faktury'])) {
        $id_klienta = $_POST['id_klienta'];
        $data_faktury = $_POST['data_faktury'];
        $numer_faktury = $_POST['numer_faktury'];

        if (isset($_POST['edit_id'])) {
            $edit_id = $_POST['edit_id'];

            $sql = "UPDATE faktura_vat SET ID_Kl = '$id_klienta', Data_faktury = '$data_faktury', Numer_faktury = '$numer_faktury' WHERE ID_Fakt_vat = $edit_id";

            if (mysqli_query($do_bazy, $sql)) {
                echo '<script>window.location.href = "faktura_vat.php";</script>';
                exit;
            } else {
                echo "Błąd: " . mysqli_error($do_bazy);
            }
        } else {

            $sql = "INSERT INTO faktura_vat (ID_Kl, Data_faktury, Numer_faktury) VALUES ('$id_klienta', '$data_faktury', '$numer_faktury')";

            if (mysqli_query($do_bazy, $sql)) {
                echo '<script>window.location.href = "faktura_vat.php";</script>';
                exit;
            } else {
                echo "Błąd: " . mysqli_error($do_bazy);
            }
        }
    }

    if ($result = mysqli_query($do_bazy, 'SELECT * FROM faktura_vat')) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['ID_Fakt_vat'] . "</td>";
            echo "<td>";
            if (isset($_GET['edit']) && $_GET['edit'] == $row['ID_Fakt_vat']) {
                echo "<form method='POST' action='faktura_vat.php'>";
                echo "<input type='hidden' name='edit_id' value='" . $row['ID_Fakt_vat'] . "'>";
                echo "<input name='id_klienta' type='text' value='" . $row['ID_Kl'] . "'>";
                echo "</td>";
                echo "<td><input name='data_faktury' type='text' value='" . $row['Data_faktury'] . "'></td>";
                echo "<td><input name='numer_faktury' type='text' value='" . $row['Numer_faktury'] . "'></td>";
                echo "<td><button type='submit'>Zapisz</button></td>";
                echo "</form>";
            } else {
                echo $row['ID_Kl'];
                echo "</td>";
                echo "<td>" . $row['Data_faktury'] . "</td>";
                echo "<td>" . $row['Numer_faktury'] . "</td>";
                echo "<td><a href='faktura_vat.php?edit=" . $row['ID_Fakt_vat'] . "'>Edytuj</a></td>";
            }
            echo "</tr>";
        }
        mysqli_free_result($result);
    } else {
        echo "Brak danych do wyświetlenia";
    }

    mysqli_close($do_bazy);
    ?>
</table>
<h2>Dodaj nową fakturę VAT:</h2>
<form method="POST" action="faktura_vat.php" class="form-container">
    <label>ID klienta:</label>
    <input type="text" name="id_klienta" style="width: 250px;"><br><br>
    <label>Data faktury:</label>
    <input type="text" name="data_faktury" style="width: 250px;"><br><br>
    <label>Numer faktury:</label>
    <input type="text" name="numer_faktury" style="width: 250px;"><br><br>
    <button type="submit">Dodaj</button>
</form>

    </div>
</body>
</html>
