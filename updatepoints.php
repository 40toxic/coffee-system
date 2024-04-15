<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
// Fetch existing customers
$customerQuery = "SELECT customer_id, customer_name FROM colos_customers";
$customerResult = $mysqli->query($customerQuery);

// Add Customer
if (isset($_POST['addCustomer'])) {
    // Prevent Posting Blank Values
    if (empty($_POST["customer_id"]) || empty($_POST['customer_points'])) {
        $err = "Blank Values Not Accepted";
    } else {
        $customer_id = $_POST['customer_id'];
        $customer_points = $_POST['customer_points'];

        // Insert Captured information to a database table
        $postQuery = "INSERT INTO colos_customers_points (customer_id, customer_points) VALUES(?, ?)";
        $postStmt = $mysqli->prepare($postQuery);
        // Bind parameters
        $postStmt->bind_param('ss', $customer_id, $customer_points);
        $postStmt->execute();
        // Declare a variable which will be passed to alert function
        if ($postStmt) {
            $success = "Customer Points Added" && header("refresh:1; url=Dashboard.php");
        } else {
            $err = "Please Try Again Or Try Later";
        }
    }
}
// colos_customer_points.php

// Fetch total points for a customer
function getTotalPoints($customer_id) {
    global $mysqli;
    $query = "SELECT SUM(customer_points) AS total_points FROM colos_customer_points WHERE customer_id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total_points'];
}


require_once('partials/_head.php');
?>

<body>

    <!-- Sidenav -->
    <?php
    require_once('partials/_sidebar.php');
    ?>
    <!-- Main content -->
    <div class="main-content">
        <!-- Top navbar -->
        <?php
        require_once('partials/_topnav.php');
        ?>
        <!-- Header -->
        <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
            <span class="mask bg-gradient-dark opacity-8"></span>
            <div class="container-fluid">
                <div class="header-body">
                </div>
            </div>
        </div>
        <!-- Page content -->
        <div class="container-fluid mt--8">
            <!-- Table -->
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header border-0">
                            <h3>Please Fill All Fields</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label>Customer Name</label>
                                        <select name="customer_id" class="form-control">
                                            <?php
                                            while ($row = $customerResult->fetch_assoc()) {
                                                echo "<option value='" . $row['customer_id'] . "'>" . $row['customer_name'] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Customer Points</label>
                                        <input type="text" name="customer_points" class="form-control" value="">
                                    </div>
                                </div>
                                <button type="submit" name="addCustomer" class="btn btn-primary mt-3">Add Points</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <?php
            require_once('partials/_footer.php');
            ?>
        </div>
    </div>
    <!-- Argon Scripts -->
    <?php
    require_once('partials/_scripts.php');
    ?>
</body>

</html>
