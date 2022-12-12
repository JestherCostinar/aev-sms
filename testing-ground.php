<?php
include("includes/dbconfig.php");
include("includes/global.php");
include("includes/function.php");

mysqli_query($conn, "UPDATE cc_general SET total_score = 1  WHERE id = 1947");

?>