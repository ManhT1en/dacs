<?php
  require('../inc/essentials.php');
  require('../inc/db_config.php');
  
  // Don't require admin login for debugging
  // adminLogin();

  if(isset($_POST['debug']))
  {
    echo "=== DEBUGGING BOOKINGS ===\n\n";
    
    // Check if tables exist
    $tables = ['booking_order', 'booking_details'];
    foreach($tables as $table) {
      $result = mysqli_query($con, "SHOW TABLES LIKE '$table'");
      if(mysqli_num_rows($result) > 0) {
        echo "✅ Table '$table' exists\n";
      } else {
        echo "❌ Table '$table' missing\n";
      }
    }
    
    echo "\n";
    
    // Check booking_order data
    echo "=== BOOKING_ORDER TABLE ===\n";
    $query = "SELECT booking_id, user_id, room_id, booking_status, order_id, datentime FROM booking_order ORDER BY booking_id DESC LIMIT 5";
    $result = mysqli_query($con, $query);
    
    if($result && mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        echo "ID: {$row['booking_id']}, Status: {$row['booking_status']}, Order: {$row['order_id']}, Date: {$row['datentime']}\n";
      }
    } else {
      echo "No data in booking_order table\n";
    }
    
    echo "\n";
    
    // Check booking_details data  
    echo "=== BOOKING_DETAILS TABLE ===\n";
    $query = "SELECT booking_id, user_name, phonenum, room_name FROM booking_details ORDER BY booking_id DESC LIMIT 5";
    $result = mysqli_query($con, $query);
    
    if($result && mysqli_num_rows($result) > 0) {
      while($row = mysqli_fetch_assoc($result)) {
        echo "ID: {$row['booking_id']}, User: {$row['user_name']}, Phone: {$row['phonenum']}, Room: {$row['room_name']}\n";
      }
    } else {
      echo "No data in booking_details table\n";
    }
    
    echo "\n";
    
    // Check the exact query used in new_bookings
    echo "=== TESTING NEW_BOOKINGS QUERY ===\n";
    $query = "SELECT bo.*, bd.* FROM `booking_order` bo
      INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
      WHERE (bo.booking_status='booked' AND bo.arrival=0) OR (bo.booking_status='pending')
      ORDER BY bo.booking_id DESC";
    
    $result = mysqli_query($con, $query);
    
    if($result) {
      $count = mysqli_num_rows($result);
      echo "Query executed successfully. Found $count records:\n";
      
      while($row = mysqli_fetch_assoc($result)) {
        echo "- Booking ID: {$row['booking_id']}, Status: {$row['booking_status']}, User: {$row['user_name']}\n";
      }
    } else {
      echo "Query failed: " . mysqli_error($con) . "\n";
    }
    
    echo "\n=== END DEBUG ===\n";
  }
?>