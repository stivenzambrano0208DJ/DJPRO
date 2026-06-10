<?php
$conn = new mysqli('localhost', 'root', '', 'djro_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$res = $conn->query("DESCRIBE contrataciones");
while ($row = $res->fetch_assoc()) {
    echo $row['Field'] . ' (' . $row['Type'] . ') - ' . ($row['Null']=='YES'?'NULL':'NOT NULL') . "\n";
}
unlink(__FILE__); // self-destruct after execution
