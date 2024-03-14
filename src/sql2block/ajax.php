<?php
// Get the SQL command from the AJAX request
$sql = $_POST['sql'];

// Connect to the database
$connection = mysqli_connect('mariadb', 'root', 'password', 'test');

// Function to run the SQL command
function run_sql($s, $l) {
    $result = mysqli_query($l, $s);

    if (!$result) {
        return mysqli_error($l);
    } else {
        $output = '';
        
        if ($result === true) {
            $output .= 'Запрос успешно выполнился!';
        } else {
            $output .= '<table border="1"><tr>';
            
            for ($i = 0; $i < mysqli_num_fields($result); $i++) {
                $field_info = mysqli_fetch_field_direct($result, $i);
                $output .= '<th>' . $field_info->name . '</th>';
            }
            
            $output .= '</tr>';
            
            while ($row = mysqli_fetch_assoc($result)) {
                $output .= '<tr>';
                foreach ($row as $field_value) {
                    $output .= '<td>' . $field_value . '</td>';
                }
                $output .= '</tr>';
            }
            
            $output .= '</table>';
        }
        
        return $output;
    }
}

// Run the SQL command
$result = run_sql($sql, $connection);

// Send the result back to the AJAX request
echo $result;

// Close the connection to the database
mysqli_close($connection);
?>
