<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['submitBtn'])) {
    // Retrieve form data
    $service_id = $_POST['service_id'];
    $address = $_POST['address'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $payment_status = $_POST['payment_status'];
    
    // Assume the customer is logged in and their ID is stored in session

    if (strlen($_SESSION['bpmsuid']) == 0) {
        header('location:logout.php');
        exit(); // it's good practice to exit after a redirect
    } else {
        $customer_id = $_SESSION['bpmsuid'];
    }
    

    // Prepare the SQL query to prevent SQL injection
    $query = $con->prepare("INSERT INTO homeservicebookings (customer_id, service_id, address, date, time, payment_status, booking_status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $booking_status = 'pending';  // Default booking status
    
    // Bind the parameters and execute the query
    $query->bind_param("iisssss", $customer_id, $service_id, $address, $date, $time, $payment_status, $booking_status);

    if ($query->execute()) {
        echo "<div class='alert alert-success'>Home service booked successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $query->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Home Service</title>
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            padding: 0 20px;
        }

        h1 {
            text-align: center;
            margin: 40px 0;
            font-size: 32px;
            color: #2c3e50;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
            color: #2c3e50;
        }

        select, input[type="date"], input[type="time"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
            resize: none;
        }

        button {
            background-color: #3498db;
            color: white;
            font-size: 16px;
            padding: 14px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        button:hover {
            background-color: #2980b9;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
        }

        .alert-success {
            background-color: #2ecc71;
            color: white;
        }

        .alert-danger {
            background-color: #e74c3c;
            color: white;
        }

        #movetop {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: #3498db;
            color: white;
            font-size: 24px;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
            display: none;
            transition: background-color 0.3s;
        }

        #movetop:hover {
            background-color: #2980b9;
        }

        @media screen and (max-width: 768px) {
            form {
                padding: 20px;
            }
        }
    </style>
</head>
<body id="home">
    <?php include_once('includes/header.php'); ?>

    <h1>Book a Home Service</h1>
    <form action="" method="POST">
        <label for="service">Choose a Service:</label>
        <select name="service_id" id="service">
            <?php
            $result = mysqli_query($con, "SELECT * FROM services");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . " - $" . $row['price'] . "</option>";
            }
            ?>
        </select>

        <label for="address">Enter your address:</label>
        <textarea name="address" id="address" required></textarea>

        <label for="date">Select Date:</label>
        <input type="date" name="date" id="date" required>

        <label for="time">Select Time:</label>
        <input type="time" name="time" id="time" required>

        <label for="payment">Payment Status:</label>
        <select name="payment_status" id="payment">
            <option value="pending">Pending</option>
            <option value="paid">Paid</option>
        </select>

        <button name="submitBtn">Book Now</button>
    </form>

    <?php include_once('includes/footer.php'); ?>

    <button onclick="topFunction()" id="movetop" title="Go to top">
        <span class="fa fa-long-arrow-up"></span>
    </button>

    <script>
        // Scroll to top functionality
        window.onscroll = function () {
            scrollFunction();
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("movetop").style.display = "block";
            } else {
                document.getElementById("movetop").style.display = "none";
            }
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
</body>
</html>
