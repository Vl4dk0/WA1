<?php
include('funkcie.php');
hlavicka('');
include('navigacia.php');
include('akcie.php');
include('db.php');

session_start();
if(!isset($_SESSION['id'])){
    header('Location: login.php');
    return;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['submit']) && $_POST['datum'] !== "-1") {

        $stmt = $conn->prepare("UPDATE sportcar_terminy SET uid = ? where idt = ? and uid = 0");
        $stmt->bind_param("ii", $_SESSION['id'], $_POST['datum']);
        $stmt->execute();

        $resSuccess = true;
    }
}

$name = $_SESSION['name'] . " " . $_SESSION['surname'];

$stmt = $conn->prepare("SELECT nazov FROM sportcar_auta WHERE idc = ?");
$stmt->bind_param("i", $_GET['carID']);
$stmt->execute();

$carName = $stmt->get_result()->fetch_assoc()['nazov'];

$stmt = $conn->prepare("SELECT datum, idt FROM sportcar_terminy where idc = ? and uid = 0");
$stmt->bind_param("i", $_GET['carID']);
$stmt->execute();

$result = $stmt->get_result()->fetch_all();

?>
<section>
    <form method="post">
        <fieldset>
            <legend>Rezervácia</legend>
            Objednávateľ: <strong><?php echo $name; ?></strong><br>
            testovacie auto: <strong><?php echo $carName; ?></strong><br>
            <label for="datum">dátum testovania:</label>
            <select id="datum" name="datum">
                <option value="-1">-</option>
                <?php
                foreach ($result as $date) {
                    echo "<option value=\"$date[1]\">$date[0]</option>";
                }
                ?>
            </select>
            <br>
        </fieldset>
        <p><input name="submit" type="submit" id="submit" value="Rezervuj"></p>
    </form>

    <p><?php echo isset($resSuccess) ? "Rezervacia uspesna" : "" ?></p>

</section>
<?php
include('pata.php');
?>