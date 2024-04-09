<?php 

add_action('admin_menu', 'display_errors_to_admin_menu');

function display_errors_to_admin_menu() {
    add_menu_page('Display iDrop Errors', 'Display iDrop Errors', 'administrator', __FILE__, 'display_errors' , 'dashicons-list-view' );
}

function display_errors() {
    if (!current_user_can('manage_options')) {
        wp_die( __('You do not have sufficient permissions to access this page.'));
    }
    ?>
    <style>
        .errorbox {
            max-width: 90%;
            max-height: 800px;
            overflow-y: scroll;
            overflow-x: hidden;
            background: #000;
            color: red;
        }
        .error-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .header-container {
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .header-container button {
            margin: 2% 0;
            background: #c42400;
            color: white;
            border: none;
            width: 150px;
            border-radius: 15px;
            height: 50px;
            cursor: pointer;
            font-size: 1.2em;
        }
        .header-container button:focus {
            outline: none;
        }
        .error_notified {
            display: flex;
            justify-content: center;
            flex-direction: column;
            margin: 2% 0;
            align-items: center;
        }
        .error_notified p {
            margin: 0;
            font-size: 1.2em;
            color: forestgreen;
        }
    </style>
        <div class='error-container'>
            <form class='header-container' method='post'>
            <h1>iDrop Errors</h1>
            <button name='delete'>Delete</button>
            </form>
            <?php
                try {
                    $servername = DB_HOST;
                    $username = DB_USER;
                    $password = DB_PASSWORD;
                    $db_name = DB_NAME;

                    $conn = new mysqli($servername, $username, $password, $db_name);

                    if($conn->connect_error) {
                        die('Connection failed: ' . $conn->connect_error);
                    }
                    $error_message_query = "SELECT error_msg FROM chromaErrors ORDER BY id DESC LIMIT 1000";
                    $id_query = "SELECT id FROM chromaErrors ORDER BY id DESC LIMIT 1000";
                    $id = $conn->query($id_query);
                    $result = $conn->query($error_message_query);
                    $error_message = '';
                    if($result->num_rows > 0) {
                        echo "<div class='errorbox'>";
                        for($i = 0; $i < $result->num_rows; $i++) {
                            $row = $result->fetch_assoc();
                            $id_num = $id->fetch_assoc();
                            echo 'ID:' . $id_num['id'] . ': ' . $row['error_msg'];
                            echo "<br />";
                            echo "<br />";
                        }
                        echo "</div>";
                    } else {
                        echo "There are no errors found.";
                    }
                    if(isset($_POST['delete'])) {
                        $last_elem = "SELECT id FROM chromaErrors ORDER BY id DESC LIMIT 1";
                        $last_query = $conn->query($last_elem);
                        $last_id = 0;
                        if($last_query->num_rows > 0) {
                            $last = $last_query->fetch_array();
                            foreach($last as $key => $value) {
                                $last_id = $value;
                            }
                            $saved_rows = $last_id - 1000;
                        }
                        $delete_query = "DELETE FROM chromaErrors WHERE id < $saved_rows";
                        $delete_stm = $conn->prepare($delete_query);
                        $delete_stm->execute();
                        $first_elem = "SELECT id FROM chromaErrors LIMIT 1";
                        $first_query = $conn->query($first_elem);
                        $first = $first_query->fetch_array();
                        $first_id = 0;
                        foreach($first as $key => $value) {
                            $first_id = $value;
                        }
                        echo "<div class = 'error_notified'><p>Rows between $first_id and $last_id have been saved.</p>";
                        echo "<p>Errors successfully deleted. </p></div>";
                    }

                } catch(Exception $e) {
                    echo $e;
                }
            ?>
        </div>
    <?php
}