<?php
//session_start();
if (!isset($_SESSION['apriori_toko_id'])) {
    header("location:index.php?menu=forbidden");
}

include_once "database.php";
include_once "fungsi.php";
include_once "mining_apriori.php";
?>

 <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Hasil</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <?php
                    //object database class
                    $db_object = new database();

                    $pesan_error = $pesan_success = "";
                    if(isset($_GET['pesan_error'])){
                        $pesan_error = $_GET['pesan_error'];
                    }
                    if(isset($_GET['pesan_success'])){
                        $pesan_success = $_GET['pesan_success'];
                    }

                    $sql = "SELECT
                            *
                            FROM
                             process_log_apriori ";
                    $query=$db_object->db_query($sql);
                    $jumlah=$db_object->db_num_rows($query);
                    ?>

                    <!--end row-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <?php
                                        if (!empty($pesan_error)) {
                                            display_error($pesan_error);
                                        }
                                        if (!empty($pesan_success)) {
                                            display_success($pesan_success);
                                        }


                                        //echo "Jumlah data: ".$jumlah."<br>";
                                        if($jumlah==0){
                                                echo "Data kosong...";
                                        }
                                        else{
                                        ?>
                                </div>
                                <div class="card-body">
                                    <table id="add-rows" class="display table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Min Support</th>
                                                <th>Min Confidence</th>
                                                <th></th>
                                                <th>Pdf</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php
                                                $no=1;
                                                while($row=$db_object->db_fetch_array($query)){
                                                        echo "<tr>";
                                                        echo "<td>".$no."</td>";
                                                        echo "<td>".format_date2($row['start_date'])."</td>";
                                                        echo "<td>".format_date2($row['end_date'])."</td>";
                                                        echo "<td>".$row['min_support']."</td>";
                                                        echo "<td>".$row['min_confidence']."</td>";
                                                        $view = "<a href='index.php?menu=view_rule_apriori&id_process=".$row['id']."'>View rule</a>";
                                                        echo "<td>".$view."</td>";
                                                        echo "<td>";
                                                        echo "<a href='export/CLP_apriori.php?id_process=".$row['id']."' "
                                                                . "class='btn btn-outline-secondary' target='blank'>
                                                                <i class='ri-printer-fill'></i>
                                                                Print
                                                            </a>";
                                                        echo "</td>";
                            //                            echo "<td>Jika ".$jika.", Maka ".$maka."</td>";
                            //                            echo "<td>".price_format($row['confidence'])."</td>";
                                                    echo "</tr>";
                                                    $no++;
                                                }
                                                ?>
                                            
                                    </table>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div>
                <!-- container-fluid -->
            </div>
      