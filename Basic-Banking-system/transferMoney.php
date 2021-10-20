<?php
$success = false;
$failure = false;
$Abort = false;

include 'partials/dbConnect.php';


if (isset($_POST['submit'])) {

    $userFrom = $_POST['userFrom'];
    $userTo = $_POST['userTo'];
    $tAmount = $_POST['tAmount'];

    $sql1 = "SELECT * FROM `users` WHERE `S_No.`=$userFrom";
    $result1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($result1);

    $sql2 = "SELECT * FROM `users` WHERE `S_No.`=$userTo";
    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);

    if ($tAmount > $row1['Amount']) {
        $failure = true;
    } else if ($tAmount <= 0) {
        $Abort = true;
    } else {
        $updatedAmount1 = $row1['Amount'] - $tAmount;
        $updatedAmount2 = $row2['Amount'] + $tAmount;
        $sql = "UPDATE `users` SET `Amount`=$updatedAmount1 WHERE `S_No.`=$userFrom";
        $result = mysqli_query($conn, $sql);

        $sql = "UPDATE `users` SET `Amount`=$updatedAmount2 WHERE `S_No.`=$userTo";
        $result = mysqli_query($conn, $sql);

        $sender = $row1['User_Id'];
        $receiver = $row2['User_Id'];
        $query = "INSERT INTO transaction_details( `sender_id`, `receiver_id`, `Amount`) VALUES('$sender', '$receiver', '$tAmount')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $success = true;
        }
    }
}
?>

<?php include 'header.php';?>
    <title>Transfer Money</title>
</head>

<body>
    <div class="container-fluid bg-overlay3">
        <?php include 'partials/nav.php'; ?>
        <div class="container mt-5">
            <h1 class="text-center mt-5">Transfer Money</h1>
            <h4 class="text-center text-success">
                <?php if ($success) echo 'Transaction Successful'; ?>
                <?php if ($failure) echo "Not enough Balance"; ?>
                <?php if ($Abort) echo "Amount should be greater than zero"; ?>
            </h4>
            <div class="container shadow  py-5 my-5 px-5">
            <form method="POST">
                <div class="row">
                    <div class="my-3 col-md-6">
                        <label for="amount" class="my-2">Transfer From</label>
                        <select class="form-select" aria-label="Default select example" name="userFrom">
                            <option></option>
                            <?php
                            $query = 'SELECT * FROM `users`';
                            $result = mysqli_query($conn, $query);
                            $num_rows = mysqli_num_rows($result);
                            while ($rows = mysqli_fetch_assoc($result)) {
                            ?>
                            <option value="<?php echo $rows['S_No.'] ?>">
                                <?php echo $rows['User_Name'] ?> (Id -
                                <?php echo $rows['User_Id'] ?>) (<?php echo $rows['Amount'] ?>)</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="my-3 col-md-6">
                        <label for="amount" class="my-2">Transfer To</label>
                        <select class="form-select" aria-label="Default select example" name="userTo">
                            <option></option>
                            <?php
                            $query = 'SELECT * FROM `users`';
                            $result = mysqli_query($conn, $query);
                            $num_rows = mysqli_num_rows($result);
                            while ($rows = mysqli_fetch_assoc($result)) {
                            ?>
                            <option value="<?php echo $rows['S_No.'] ?>"><?php echo $rows['User_Name'] ?> (Id -
                                <?php echo $rows['User_Id'] ?>) (<?php echo $rows['Amount'] ?>)</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="">
                    <label for="amount" class="my-2">Amount To Transfer</label>
                    <input type="number" class="form-control" name="tAmount" placeholder="Enter Amount to tranfer">
                </div>
                <button type="submit" name="submit" class="btn btn-secondary col-sm-12 mt-4">Transfer</button>

            </form></div>
            
        </div>
    </div>


</body>

</html>