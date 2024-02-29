	<footer>&copy; UWT team, 2015</footer>
</div>
</body>
</html>

<?php

    if(isset($conn)){
        $conn->close;
    }

    if(isset($stmt)){
        $stmt->close;
    }