<?php
include('funkcie.php');
hlavicka('');
include('navigacia.php');
include('akcie.php');
include('db.php');

session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    return;
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){


    if(isset($_POST['hodnot'])) {
        $rating = intval($_POST['body']);
        var_dump($rating);
        if($rating < 1 || $rating > 5){
            echo "Nespravny format hodnotenia";
        } else {
            $stmt = $conn->prepare("INSERT INTO sportcar_hodnotenie (idc, uid, body) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE body = ?");
            $stmt->bind_param("iiii", $_GET['carID'], $_SESSION['id'], $_POST['body'], $_POST['body']);
            $success = $stmt->execute();

            // ask if $success is true
        }
    } elseif(isset($_POST['zrus'])) {
        $stmt = $conn->prepare("DELETE FROM sportcar_hodnotenie WHERE uid = ? and idc = ?");
        $stmt->bind_param("ii", $_SESSION['id'], $_GET['carID']);
        $stmt->execute();
    }
}

$stmt = $conn->prepare("SELECT nazov, body, sportcar_hodnotenie.uid FROM sportcar_auta left join sportcar_hodnotenie on sportcar_hodnotenie.idc = sportcar_auta.idc WHERE sportcar_auta.idc = ?");
$stmt->bind_param("i", $_GET['carID']);
$stmt->execute();

$carBody = 0;
$res = $stmt->get_result();
while($i = $res->fetch_assoc()){
    $carName = $i['nazov'];
    if($i['uid'] === $_SESSION['id']){
        $carBody = $i['body'];
        break;
    }
}

?>
<section>

    <form method="post">
        <fieldset>
            <legend>Hodnotíte</legend>
            testovacie auto: <strong><?php echo $carName; ?></strong><br>
            <label for="body">hodnotenie:</label>
            <select id="body" name="body">
                <option value="">-</option>
                <?php
				vypis_select(1, 5, $carBody);
				?>
            </select>
            <br>
        </fieldset>
        <p><input name="hodnot" type="submit" id="hodnot" value="Pridaj / uprav hodnotenie"></p>
    </form>
    <form method="post">
        <p><input name="zrus" type="submit" id="zrus" value="Vymaž hodnotenie"></p>
    </form>

</section>
<?php
include('pata.php');
?>