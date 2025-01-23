<?php
// admin_home_service_bookings.php
include('dbconnection.php');

// Fetch all home service bookings
$query = "SELECT * FROM homeservicebookings 
          JOIN services s ON hs.service_id = s.id
          JOIN customers c ON hs.customer_id = c.id";
$result = mysqli_query($con, $query);

echo "<h1>Home Service Bookings</h1>";
echo "<table border='1'>
        <tr>
            <th>Customer Name</th>
            <th>Service</th>
            <th>Address</th>
            <th>Date</th>
            <th>Time</th>
            <th>Payment Status</th>
            <th>Booking Status</th>
        </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>" . $row['name'] . "</td>
            <td>" . $row['name'] . "</td>
            <td>" . $row['address'] . "</td>
            <td>" . $row['date'] . "</td>
            <td>" . $row['time'] . "</td>
            <td>" . $row['payment_status'] . "</td>
            <td>" . $row['booking_status'] . "</td>
          </tr>";
}

echo "</table>";
?>