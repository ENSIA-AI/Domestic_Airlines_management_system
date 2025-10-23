<?php
include "db_config.php";

$sql = ["CREATE TABLE IF NOT EXISTS `AIRPORTS` (
  `IATA_CODE` char(3) NOT NULL,
  `ICAO_CODE` char(4) NOT NULL,
  `WILAYA` text NOT NULL,
  `DISPLAY_NAME` text NOT NULL,
  `LATITUDE` decimal(14,12) NOT NULL COMMENT 'Positive for North, negative for South',
  `LONGITUDE` decimal(14,12) NOT NULL COMMENT 'Positive for East, negative for West',
  `ELEVATION` int(10) UNSIGNED NOT NULL COMMENT 'Altitude in meters'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;",
    "ALTER TABLE `AIRPORTS`
  ADD PRIMARY KEY IF NOT EXISTS (`IATA_CODE`),
  ADD UNIQUE KEY IF NOT EXISTS `ICAO` (`ICAO_CODE`);"
];


for ($i = 0; $i < sizeof($sql); $i++) {
    if ($conn->query($sql[$i]) != TRUE) {
        echo "Error on query ".$i;
        echo $conn->error;
    }
}




$conn->close();

?>