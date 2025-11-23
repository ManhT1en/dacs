<?php

  // ========================================
  // DATABASE CONNECTION CONFIGURATION
  // ========================================
  
  // Database connection parameters
  $hname = '127.0.0.1:3306';        // Database host and port
  $uname = 'root';                   // Database username
  $pass = 'NewStrongPass!';          // Database password
  $db = 'vietchill';                 // Database name

  // Establish MySQL database connection
  $con = mysqli_connect($hname, $uname, $pass, $db);

  // Check if connection was successful, terminate script if failed
  if(!$con){
      die("Cannot Connect to Database".mysqli_connect_error());
  }

  // ========================================
  // DATA SANITIZATION FUNCTION
  // ========================================
  
  /**
   * Sanitizes and filters input data to prevent XSS and injection attacks
   * @param array $data - Array of data to be sanitized
   * @return array - Sanitized data array
   */
  function filteration($data) {
    foreach($data as $key => $value){
      $value = trim($value);              // Remove whitespace from beginning and end
      $value = htmlspecialchars($value);  // Convert special characters to HTML entities
      $value = stripslashes($value);      // Remove backslashes
      $value = strip_tags($value);        // Strip HTML and PHP tags
      $data[$key] = $value;
    }
    return $data;
  }
  
  // ========================================
  // DATABASE QUERY FUNCTIONS
  // ========================================
  
  /**
   * Selects all records from a specified table
   * @param string $table - Name of the database table
   * @return mysqli_result - Query result object
   */
  function selectAll($table) {
    $con = $GLOBALS['con'];
    $res = mysqli_query($con, "SELECT * FROM $table");
    return $res;
  }
  
  /**
   * Executes a prepared SELECT statement with parameters
   * @param string $sql - SQL query with placeholders
   * @param array $values - Array of values to bind to placeholders
   * @param string $datatypes - String of data types (e.g., 'ssi' for string, string, integer)
   * @return mysqli_result - Query result object
   */
  function select($sql, $values, $datatypes) {
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con, $sql)){
      mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
      if(mysqli_stmt_execute($stmt)){
        $res = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
        return $res;
      }
      else{
        mysqli_stmt_close($stmt);
        die("Query cannot be executed - Execute");
      }
    }
    else{
      die("Query cannot be executed - Select");
    }
  }

  /**
   * Executes a prepared UPDATE statement with parameters
   * @param string $sql - UPDATE SQL query with placeholders
   * @param array $values - Array of values to bind to placeholders
   * @param string $datatypes - String of data types
   * @return int - Number of affected rows
   */
  function update($sql, $values, $datatypes) {
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con, $sql)){
      mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
      if(mysqli_stmt_execute($stmt)){
        $res = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $res;
      }
      else{
        mysqli_stmt_close($stmt);
        die("Query cannot be executed - Update");
      }
    }
    else{
      die("Query cannot be executed - Update");
    }
  }

  /**
   * Executes a prepared INSERT statement with parameters
   * @param string $sql - INSERT SQL query with placeholders
   * @param array $values - Array of values to bind to placeholders
   * @param string $datatypes - String of data types
   * @return int - Number of affected rows (usually 1 if successful)
   */
  function insert($sql,$values,$datatypes) {
		$con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con, $sql)){
      mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
      if(mysqli_stmt_execute($stmt)){
        $res = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $res;
      }
      else{
        mysqli_stmt_close($stmt);
        die("Query cannot be executed - Insert");
      }
    }
    else{
      die("Query cannot be executed - Insert");
    }
	}

  /**
   * Executes a prepared DELETE statement with parameters
   * @param string $sql - DELETE SQL query with placeholders
   * @param array $values - Array of values to bind to placeholders
   * @param string $datatypes - String of data types
   * @return int - Number of affected rows (deleted records)
   */
  function delete($sql, $values, $datatypes) {
    $con = $GLOBALS['con'];
    if($stmt = mysqli_prepare($con, $sql)){
      mysqli_stmt_bind_param($stmt, $datatypes, ...$values);
      if(mysqli_stmt_execute($stmt)){
        $res = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        return $res;
      }
      else{
        mysqli_stmt_close($stmt);
        die("Query cannot be executed - Delete");
      }
    }
    else{
      die("Query cannot be executed - Delete");
    }
  }
?>