<?php
include('funkcie.php');
hlavicka('');
include('navigacia.php');
include('akcie.php');
include('db.php');

session_start();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['heslo'];

    if (empty($username) || empty($password)) {
        $error = 'missing name or password';
    }
    if (!isset($error)) {
        $password_hash = md5($password);
        $stmt = $conn->prepare('select uid, username, heslo, meno, priezvisko, admin from sportcar_pouzivatelia where username = ?');
        $stmt->bind_param('s', $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($result->num_rows > 0 && $row['heslo'] === $password_hash) {
            $_SESSION['id'] = $row['uid'];
            $_SESSION['isadmin'] = $row['admin'];
            $_SESSION['name'] = $row['meno'];
            $_SESSION['surname'] = $row['priezvisko'];
            header('Location: login.php');
        }
    }


}

if (isset($_POST['odhlas'])) {
    session_destroy();
    header('Location: login.php');
}

?>
<section>

    <?php
    if (isset($_SESSION['id'])) {
        echo "Vitajte v systeme {$_SESSION['name']} {$_SESSION['surname']}";
    } elseif (isset($error)) {
        echo $error;
    }
    ?>

    <form method="post">
        <p>
            <input name="odhlas" type="submit" id="odhlas" value="Odhlás ma">
        </p>
    </form>

    <form method="post">
        <fieldset>
            <legend>Prihlásenie</legend>
            <label for="username">prihlasovacie meno:</label>
            <input name="username" type="text" id="username" value="" size="20" maxlength="20">
            <br>
            <label for="heslo">heslo:</label>
            <input name="heslo" type="password" id="heslo" size="20" maxlength="20">
            <br>
        </fieldset>
        <p><input name="submit" type="submit" id="submit" value="Prihlás"></p>
    </form>

</section>
<?php
include('pata.php');
?>