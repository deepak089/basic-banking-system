<?php 
include 'header.php';?>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transactions History</title>
</head>

<body>
    <?php include 'partials/dbConnect.php'; ?>
    <div class="container-fluid bg-overlay4 shadow">
        <?php include 'partials/nav.php'; ?>
        <div class="container my-5">
            <h1 class="text-center mt-2">Transactions History</h1>
            <div class="container shadow py-5 x-5 mx-5 my-5">
            <table id="myTable" class="table">
                <thead class="bg-dark text-light">
                    <th>S No.</th>
                    <th>Sender Id</th>
                    <th>Receiver Id</th>
                    <th>Transaction</th>
                    <th>Date</th>
                </thead>
                <tbody class="">
                    <?php
                    $query = 'SELECT * FROM `transaction_details`';
                    $result = mysqli_query($conn, $query);
                    $num_rows = mysqli_num_rows($result);
                    while ($rows = mysqli_fetch_assoc($result)) {
                        echo '
            <tr><td>' . $rows['id'] . '</td>
            <td>' . $rows['sender_id'] . '</td>
            <td>' . $rows['receiver_id'] . '</td>
            <td>Rs. ' . $rows['Amount'] . '</td>
            <td>' . $rows['Transaction_Time'] . '</td>
            </tr>
            ';
                    }
                    ?>
                </tbody>
            </table></div>
        </div>

    </div>
</body>

</html>