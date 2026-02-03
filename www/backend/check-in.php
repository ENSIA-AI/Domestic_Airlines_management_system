<?php 
include "../internal/session.php";
include "../internal/db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $bookings_query = "SELECT * FROM BOOKINGS WHERE `STATUS` = 'CONFIRMED'";
  $bookings_result = mysqli_query($conn , $bookings_query);
  $bookings = mysqli_fetch_all($bookings_result, MYSQLI_ASSOC);

  echo ' <table class="dams-table" id="search-table">
                <thead class="dams-table-head">
                    <tr>
                        <th>Booking</th>
                        <th>Final Price</th>
                        <th>DeadLine</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tablebody">';
  foreach($bookings as $booking) {
    $booking_id = $booking['BOOKING_ID'];
    $deadline = (new DateTime($booking['DEPARTURE_TIME']))
              ->modify('-6 hours')
              ->format('Y-m-d H:i:s');
    $class = $booking['CLASS'];
    $final_price = "0 DZD";
    switch ($class) {
      case 'ECO_PROMO':
          $final_price = '12000 DZD';
          break;

      case 'ECO_SMART':
          $final_price = '15000 DZD';
          break;

      case 'ECO_PLUS':
          $final_price = '18000 DZD';
          break;

      case 'ECO_FLEX':
          $final_price = '22000 DZD';
          break;

      case 'BUSINESS_PLUS':
          $final_price = '40000 DZD';
          break;

      case 'PREMIERE_PLUS':
          $final_price = '60000 DZD';
          break;

      default:
          $final_price = '0 DZD'; 
}

  echo "<tr>
          <td>$booking_id</td>
          <td>$final_price</td>
          <td>$deadline</td>
          <td>
              <button class=\"option\">
              <i class=\"fa-solid fa-user-check\"></i>
              </button>
            </td>

          </tr>";
  }

    echo '</tbody></table>';
}



?>