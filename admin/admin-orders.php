<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        StepX | Admin
    </title>
    <link rel="stylesheet" href="../styles/mystyles.css">
    <link rel="icon" href="../img/icon.png">
    <script src="../js/global.js"></script>
    <style>
        .TableForOrders {
            width: 70%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .TableForOrders th, .TableForOrders td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .TableForOrders th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body class="admin-orders">
    <div class="BackgroundImage"></div> <!-- Background image container -->
    <div class="Navigation" id="navbar">
        <h1><a href="../index.php">StepX</a></h1>
        <nav class="ClassForNav">
            <table class="TableForNav">
                <tr>
                    <td><a href="../logout.php">Logout</a></td>
                    <td><a href="admin-customers.php">Customers</a></td>
                </tr>
            </table>
        </nav>
    </div>

    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "stepx_database";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check for the POST
    if (isset($_POST['commitBtn']) && !empty($_POST['order_state'])) {
        foreach ($_POST['order_state'] as $order_id => $order_state) {
            $reject_reason = $_POST['reject_reason'][$order_id] ?? null;

            $sql = "UPDATE order_info SET order_state = ?, reject_reason = ? WHERE order_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $order_state, $reject_reason, $order_id);

            if ($stmt->execute()) {
                $success = true;
            } else {
                $success = false;
                break;
            }
        }

        if ($success) {
            echo "<script>alert('Order statuses updated successfully. Please refresh the page');</script>";
        } else {
            echo "<script>alert('Failed to update some order statuses');</script>";
        }

        $stmt->close();
    }
    ?>

    <div class="BoxForContents" id="box">
        <h2>New Orders</h2>
        <form action="admin-orders.php" method="POST" style="width: 70%">
            <table class="TableForOrders" style="width:100%!important">
                <tr>
                    <th>Order Id</th>
                    <th>Customer Name</th>
                    <th>Order State</th>
                </tr>
                <?php
                // Fetch orders
                $sql = "SELECT * FROM order_info WHERE order_state='new'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['order_id']}</td>";
                        echo "<td>{$row['customer_name']}</td>";
                        echo "<td>
                                <select name='order_state[{$row['order_id']}]' class='order-state' data-order-id='{$row['order_id']}' required>
                                    <option value='new' " . ($row['order_state'] == 'new' ? 'selected' : '') . ">New</option>
                                    <option value='delivered'>Delivered</option>
                                    <option value='not delivered'>Ship But Not Delivered</option>
                                    <option value='ordered'>Ordered/Accepted</option>
                                    <option value='cancelled'>Cancelled</option>
                                    <option value='rejected'>Rejected</option>
                                </select>
                            </td>";
                        echo "
                            <input type='hidden' name='reject_reason[{$row['order_id']}]' id='reject-reason-{$row['order_id']}' placeholder='Enter reason if rejected' disabled>
                            ";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No Orders Found!</td></tr>";
                }
                ?>
            </table>
            <button class="inputButton" type="submit" name="commitBtn">Commit All Changes</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stateSelectors = document.querySelectorAll('.order-state');

            stateSelectors.forEach(selector => {
                selector.addEventListener('change', function () {
                    const orderId = this.getAttribute('data-order-id');
                    const reasonInput = document.getElementById(`reject-reason-${orderId}`);

                    if (this.value === 'rejected') {
                        const reason = prompt('Please enter the reason for rejection:');
                        if (reason) {
                            reasonInput.value = reason;
                            reasonInput.disabled = false;
                        } else {
                            alert('Reason is required for rejection. Please try again.');
                            this.value = 'new'; // Reset to default
                            reasonInput.disabled = true;
                            reasonInput.value = '';
                        }
                    } else {
                        reasonInput.disabled = true;
                        reasonInput.value = ''; // Clear the input if not rejected
                    }
                });
            });
        });
    </script>

    <div class="BoxForContents admin" id="box">
        <h2>Orders in Process</h2>
        <table class="TableForOrders">
            <tr>
                <th>Order Id</th>
                <th>Customer Name</th>
                <th>Order State</th>
            </tr>
            <?php
            // Fetch orders
            $sql = "SELECT * FROM order_info WHERE order_state='ordered'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>", $row['order_id'], "</td>";
                    echo "<td>", $row["customer_name"], "</td>";
                    echo "<td>", $row["order_state"], "</td>";
                    echo "</tr>";
                }
            } else {
                echo "No Orders Found!";
            }
            ?>
        </table>
    </div>
    <div class="BoxForContents admin" id="box">
        <h2>Rejected</h2>
        <table class="TableForOrders">
            <tr>
                <th>Order Id</th>
                <th>Customer Name</th>
                <th>Order State</th>
                <th>Reason</th>
            </tr>
            <?php
            // Fetch orders
            $sql = "SELECT * FROM order_info WHERE order_state='rejected'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>", $row['order_id'], "</td>";
                    echo "<td>", $row["customer_name"], "</td>";
                    echo "<td>", $row["order_state"], "</td>";
                    echo "<td>", $row["reject_reason"], "</td>";
                    echo "</tr>";
                }
            } else {
                echo "No Orders Found!";
            }
            ?>
        </table>
    </div>
    <div class="BoxForContents admin" id="box">
        <h2>Delivered Orders</h2>
        <table class="TableForOrders">
            <tr>
                <th>Order Id</th>
                <th>Customer Name</th>
                <th>Order State</th>
            </tr>
            <?php
            // Fetch orders
            $sql = "SELECT * FROM order_info WHERE order_state='delivered'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>", $row['order_id'], "</td>";
                    echo "<td>", $row["customer_name"], "</td>";
                    echo "<td>", $row["order_state"], "</td>";
                    echo "</tr>";
                }
            } else {
                echo "No Orders Found!";
            }
            ?>
        </table>
    </div>
    <?php $conn->close(); ?>
</body>
</html>