<!DOCTYPE html>
<html>
<head>
    <title>Faktury klienta</title>
    <style>
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

        h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <ul>
        <!-- Twój kod menu -->
    </ul>

    <div class="container">
        <?php
        // Sprawdzenie, czy został przekazany ID klienta
        if (isset($_GET['id_klienta'])) {
            $id_klienta = $_GET['id_klienta'];

            // Połączenie z bazą danych
            $do_bazy = new mysqli('localhost', 'root', '', 'hurt_ele_ms');
            mysqli_set_charset($do_bazy, "utf8");
            if (mysqli_connect_errno()) {
                echo "Nie mogę połączyć się z serwerem MySQL. Kod błędu:" . mysqli_connect_error();
                exit;
            }

            // Pobranie faktur klienta
            $query = "SELECT * FROM faktura_vat WHERE ID_Kl = $id_klienta";
            if ($result = mysqli_query($do_bazy, $query)) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<h1>Lista faktur VAT:</h1>";
                    echo "<table>";
                    echo "<tr>";
                    echo "<th>ID</th>";
                    echo "<th>ID klienta</th>";
                    echo "<th>Data faktury</th>";
                    echo "<th>Numer faktury</th>";
                    echo "</tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['ID_Fakt_vat'] . "</td>";
                        echo "<td>" . $row['ID_Kl'] . "</td>";
                        echo "<td>" . $row['Data_faktury'] . "</td>";
                        echo "<td>" . $row['Numer_faktury'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<h2>Brak faktur dla tego klienta.</h2>";
                }
                mysqli_free_result($result);
            } else {
                echo "Błąd: " . mysqli_error($do_bazy);
            }

            mysqli_close($do_bazy);
        } else {
            echo "<h2>Nieprawidłowe ID klienta.</h2>";
        }
        ?>
    </div>
</body>
</html>
