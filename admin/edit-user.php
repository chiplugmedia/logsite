<?php 
require $_SERVER['DOCUMENT_ROOT']."/stream.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/includes/generalinclude.php";
require $_SERVER['DOCUMENT_ROOT']."$stream/admin/actions/edit-user.php";

if(!isset($_GET['username'])){
    header("location:$stream/user/admin/dashboard.php");
    exit;
}
$username=$_GET['username'];
$sql=$link->prepare("SELECT * FROM users WHERE username=?");
$sql->bind_param("s", $username);
$sql->execute();
$result=$sql->get_result();
$row=$result->fetch_assoc();
$numrow=$result->num_rows;
$fullname=$email=$phone=$funds=$fbLink=$igLink=$twLink=$ytLink="";
if($numrow > 0){
    $fullname=$row['fullname'];
    $email=$row['email'];
    $phone=$row['phone'];
    $funds=$row['funds'];

    $sql=$link->prepare("SELECT * FROM profilelinks WHERE username=? AND type='facebook' ");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result=$sql->get_result();
    $row=$result->fetch_assoc();
    $numrow=$result->num_rows;
    if($numrow > 0){
        $fbLink=$row['url'];
    }
    $sql=$link->prepare("SELECT * FROM profilelinks WHERE username=? AND type='youtube' ");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result=$sql->get_result();
    $row=$result->fetch_assoc();
    $numrow=$result->num_rows;
    if($numrow > 0){
        $ytLink=$row['url'];
    }
    $sql=$link->prepare("SELECT * FROM profilelinks WHERE username=? AND type='instagram' ");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result=$sql->get_result();
    $row=$result->fetch_assoc();
    $numrow=$result->num_rows;
    if($numrow > 0){
        $igLink=$row['url'];
    }
    $sql=$link->prepare("SELECT * FROM profilelinks WHERE username=? AND type='twitter' ");
    $sql->bind_param("s", $username);
    $sql->execute();
    $result=$sql->get_result();
    $row=$result->fetch_assoc();
    $numrow=$result->num_rows;
    if($numrow > 0){
        $twLink=$row['url'];
    }
}

include"inc/header.php" ;

?>



                <div class="container-fluid">

                    <div class="layout-specing">
                        <br>
                        <?php echo $genMsg?>
                        <div class="d-md-flex justify-content-between align-items-center">

                            <h5 class="mb-0">Users</h5>



                            <nav aria-label="breadcrumb" class="d-inline-block mt-2 mt-sm-0">

                                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">

                                    <li class="breadcrumb-item text-capitalize"><a href="dashboard.php"><?php echo $sitename ?></a></li>

                                    <li class="breadcrumb-item text-capitalize"><a href="#">Pages</a></li>

                                    <li class="breadcrumb-item text-capitalize active" aria-current="page">Users </li>

                                </ul>

                            </nav>

                        </div>

                    

                        <div class="row">

                            <div class="col-md-7 col-lg-8 mt-4">

                                <div class="card rounded shadow p-4 border-0">

                                    <h4 class="mb-3"> Edit User</h4>

                                    <form method="POST">

                                        <div class="row g-3">

                                        <div class="col-md-5">

                                            <label for="username" class="form-label">UserName</label>

                                                <input type="text" class="form-control" id="username" placeholder="" name="username" value="<?php echo $username?>" readonly>

                                                

                                            </div>

                                            

        

                                            <div class="col-md-5">

                                            <label for="name" class="form-label">Full Name</label>

                                                <input type="text" class="form-control" id="name" placeholder=""  name="fullname" value="<?php echo $fullname?>">

                                                

                                            </div>

        

                                            

                                            

                                            <div class="col-md-3">

                                                <label for="email" class="form-label">Email</label>

                                                <input type="text" class="form-control" id="email" placeholder=""  name="email" value="<?php echo $email?>" readonly>

                                                

                                            </div>

                                        

        

                                            <div class="col-md-5">

                                                <label for="number" class="form-label">Phone Number</label>

                                                <input type="text" class="form-control" id="number" placeholder=""  name="phone" value="<?php echo $phone?>">

                                                <div class="invalid-feedback">

                                                    Valid Number  .

                                                </div>

                                            </div>

                                            <div class="col-md-5">

                                                <label for="wallet-bal" class="form-label">Main Balance</label>

                                                <input type="text" class="form-control" id="wallet-bal" placeholder=""  name="funds" value="<?php echo $funds?>">

                                                <div class="invalid-feedback">

                                                    Valid Number  .

                                                </div>

                                            </div>

                                            
                                            

                                        </div>

        

        

                                        <button class="w-100 btn btn-primary" type="submit" name="update">Save</button>

                                    </form>

                                </div>

                            </div><!--end col-->

                        </div><!--end row-->

                    </div>

                </div><!--end container-->



<?php include"inc/footer.php" ?>

                