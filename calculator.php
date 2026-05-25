<?php
$result = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["mode"] === "php") {
    $a = $_POST["a"];
    $b = $_POST["b"];
    $op = $_POST["op"];

    switch ($op) {
        case "+": $result = $a + $b; break;
        case "-": $result = $a - $b; break;
        case "*": $result = $a * $b; break;
        case "/": 
            $result = $b != 0 ? $a / $b : "Błąd: dzielenie przez 0"; 
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="UTF-8">
<title>Hybrydowy kalkulator</title>
<style>
    body { font-family: Arial; padding: 20px; }
    .js-on { color: green; font-weight: bold; }
    .js-off { color: red; font-weight: bold; }
</style>
</head>
<body>

<h2>Hybrydowy kalkulator (PHP + JS)</h2>

<div>
    Tryb: 
    <span id="modeLabel" class="js-off">PHP</span>
</div>

<br>

<form method="POST" id="calcForm">
    <input type="number" name="a" id="a" required placeholder="Liczba A">
    <select name="op" id="op">
        <option value="+">+</option>
        <option value="-">-</option>
        <option value="*">*</option>
        <option value="/">/</option>
    </select>
    <input type="number" name="b" id="b" required placeholder="Liczba B">

    <input type="hidden" name="mode" id="mode" value="php">

    <br><br>

    <button type="button" id="toggleJS">Tryb JS</button>
    <button type="submit">Oblicz</button>
</form>

<h3>Wynik: <span id="result">
    <?= $result ?>
</span></h3>

<script>
let jsMode = false;

document.getElementById("toggleJS").onclick = () => {
    jsMode = !jsMode;

    const label = document.getElementById("modeLabel");
    const modeInput = document.getElementById("mode");

    if (jsMode) {
        label.textContent = "JS";
        label.className = "js-on";
        modeInput.value = "js";
    } else {
        label.textContent = "PHP";
        label.className = "js-off";
        modeInput.value = "php";
    }
};

document.getElementById("calcForm").onsubmit = function(e) {
    if (!jsMode) return;

    e.preventDefault();

    let a = document.getElementById("a").value;
    let b = document.getElementById("b").value;
    let op = document.getElementById("op").value;

    let result = "";

    switch (op) {
        case "+":
            result = a + b;
            break;
        case "-":
            result = b + a;
            break;
        case "*":
            result = a.repeat(b);
            break;
        case "/":
            result = b.repeat(a);
            break;
    }

    document.getElementById("result").textContent = result;
};
</script>

</body>
</html>
