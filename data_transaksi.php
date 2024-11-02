 <?php
//session_start();
if (!isset($_SESSION['apriori_parfum_id'])) {
    header("location:index.php?menu=forbidden");
}

include_once "database.php";
include_once "fungsi.php";
include_once "import/excel_reader2.php";
?>

 <div class="page-content">
     <div class="container-fluid">

         <!-- start page title -->
         <div class="row">
             <div class="col-12">
                 <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                     <h4 class="mb-sm-0">Data</h4>
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

if(isset($_POST['delete'])){
    $sql = "TRUNCATE transaksi";
    $db_object->db_query($sql);
    ?>
         <script>
             location.replace("?menu=data_transaksi&pesan_success=Data berhasil dihapus");
         </script>
         <?php
}

$sql = "SELECT
        *
        FROM
         transaksi";
$query=$db_object->db_query($sql);
$jumlah=$db_object->db_num_rows($query);
?>
         <div class="row">
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-header align-items-center d-flex">
                         <h4 class="card-title mb-0 flex-grow-1">Upload File</h4>
                         <div class="flex-shrink-0">
                             <div class="form-check form-switch form-switch-right form-switch-md">
                                 <label for="input-group-custom-showcode" class="form-label text-muted">Tutup Form
                                     Upload</label>
                                 <input class="form-check-input code-switcher" type="checkbox"
                                     id="input-group-custom-showcode">
                             </div>
                         </div>
                     </div><!-- end card header -->

                     <div class="card-body">
                         <div class="live-preview">
                             <div class="row gy-4">
                                 <div class="col-xxl-3 col-md-6">
                                     <div>
                                         <label for="basiInput" class="form-label">Import Data</label>
                                         <form method="post" enctype="multipart/form-data" action="proses-upload.php">
                                             <div class="input-group">
                                                 <button class="btn btn-outline-secondary" name="submit" type="submit"
                                                     value="">Upload</button>
                                                 <input type="file" class="form-control" id="inputGroupFile04"
                                                     name="file_data_transaksi" />
                                             </div>
                                         </form>
                                     </div>
                                 </div>
                                 <!--end col-->
                                 <div class="col-xxl-3 col-md-6">
                                     <div>
                                         <label for="labelInput" class="form-label">Hapus Semua Data</label>
                                         <div class="input-group">
                                             <form method="post" enctype="multipart/form-data" action="">
                                                 <button class="btn btn-outline-danger" name="delete" type="submit"
                                                     onclick="return confirm('Yakin ingin menghapus semua data?')">Hapus</button>
                                             </form>
                                         </div>
                                     </div>
                                 </div>
                                 <!--end col-->

                             </div>
                             <!--end row-->
                         </div>
                     </div>
                 </div>
             </div>
             <!--end col-->
         </div>
         <!--end row-->
         <div class="row">
             <div class="col-lg-12">
                 <div class="card">
                     <div class="card-header">
                         <?php
                                    if (!empty($pesan_error)) {
                                        print_r("<script>
                                        Swal.fire(
                                            'Upps!',
                                            'Data gagal diproses',
                                            'info'
                                        )
                                        </script>");
                                    }
                                    if (!empty($pesan_success)) {
                                        print_r("<script>
                                        Swal.fire(
                                            'Success!',
                                            'Data berhasil diproses',
                                            'success'
                                        )
                                        </script>");
                                    }

                                    echo "Jumlah data: ".$jumlah."<br>";
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
                                     <th>Tanggal</th>
                                     <th>Produk</th>
                                 </tr>
                             </thead>
                             <tbody>
                                 <?php
                                                $no=1;
                                                while($row=$db_object->db_fetch_array($query)){
                                                    echo "<tr>";
                                                        echo "<td>".$no."</td>";
                                                        echo "<td>".format_date2($row['transaction_date'])."</td>";
                                                        echo "<td>".$row['produk']."</td>";
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
         </div>
         <!--end row-->
     </div>
     <!-- container-fluid -->
 </div>
 <?php
function get_produk_to_in($produk){
    $ex = explode(",", $produk);
    for ($i=0; $i < count($ex); $i++) { 

        $jml_key = array_keys($ex, $ex[$i]);
        if(count($jml_key)>1){
            unset($ex[$i]);
        }
    }
    return implode(",", $ex);
}

?>

 <script type="text/javascript">
     $('.file-upload').file_upload();
 </script>