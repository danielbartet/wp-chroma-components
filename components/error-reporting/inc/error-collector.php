<?php
// if ( ! defined( 'ABSPATH' ) )
//      exit;

//register endpoint route
add_action( 'rest_api_init', function () {
  register_rest_route( 'chroma', '/ecollector', array(
    'methods' => 'POST',
    'callback' => 'chroma_error_collector',
  ) );
} );

//collector as callback
function chroma_error_collector(WP_REST_Request $request) {
  $accepted_origins = array('https://alltimelists.com','https://healthiguide.com','https://www.healthiguide.com', 'https://idropnews.com','http://216.174.80.158','http://34.227.68.226','http://216.174.80.133');
  if(!in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins))
    return new WP_REST_Response('You are definitely not allowed to do this. Get out of here!', 403);
  try {
    if ( $request->get_param('client_error') && !empty($request->get_param('client_error')) ) {
      //initialize server sql connection variables
      $servername = DB_HOST;
      $username = LIMITED_USER;
      $password = LIMITED_PASSWORD;
      $db_name = DB_NAME;

      $conn = new mysqli($servername, $username, $password, $db_name);

      // Check connection
      if ($conn->connect_error) {
        return new WP_REST_Response('You may not connect to this service!' . $conn->connect_error, 500);
        exit();
      }

      //check if table already exists, if not make it
      $error_table = mysqli_query($conn, "SELECT * FROM 'chromaErrors' LIMIT 1");
      if ($error_table === false) {
        //create table
        $create_table = "CREATE TABLE chromaErrors (
        id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        error_msg VARCHAR(1000) NOT NULL
        )";
        $conn->query($create_table);

        // prepare and bind
        $prepared_statement = $conn->prepare("INSERT INTO chromaErrors (error_msg) VALUES (?)");
        $prepared_statement->bind_param("s", $error_msg);
        $error_msg = sanitize_input($conn, $request->get_param('client_error'));
        $prepared_statement->execute();
        $prepared_statement->close();
        $conn->close();
        return new WP_REST_Response('Success!', 200);
      }
    }
    else
      return new WP_REST_Response("No data sent in request", 403);
  } catch(Exception $e) {
    return new WP_REST_Response($e->getMessage(), 500);
  }
}
//sanitization helper
function sanitize_input($conn, $data) {
  $data = strtolower($data);
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = mysqli_real_escape_string($conn, $data);
  return $data;
}
