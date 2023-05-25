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
		<h1>Lista klientów:</h1>
		<table>
			<tr>
				<th>ID</th>
				<th>Imię</th>
				<th>Nazwisko</th>
				<th>Miasto</th>
				<th>Ulica</th>
				<th>Kod pocztowy</th>
				<th>Numer domu</th>
				<th>Numer mieszkania</th>
				<th>PESEL</th>
				<th>Nazwa firmy</th>
				<th>Numer NIP</th>
				<th>Numer telefonu</th>
				<th></th>
				<th width=120px;>Akcje</th>
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
					$sql = "DELETE FROM klient WHERE ID_K = $delete_id";

					if (mysqli_query($do_bazy, $sql)) {
						echo '<script>window.location.href = "klient.php";</script>';
						exit;
					} else {
						echo "Błąd: " . mysqli_error($do_bazy);
					}
				}

				if (!empty($_POST['imie']) && !empty($_POST['nazwisko'])) {
				  $imie = $_POST['imie'];
				  $nazwisko = $_POST['nazwisko'];

				  if (isset($_POST['edit_id'])) {
				    $edit_id = $_POST['edit_id'];

				    $sql = "UPDATE klient SET ID_imie2 = '$imie', ID_nazwi = '$nazwisko' WHERE ID_K = $edit_id";

				    if (mysqli_query($do_bazy, $sql)) {
				      echo '<script>window.location.href = "klient.php";</script>';
				      exit;
				    } else {
				      echo "Błąd: " . mysqli_error($do_bazy);
				    }
				  } else {

				    $sql = "INSERT INTO klient (ID_imie2, ID_nazwi) VALUES ('$imie', '$nazwisko')";

				    if (mysqli_query($do_bazy, $sql)) {
				      echo '<script>window.location.href = "klient.php";</script>';
				      exit;
				    } else {
				      echo "Błąd: " . mysqli_error($do_bazy);
				    }
				  }
				}

				if ($result = mysqli_query($do_bazy, 'SELECT * FROM klient ORDER BY ID_K')) {
				  while ($row = mysqli_fetch_assoc($result)) {
				    echo "<tr>";
				    echo "<td>" . $row['ID_K'] . "</td>";
				    echo "<td>";
				    if (isset($_POST['edit_id']) && $_POST['edit_id'] == $row['ID_K']) {
				      echo "<form method='POST' action='klient.php'>";
				      echo "<input class='inputprzycisk' type='hidden' name='edit_id' value='" . $row['ID_K'] . "'>";
				      echo "<input class='inputprzycisk' name='imie' type='text' value='" . $row['ID_imie2'] . "'>";
				      echo "</td>";
				      echo "<td><input class='inputprzycisk' name='nazwisko' type='text' value='" . $row['ID_nazwi'] . "'></td>";
				      echo "<td>" . $row['ID_mias'] . "</td>";
				      echo "<td>" . $row['ID_ulic'] . "</td>";
				      echo "<td>" . $row['ID_kodpocz'] . "</td>";
				      echo "<td>" . $row['Numer domu'] . "</td>";
				      echo "<td>" . $row['Numer mieszkania'] . "</td>";
				      echo "<td>" . $row['Pesel'] . "</td>";
				      echo "<td>" . $row['ID_naz_firmy'] . "</td>";
				      echo "<td>" . $row['Numer Nip'] . "</td>";
				      echo "<td>" . $row['Numer telefonu'] . "</td>";
				      echo "<td><div class='divprzycisk'><button class='przycisk' type='submit'>Zapisz</button></form></td></div>";
				    } else {
				      echo $row['ID_imie2'] . "</td>";
				      echo "<td>" . $row['ID_nazwi'] . "</td>";
				      echo "<td>" . $row['ID_mias'] . "</td>";
				      echo "<td>" . $row['ID_ulic'] . "</td>";
				      echo "<td>" . $row['ID_kodpocz'] . "</td>";
				      echo "<td>" . $row['Numer domu'] . "</td>";
				      echo "<td>" . $row['Numer mieszkania'] . "</td>";
				      echo "<td>" . $row['Pesel'] . "</td>";
				      echo "<td>" . $row['ID_naz_firmy'] . "</td>";
				      echo "<td>" . $row['Numer Nip'] . "</td>";
				      echo "<td>" . $row['Numer telefonu'] . "</td>";
					  echo "<td><a href='strona_z_fakturami.php?id_klienta=" . $row['ID_K'] . "'>Zobacz faktury</a></td>";
				      echo "<td><form method='POST' action='klient.php'>";
				      echo "<input class='inputprzycisk' type='hidden' name='edit_id' value='" . $row['ID_K'] . "'>";
				      echo "<div class='divprzycisk'><button class='przycisk' type='submit'>Edytuj</button></form>";
					  echo "<form method='POST' action='klient.php' onsubmit='return confirm(\"Czy na pewno chcesz usunąć ten rekord?\")'>";
					  echo "<input class='usun-przycisk' type='hidden' name='delete_id' value='" . $row['ID_K'] . "'>";
					  echo "<div class='divprzycisk'> <button class='usun-przycisk' type='submit'>Usuń</button></div>";
					  echo "</form>";
					  echo "</td>";
					  
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

		<h2>Dodaj klienta:</h2>
		<div class="form-container">
			<form method="POST" action="klient.php">
				<label>Imię:</label>
				<input type="text" name="imie" style="width: 250px;" required>
        <br>
        <br>
				<label>Nazwisko:</label>
				<input type="text" name="nazwisko" style="width: 250px;"required>
        <br>
				<button type="submit">Dodaj</button>
			</form>
		</div>
	</div>
</body>
</html>
