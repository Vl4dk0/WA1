<?php
include('funkcie.php');
hlavicka('');
include('navigacia.php');
include('akcie.php');
include('db.php');

session_start();
?>
<section>
    <table>
        <tr>
            <th>auto</th>
            <th>výkon</th>
            <th>max. rýchlosť</th>
            <th>foto</th>
            <th>hodnotenie</th>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
        </tr>
        <?php
		$stmt = $conn->prepare(
			<<<SQL
		select 
		sportcar_auta.idc, nazov, vykon, rychlost, AVG(body) as body
		from 
		sportcar_auta left join sportcar_hodnotenie on sportcar_auta.idc = sportcar_hodnotenie.idc 
		group by sportcar_auta.idc
		order by nazov
		SQL
		);
		$stmt->execute();

		$result = $stmt->get_result();
		$helper = false;
		while ($row = $result->fetch_assoc()) { ?>
        <?php
			$helper = true;
			// var_dump($row);
			// break;
			?>
        <tr>
            <td class="centruj">
                <?php echo $row['nazov']; ?>
            </td>
            <td class="centruj">
                <?php echo $row['vykon']; ?>
            </td>
            <td class="centruj">
                <?php echo $row['rychlost']; ?>
            </td>
            <td><img src="obrazky/<?php echo $row["idc"] ?>.jpg" alt=<?php echo $row['nazov'] ?> width=" 150"></td>
            <td class="centruj">
                <?php echo isset($row["body"]) ? $row["body"] : "Zatial nehodnotene" ?>
            </td>
            <td>
                <?php
					if (isset($_SESSION['id']))
						echo '<a href="hodnotenie.php?carID='.$row['idc'].'">hodnot</a>';
					else
						echo '<a href="login.php">hodnot</a>';
					?>
            </td>
            <td>
                <?php
					if (isset($_SESSION['id']))
						echo '<a href="jazda.php?carID='.$row['idc'].'">rezervacia jazdy</a>';
					else
						echo '<a href="login.php">rezervacia jazdy</a>';
					?>
            </td>
        </tr>
        <?php }
		if (!$helper)
			echo 'Ziadne auta';
		?>
    </table>

</section>
<?php
include('pata.php');
?>