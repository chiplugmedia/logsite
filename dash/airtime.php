<?php
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/dash/includes/generalinclude.php";

$ptitle="Buy Airtime";
include "inc/eader21.php" ?>

<style>
    .absolxute{
        position: absolute;
    }
</style>
<!-- Content -->
        <div class="page-content-wrapper py-3">
    <div class="container">
       
          <div><?php echo $genMsg?></div>

<section class="section-b-space">
    <div class="custom-container">
        <form class="auth-form pt-0 mt-3" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="network" class="form-label f-14">Select Network</label>
                <select id="network" class="form-control network" aria-describedby="defaultFormControlHelp">
                    <option selected disabled>--select--</option>
                    <option value="mtn">MTN</option>
                    <option value="glo">Glo</option>
                    <option value="airtel">Airtel</option>
                    <option value="9mobile">9mobile</option>
                </select>
            </div>

            <div class="form-group">
                <label for="amount" class="form-label f-14">Enter amount</label>
                <div class="form-input">
                    <input type="number" id="amount" class="form-control amount" placeholder="500" aria-describedby="defaultFormControlHelp" />
                </div>
            </div>

            <div class="form-group">
                <label for="phone" class="form-label f-14">Enter phone number</label>
                <div class="form-input">
                    <input type="tel" id="phone" class="form-control phone" placeholder="09056564543" aria-describedby="defaultFormControlHelp" />
                </div>
            </div>

            <button type="button" name="buyAirtime" class="btn theme-btn w-100 proceed">Buy Airtime</button>
        </form>
    </div>
</section>



<section class="section-b-space">
    <div class="custom-container">
        <div class="card-body">
            <div class="mt-2">
                <h5>Recent Transactions</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="myTable">
                        <thead>
                            <tr>
                                <th >Trx Id</th>
                                <th>Desc</th>
                                <th>Phone</th>
                                <th>Amount</th>
                                <th>Transaction Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = $link->prepare("SELECT * FROM transactions WHERE username=? AND type='airtime' ORDER BY id DESC");
                            $sql->bind_param("s", $username);
                            $sql->execute();
                            $result = $sql->get_result();
                            $numrow = $result->num_rows;
                            if ($numrow > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id'];
                                    $desc = $row['description'];
                                    $date = $row['date'];
                                    $amountCharged = $row['amountcharged'];
                                    $phone = $row['number'];
                                    $status = $row['status'];
                            ?>
                                    <tr>
                                        <td>#<?php echo $id ?></td>
                                        <td class="name"><?php echo $desc ?></td>
                                        <td class="name"><?php echo $phone ?></td>
                                        <td class="text-danger">- ₦<?php echo number_format($amountCharged, 2) ?></td>
                                        <td><?php echo $date ?></td>
                                        <td class=" text"><?php echo $status ?></td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function() {
        $(".proceed").on("click", function() {
            let amount = $("#amount").val();
            let phone = $("#phone").val();
            let network = $("#network").val();
            let $this = $(this);
            let title, message, icon;

            if (!network) {
                title = "ERROR";
                icon = "error";
                message = "Select your network";
                popup(title, message, icon, false);
            } else if (!amount) {
                title = "ERROR";
                icon = "error";
                message = "Enter an amount";
                popup(title, message, icon, false);
            } else if (!phone) {
                title = "ERROR";
                icon = "error";
                message = "Enter your phone number";
                popup(title, message, icon, false);
            } else {
                title = "WARNING";
                icon = "info";
                message = "You are about to buy airtime of NGN " + amount + " " + network.toUpperCase() + " to " + phone + ". Do you want to proceed?";
                popup(title, message, icon, true, $this);
            }

            function popup(title, message, icon, confirm, $this) {
                Swal.fire({
                    title: '<strong>' + title + '</strong>',
                    icon: icon,
                    html: message,
                    showDenyButton: true,
                    confirmButtonText: 'Proceed',
                    denyButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed && confirm) {
                        $.ajax({
                            url: "actions/topup",
                            type: "POST",
                            data: {
                                buyAirtime: "buyAirtime",
                                amount: amount,
                                phone: phone,
                                network: network,
                            },
                            beforeSend: function() {
                                $this.html("Processing...");
                                $this.attr("disabled", true);
                            },
                            success: function(data) {
                                $this.html("Buy Airtime");
                                $this.attr("disabled", false);
                                $(".response").html(data);
                            }
                        });
                    }
                });
            }
        });
    });
</script>


<?php include "inc/footer2.php" ?>