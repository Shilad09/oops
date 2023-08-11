<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ajax";

$conn = new mysqli($servername, $username, $password, $dbname) or die("Connection error");

$sql = "SELECT * FROM `students`";

$result = $conn->query($sql);

$output = "";
if($result->num_rows > 0){
    $output = "<table border='1px' cellspacing='0' cellpadding='5px' align='center' width='50%'>
    <tr>
    <th>Id</th>
    <th>Name</th>
    </tr>";
    while($row = $result->fetch_assoc()){
        $output .= "<tr align='center'>
        <td>{$row['id']}</td>
        <td>{$row['f_name']} {$row['l_name']}</td>
        </tr>";
    }
    $output .= "</table>";
    echo $output;
}
else{
    echo "No record found";
}

$conn->close();

?>