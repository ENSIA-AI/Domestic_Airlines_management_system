<?php
include("../internal/db_config.php");

$sql = "SELECT TITLE, CONTENT, TIMESTAMP, TYPE, FULL_NAME FROM ANNOUNCEMENTS LEFT OUTER JOIN USERS ON ANNOUNCEMENTS.AUTHOR = USERS.UID";
$result = $conn->query(query: $sql);
while ($row = $result->fetch_assoc()):
    $date = (new DateTime($row["TIMESTAMP"]))->format('d M Y H:i');
    ?>
    <div class="announcement <?= $row["TYPE"] ?>-card">
        <h3><?= $row["TITLE"] ?></h3>
        <p><?= $row["CONTENT"] ?></p>
        <span class="author">- <?= $row["FULL_NAME"] ?> on <?= $date ?></span>
    </div>
<?php endwhile; ?>