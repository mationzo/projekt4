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
		<h1>Lista imion:</h1>
		<table>
			<tr>
				<th>ID_I</th>
				<th>Imię</th>
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
					$sql = "DELETE FROM imiona WHERE ID_I = $delete_id";

					if (mysqli_query($do_bazy, $sql)) {
						echo '<script>window.location.href = "imiona.php";</script>';
						exit;
					} else {
						echo "Błąd: " . mysqli_error($do_bazy);
					}
				}

				if (!empty($_POST['pole'])) {
				  $pole = $_POST['pole'];

				  if (isset($_POST['edit_id'])) {
				    $edit_id = $_POST['edit_id'];

				    $sql = "UPDATE imiona SET Imie = '$pole' WHERE ID_I = $edit_id";

				    if (mysqli_query($do_bazy, $sql)) {
				      echo '<script>window.location.href = "imiona.php";</script>';
				      exit;
				    } else {
				      echo "Błąd: " . mysqli_error($do_bazy);
				    }
				  } else {

				    $sql = "INSERT INTO imiona (Imie) VALUES ('$pole')";

				    if (mysqli_query($do_bazy, $sql)) {
				      echo '<script>window.location.href = "imiona.php";</script>';
				      exit;
				    } else {
				      echo "Błąd: " . mysqli_error($do_bazy);
				    }
				  }
				}

				if ($result = mysqli_query($do_bazy, 'SELECT * FROM imiona ORDER BY ID_I')) {
				  while ($row = mysqli_fetch_assoc($result)) {
				    echo "<tr>";
				    echo "<td>" . $row['ID_I'] . "</td>";
				    echo "<td>";
				    if (isset($_POST['edit_id']) && $_POST['edit_id'] == $row['ID_I']) {
				      echo "<form method='POST' action='imiona.php'>";
				      echo "<input class='inputprzycisk' type='hidden' name='edit_id' value='" . $row['ID_I'] . "'>";
				      echo "<input class='inputprzycisk' name='pole' type='text' value='" . $row['Imie'] . "'>";
				      echo "</td>";
				      echo "<td><div class='divprzycisk'><button class='przycisk' type='submit'>Zapisz</button></td></div>";
				      echo "</form>";
				    } else {
				      echo $row['Imie'];
				      echo "</td>";
				      echo "<td>";
				      echo "<form method='POST' action='imiona.php'>";
				      echo "<input class='inputprzycisk' type='hidden' name='edit_id' value='" . $row['ID_I'] . "'>";
				      echo "<div class='divprzycisk'><button class='przycisk' type='submit'>Edytuj</button></div>";
				      echo "</form>";
					  echo "<form method='POST' action='imiona.php' onsubmit='return confirm(\"Czy na pewno chcesz usunąć ten rekord?\")'>";
					  echo "<input class='usun-przycisk' type='hidden' name='delete_id' value='" . $row['ID_I'] . "'>";
					  echo "<div class='divprzycisk'> <button class='usun-przycisk' type='submit'>Usuń</button></div>";
					  echo "</form>";
				      echo "</td>";
				    }
				    echo "</tr>";
				  }
				}

				mysqli_close($do_bazy);
			?>
		</table>

		<div class="form-container">
			<form method="POST" action="imiona.php">
				<label for="pole">Dodawanie imienia:</label><br>
				<input name="pole" type="text" placeholder="Wprowadź imię" required><br>
				<button type="submit">Zapisz</button>
			</form>
		</div>
	</div>
</body>
</html>
