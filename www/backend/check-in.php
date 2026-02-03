<?php 
include "../internal/session.php";
include "../internal/db_config.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
   
    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'getBookingInfo') {
          $booking_id = (int) $_GET['bookingId'];
          $sql = "
          SELECT
              b.DEPARTURE_TIME,
              b.FLIGHT_NUMBER,
              b.CLASS,
              p.PASSENGER_NUM,
              p.FIRST_NAME,
              p.LAST_NAME,
              f.DEP_AIRPORT,
              f.ARR_AIRPORT
          FROM BOOKINGS b
          JOIN PASSENGERS p ON p.PASSENGER_NUM = b.PASSENGER_NUM
          JOIN FLIGHTS f ON f.FLIGHT_NUMBER = b.FLIGHT_NUMBER
          WHERE b.BOOKING_ID = ?
          ";


          $stmt = $conn->prepare($sql);
          $stmt->bind_param('i', $booking_id);
          $stmt->execute();
          $result = $stmt->get_result();
          $data = $result->fetch_assoc();

          $passenger_num = htmlspecialchars($data['PASSENGER_NUM']);
          $first_name    = htmlspecialchars($data['FIRST_NAME']);
          $last_name     = htmlspecialchars($data['LAST_NAME']);
          $flight_number = htmlspecialchars($data['FLIGHT_NUMBER']);
          $date          = substr($data['DEPARTURE_TIME'], 0, 10);
          $departure     = htmlspecialchars($data['DEP_AIRPORT']);
          $destination   = htmlspecialchars($data['ARR_AIRPORT']);
          $class         = htmlspecialchars($data['CLASS']);

          echo "
          <div class='name-container'>
              <label>First Name:</label>
              <input type='text' value='$first_name' disabled>

              <label>Last Name:</label>
              <input type='text' value='$last_name' disabled>
          </div>

          <label>Passenger Number:</label>
          <input type='text' value='$passenger_num' disabled>

          <div class='dep-dest'>
              <label>Flight Number:</label>
              <label>Date:</label>
          </div>

          <div class='dep-dest'>
              <input type='text' value='$flight_number' disabled>
              <input type='date' value='$date' disabled>
          </div>

          <div class='dep-dest'>
              <label>Departure:</label>
              <label>Destination:</label>
          </div>

          <div class='dep-dest'>
              <input type='text' value='$departure' disabled>
              <input type='text' value='$destination' disabled>
          </div>

          <label>Class:</label>
          <input type='text' value='$class' disabled>
          ";

        } 
        
        elseif ($_GET['action'] === 'loadrows') {
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
    }


}



?>