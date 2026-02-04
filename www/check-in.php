<?php
include("internal/session.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/d2ccabbb5f.js" crossorigin="anonymous"></script>
    <script src="/static/js/search.js"></script>
    <link rel="stylesheet" href="/static/css/style.css">
    <link rel="stylesheet" href="/static/css/check-in.css">
    

    <title>Check In</title>
</head>

<body>
    <?php
    include("internal/sidebar.php");
    ?>
    <main class="content">
        <div class="dams-head">
            <h1 class="title">Check-Ins</h1>

        </div>
        
          <div class="search-container">
                    <h2 class="search-strip-title">Check-Ins</h2>
                    <div class="search-bar">
                        <input type="text" class="search" id="search-bar" placeholder="Enter ID">
                        <button class="search-btn"><i class="fa fa-search"></i></button>
                    </div>
                   
        </div>
        <div class="table-container">
          <table class="dams-table" id="search-table">
                <thead class="dams-table-head">
                    <tr>
                        <th>Booking</th>
                        <th>Final Price</th>
                        <th>DeadLine</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tablebody">
       

 
                            
                        
                    </tr>
                </tbody>
            </table>
            <div class="spinner-container">
                <div class="spinner"></div>
                Loading...
            </div>
        </div>
    </main>


    
    <div class="check-in-overlay" id="check-in-overlay">
            <div id="step1" class="step">
                <h1 class="step-title">Personal Information & Luggage</h2>
                    <form class="dams-add-form" id="check-in-form">

                     </form>
                    <div class="form-actions">
                            <button type="button" class="cancel-btn" id="cancel-btn1">Cancel</button>
                            <button type="button" class="submit-btn" id="next-btn1">Next</button>     
                    </div>
            </div>


            <div id="step2" class="step">
                <h1 class="step-title">Seat Assignment</h2>
                <div class="seat-map">
                <!-- FIRST CLASS -->
                    <div class="cabin first-class">
                        <h2>First Class</i></h2>
                        <div class="seat-row">
                        <div class="seat first-class" data-seat="1A">1A</div>
                        <div class="seat first-class" data-seat="1B">1B</div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="seat first-class" data-seat="1C">1C</div>
                        <div class="seat first-class" data-seat="1D">1D</div>
                        </div>
                        <div class="seat-row">
                        <div class="seat first-class" data-seat="2A">2A</div>
                        <div class="seat first-class" data-seat="2B">2B</div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="aisle"></div>
                        <div class="seat first-class" data-seat="2C">2C</div>
                        <div class="seat first-class" data-seat="2D">2D</div>
                        </div>
                    </div>

                    <!-- BUSINESS CLASS -->
                    <div class="cabin business">
                        <h2>Business Class</h2>
                        <!-- 3 rows -->
                        <div class="seat-row">
                            <div class="seat business" data-seat="3A">3A</div>
                            <div class="seat business" data-seat="3B">3B</div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="seat business" data-seat="3C">3C</div>
                            <div class="seat business" data-seat="3D">3D</div>
                        </div>
                        <div class="seat-row">
                            <div class="seat business" data-seat="3A">3A</div>
                            <div class="seat business" data-seat="3B">3B</div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="seat business" data-seat="3C">3C</div>
                            <div class="seat business" data-seat="3D">3D</div>
                        </div>
                        <div class="seat-row">
                            <div class="seat business" data-seat="3A">3A</div>
                            <div class="seat business" data-seat="3B">3B</div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="aisle"></div>
                            <div class="seat business" data-seat="3C">3C</div>
                            <div class="seat business" data-seat="3D">3D</div>
                        </div>

                    </div>

                    <!-- ECONOMY CLASS -->
                    <div class="cabin economy">
                        <h2>Economy Class</h2>
                        <!-- 10 rows -->
                        <div class="seat-row">
                        <div class="seat economy" data-seat="6A">6A</div>
                        <div class="seat economy" data-seat="6B">6B</div>
                        <div class="seat economy" data-seat="6C">6C</div>
                        <div class="aisle"></div>
                        <div class="seat economy" data-seat="6D">6D</div>
                        <div class="seat economy" data-seat="6E">6E</div>
                        <div class="seat economy" data-seat="6F">6F</div>
                        </div>
                    <div class="seat-row">
                        <div class="seat economy" data-seat="6A">6A</div>
                        <div class="seat economy" data-seat="6B">6B</div>
                        <div class="seat economy" data-seat="6C">6C</div>
                        <div class="aisle"></div>
                        <div class="seat economy" data-seat="6D">6D</div>
                        <div class="seat economy" data-seat="6E">6E</div>
                        <div class="seat economy" data-seat="6F">6F</div>
                        </div>
                    <div class="seat-row">
                        <div class="seat economy" data-seat="6A">6A</div>
                        <div class="seat economy" data-seat="6B">6B</div>
                        <div class="seat economy" data-seat="6C">6C</div>
                        <div class="aisle"></div>
                        <div class="seat economy" data-seat="6D">6D</div>
                        <div class="seat economy" data-seat="6E">6E</div>
                        <div class="seat economy" data-seat="6F">6F</div>
                        </div>
                    <div class="seat-row">
                        <div class="seat economy" data-seat="6A">6A</div>
                        <div class="seat economy" data-seat="6B">6B</div>
                        <div class="seat economy" data-seat="6C">6C</div>
                        <div class="aisle"></div>
                        <div class="seat economy" data-seat="6D">6D</div>
                        <div class="seat economy" data-seat="6E">6E</div>
                        <div class="seat economy" data-seat="6F">6F</div>
                        </div>
                    <div class="seat-row">
                        <div class="seat economy" data-seat="6A">6A</div>
                        <div class="seat economy" data-seat="6B">6B</div>
                        <div class="seat economy" data-seat="6C">6C</div>
                        <div class="aisle"></div>
                        <div class="seat economy" data-seat="6D">6D</div>
                        <div class="seat economy" data-seat="6E">6E</div>
                        <div class="seat economy" data-seat="6F">6F</div>
                        </div>
                    <div class="seat-row">
                        <div class="seat economy" data-seat="6A">6A</div>
                        <div class="seat economy" data-seat="6B">6B</div>
                        <div class="seat economy" data-seat="6C">6C</div>
                        <div class="aisle"></div>
                        <div class="seat economy" data-seat="6D">6D</div>
                        <div class="seat economy" data-seat="6E">6E</div>
                        <div class="seat economy" data-seat="6F">6F</div>
                        </div>
                    <div class="seat-row">
                        <div class="seat economy" data-seat="6A">6A</div>
                        <div class="seat economy" data-seat="6B">6B</div>
                        <div class="seat economy" data-seat="6C">6C</div>
                        <div class="aisle"></div>
                        <div class="seat economy" data-seat="6D">6D</div>
                        <div class="seat economy" data-seat="6E">6E</div>
                        <div class="seat economy" data-seat="6F">6F</div>
                        </div>
                    
                    
                        </div>
                </div>
                            
                            <div class="form-actions">
                            <button class="cancel-btn" id="prev-btn1">Previous</button>
                            <button class="submit-btn" id="next-btn2">Next</button>
                            </div>
            </div>
            <div id="step3" class="step">
                <h2 class="step-title">Boarding Pass Preview</h2>
                
                <div id="pdf-preview-container" style="width: 100%; height: 400px; margin-bottom: 20px; border: 1px solid #ccc;">
                    <iframe id="pdf-frame" width="100%" height="100%" frameborder="0"></iframe>
                </div>

                <div class="button-group">
                    <button class="cancel-btn" id="prev-btn2">Previous</button>
                    <button type="submit" class="submit-btn" id="confirm-btn">Confirm & Print</button>
                </div>
            </div>
        
    </div>


    <script src="/static/js/check-in.js"></script>

</body>

<script>
    const table = document.getElementById("search-table");
    const searchBar = document.getElementById("search-bar");
    searchBar.addEventListener("keyup", () => {
        search("search-table");
    }, false);
</script>

</html>
