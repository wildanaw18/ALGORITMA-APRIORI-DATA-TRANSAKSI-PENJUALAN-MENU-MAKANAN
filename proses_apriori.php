<?php
//session_start();
if (!isset($_SESSION['apriori_parfum_id'])) {
    header("location:index.php?menu=forbidden");
}

include_once "database.php";
include_once "fungsi.php";
include_once "mining_apriori.php";
include_once "display_mining_apriori.php";
$starttime = microtime(true);
?>



<!-- page specific plugin styles -->

<!-- page specific plugin styles -->


<link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
<link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
<link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
<link rel="stylesheet" href="assets/css/bootstrap-colorpicker.min.css" />


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Proses Apriori</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <?php
//object database class
$db_object = new database();

$pesan_error = $pesan_success = "";
if (isset($_GET['pesan_error'])) {
    $pesan_error = $_GET['pesan_error'];
}
if (isset($_GET['pesan_success'])) {
    $pesan_success = $_GET['pesan_success'];
}

if (isset($_POST['submit'])) {
    $can_process = true;
    if (empty($_POST['min_support']) || empty($_POST['min_confidence'])) {
        $can_process = false;
        ?>
        <script>
            location.replace("?menu=proses_apriori&pesan_error=Min Support dan Min Confidence harus diisi");
        </script>
        <?php
    }
    if(!is_numeric($_POST['min_support']) || !is_numeric($_POST['min_confidence'])){
        $can_process = false;
        ?>
        <script>
            location.replace("?menu=proses_apriori&pesan_error=Min Support dan Min Confidence harus diisi angka");
        </script>
        <?php
    }
    //  01/09/2016 - 30/09/2016

    if($can_process){
        $tgl = explode(" - ", $_POST['range_tanggal']);
        $start = format_date($tgl[0]);
        $end = format_date($tgl[1]);

        if(isset($_POST['id_process'])){
            $id_process = $_POST['id_process'];
            //delete hitungan untuk id_process
            reset_hitungan($db_object, $id_process);

            //update log process
            $field = array(
                            "start_date"=>$start,
                            "end_date"=>$end,
                            "min_support"=>$_POST['min_support'],
                            "min_confidence"=>$_POST['min_confidence']
                        );
            $where = array(
                            "id"=>$id_process
                        );
            $query = $db_object->update_record("process_log_apriori", $field, $where);
        }
        else{
            //insert log process
            $field_value = array(
                            "start_date"=>$start,
                            "end_date"=>$end,
                            "min_support"=>$_POST['min_support'],
                            "min_confidence"=>$_POST['min_confidence']
                        );
            $query = $db_object->insert_record("process_log_apriori", $field_value);
            $id_process = $db_object->db_insert_id();
        }
        //show form for update
        ?>

        <!-- Form Filter Tanggal -->

        <form method="post" action="">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Tanggal</h4>
                            <div class="flex-shrink-0">
                                <div class="form-check form-switch form-switch-right form-switch-md">
                                    <label for="radio-toggle-shocade" class="form-label text-muted">Sembunyikan
                                        Tanggal</label>
                                    <input class="form-check-input code-switcher" type="checkbox"
                                        id="radio-toggle-shocade">
                                </div>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">

                            <div class="live-preview">
                                <div class="hstack gap-2 flex-wrap">
                                    <input type="text" name="range_tanggal" class="form-control pull-right" required=""
                                        placeholder="Date range" value="<?php echo $_POST['range_tanggal']; ?>">
                                    <input type="submit" class="btn btn-outline-secondary" name="search_display"
                                        value="Search">
                                </div>
                            </div>

                        </div>
                        <!--end card-body-->
                    </div>
                    <!--end card-->
                </div> <!-- end col -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Nilai Awal</h4>
                            <div class="flex-shrink-0">
                                <div class="form-check form-switch form-switch-right form-switch-md">
                                    <label for="outline-style-shocade" class="form-label text-muted">Show Code</label>
                                    <input class="form-check-input code-switcher" type="checkbox"
                                        id="outline-style-shocade">
                                </div>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">

                            <div class="live-preview">

                                <div class="hstack gap-2 flex-wrap">
                                    <input name="min_support" type="text" class="form-control"
                                        placeholder="Min Support">
                                    <input name="min_confidence" type="text" class="form-control"
                                        placeholder="Min Confidence">
                                    <input name="submit" type="submit" value="Proses" class="btn btn-outline-success">
                                </div>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->

            </div>
        </form>

        <?php
         $time = microtime();
         $time = explode(' ', $time);
         $time = $time[1] + $time[0];
         $finish = $time;
         $total_time = round(($finish - $starttime), 4);


        $min = floor($total_time / 1000 / 60);
        $sec = floor($total_time * 1000);

        echo "Min Support Absolut: " . $_POST['min_support'];
        echo "<br>";
        $sql = "SELECT COUNT(*) FROM transaksi 
        WHERE transaction_date BETWEEN '$start' AND '$end' ";
        $res = $db_object->db_query($sql);
        $num = $db_object->db_fetch_array($res);
        $minSupportRelatif = ($_POST['min_support']/$num[0]) * 100;
        echo "Min Support Relatif: " . $minSupportRelatif;
        echo "<br>";
        echo "Min Confidence: " . $_POST['min_confidence'];
        echo "<br>";
        echo "Start Date: " . $_POST['range_tanggal'];
        echo "<br>";
        echo "Waktu Proses: " . $sec . " detik";
        echo "<br>";
        
        $result = mining_process($db_object, $_POST['min_support'], $_POST['min_confidence'],
                $start, $end, $id_process);
        if ($result) {
            print_r("<script>
            Swal.fire(
                'Success!',
                'Proses mining selesai',
                'success'
              )
            </script>") ;
        } else {
            print_r("<script>
            Swal.fire(
                'Upps!',
                'Gagal mendapatkan aturan asosiasi',
                'info'
              )
            </script>") ;
        }

        display_process_hasil_mining($db_object, $id_process);
    }
               
} 
else {
    $where = "ga gal";
    if(isset($_POST['range_tanggal'])){
        $tgl = explode(" - ", $_POST['range_tanggal']);
        $start = format_date($tgl[0]);
        $end = format_date($tgl[1]);
        
        $where = " WHERE transaction_date "
                . " BETWEEN '$start' AND '$end'";
    }
    $sql = "SELECT
        *
        FROM
         transaksi ".$where;
    
    $query = $db_object->db_query($sql);
    $jumlah = $db_object->db_num_rows($query);
    ?>

        <form method="post" action="">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Tanggal</h4>
                            <div class="flex-shrink-0">
                                <div class="form-check form-switch form-switch-right form-switch-md">
                                    <label for="radio-toggle-shocade" class="form-label text-muted">Sembunyikan</label>
                                    <input class="form-check-input code-switcher" type="checkbox"
                                        id="radio-toggle-shocade">
                                </div>
                            </div>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <div class="hstack gap-2 flex-wrap">
                                    <input type="text" name="range_tanggal" class="form-control pull-right" required=""
                                        placeholder="Date range" value="<?php echo $_POST['range_tanggal']; ?>">
                                    <input type="submit" class="btn btn-outline-secondary" name="search_display"
                                        value="Search">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end card-->
                </div> <!-- end col -->

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Nilai Awal</h4>
                            <div class="flex-shrink-0">
                                <div class="form-check form-switch form-switch-right form-switch-md">
                                    <label for="outline-style-shocade" class="form-label text-muted">Sembunyikan</label>
                                    <input class="form-check-input code-switcher" type="checkbox"
                                        id="outline-style-shocade">
                                </div>
                            </div>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <div class="live-preview">
                                <div class="hstack gap-2 flex-wrap">
                                    <div class="row gy-4">
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <input name="min_support" type="text" class="form-control"
                                                    placeholder="Min Support">
                                            </div>
                                        </div>
                                        <div class="col-xxl-3 col-md-6">
                                            <div>
                                                <input name="min_confidence" type="text" class="form-control"
                                                    placeholder="Min Confidence">
                                            </div>
                                        </div>
                                    </div>
                                    <input name="submit" type="submit" value="Proses" class="btn btn-outline-success">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->

            </div>
        </form>
        <!-- end row -->

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


                                        echo "Jumlah data: " . $jumlah . "<br>";
                                        if ($jumlah == 0) {
                                            echo "Data kosong...";
                                        } 
                                        else {
                                            ?>
                    </div>
                    <div class="card-body">
                        <table id="add-rows" class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                            $no = 1;
                                            while ($row = $db_object->db_fetch_array($query)) {
                                                echo "<tr>";
                                                echo "<td>" . $no . "</td>";
                                                echo "<td>" . $row['transaction_date'] . "</td>";
                                                echo "<td>" . $row['produk'] . "</td>";
                                                echo "</tr>";
                                                $no++;
                                            }
                                            ?>

                        </table>
                        <?php
                                        }           
                                    }
                                    
                                    ?>
                    </div>
                </div>
            </div>
        </div>
        <!--end row-->
    </div>
    <!-- Include Required Prerequisites -->
    <!-- <script>
        window.onload = function () {
        var loadTime = window.performance.timing.domContentLoadedEventEnd-window.performance.timing.navigationStart; 
        min = Math.floor((loadTime/1000/60) << 0),
        sec = Math.floor((loadTime/1000) % 60);
        hasil = 'Waktu Proses: '+ min + ' menit ' + sec + ' detik';

        alert(hasil);
    }
    </script> -->

    <!-- <script>
  window.onload = function () {
    var loadTime = window.performance.timing.domContentLoadedEventEnd - window.performance.timing.navigationStart;
    var min = Math.floor((loadTime / 1000 / 60) << 0);
    var sec = Math.floor((loadTime / 1000) % 60);
    console.log(min + ' menit ' + sec + ' detik');

    // Kirim data waktu load ke server menggunakan AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(loadTime);
}
</script> -->

    <script src="assets/js/jquery-2.1.4.min.js"></script>
    <script src="assets/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/js/bootstrap-timepicker.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/daterangepicker.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/bootstrap-colorpicker.min.js"></script>
    <!-- ace scripts -->
    <script src="assets/js/ace-elements.min.js"></script>
    <script src="assets/js/ace.min.js"></script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        jQuery(function ($) {
            //datepicker plugin
            //link
            $('.date-picker').datepicker({
                    autoclose: true,
                    todayHighlight: true
                })
                //show datepicker when clicking on the icon
                .next().on(ace.click_event, function () {
                    $(this).prev().focus();
                });

            //or change it into a date range picker
            $('.input-daterange').datepicker({
                autoclose: true
            });


            //to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
            $('input[name=range_tanggal]').daterangepicker(

                    {
                        'applyClass': 'btn-sm btn-success',
                        'cancelClass': 'btn-sm btn-default',
                        locale: {
                            applyLabel: 'Apply',
                            cancelLabel: 'Cancel',
                            format: 'DD/MM/YYYY',
                        }
                    })
                .prev().on(ace.click_event, function () {
                    $(this).next().focus();
                });

            $('#id-input-file-1 , #id-input-file-2').ace_file_input({
                no_file: 'No File ...',
                btn_choose: 'Choose',
                btn_change: 'Change',
                droppable: false,
                onchange: null,
                thumbnail: false //| true | large
                //whitelist:'gif|png|jpg|jpeg'
                //blacklist:'exe|php'
                //onchange:''
                //
            });

            //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
            //but sometimes it brings up errors with normal resize event handlers
            $.resize.throttleWindow = false;

            /////////////////////////////////////
            $(document).one('ajaxloadstart.page', function (e) {
                $tooltip.remove();
            });
        });
    </script>