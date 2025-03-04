<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konversi Suhu</title>
</head>

<body>

    <?php
    function toCelsius($temperature, $scale) {
        switch ($scale) {
            case 'celsius':
                return $temperature;
            case 'fahrenheit':
                return ($temperature - 32) * 5 / 9;
            case 'rheamur':
                return $temperature * 5 / 4;
            case 'kelvin':
                return $temperature - 273.15;
            case 'rankine':
                return ($temperature - 491.67) * 5 / 9;
            default:
                return null;
        }
    }

    function fromCelsius($celsius) {
        return [
            'celsius' => $celsius,
            'fahrenheit' => $celsius * 9 / 5 + 32,
            'rheamur' => $celsius * 4 / 5,
            'kelvin' => $celsius + 273.15,
            'rankine' => ($celsius + 273.15) * 9 / 5
        ];
    }

    if (isset($_POST['submit'])) {
        $temperature = $_POST['temperature'];
        $scales = $_POST['scale'];

        echo "<h2>Hasil Konversi:</h2>";
        foreach ($scales as $scale) {
            $celsius = toCelsius($temperature, $scale);
            $converted = fromCelsius($celsius);
            echo "Dari $scale: <br>";
            echo "Celsius = " . round($converted['celsius'], 2) . " °C, ";
            echo "Fahrenheit = " . round($converted['fahrenheit'], 2) . " °F, ";
            echo "Rheamur = " . round($converted['rheamur'], 2) . " °R, ";
            echo "Kelvin = " . round($converted['kelvin'], 2) . " °K, ";
            echo "Rankine = " . round($converted['rankine'], 2) . " °Ra<br><br>";
        }
    }
    ?>

    <h1>Konversi Suhu</h1>
    <form method="post">
        <label for="temperature">Masukkan Nilai Suhu:</label>
        <input type="number" step="any" name="temperature" id="temperature" required>
        <br><br>
        <label>Pilih Skala Suhu Awal:</label><br>
        <input type="checkbox" name="scale[]" value="celsius"> Celsius<br>
        <input type="checkbox" name="scale[]" value="fahrenheit"> Fahrenheit<br>
        <input type="checkbox" name="scale[]" value="rheamur"> Rheamur<br>
        <input type="checkbox" name="scale[]" value="kelvin"> Kelvin<br>
        <input type="checkbox" name="scale[]" value="rankine"> Rankine<br>
        <br>
        <input type="submit" name="submit" value="hitung">
    </form>
</body>

</html>