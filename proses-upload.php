<?php
include_once "database.php";
include_once "fungsi.php";
require_once "ExcelReader/excel_reader2.php";
$db_object = new database();
 
//// upload file xls
$target = basename($_FILES['file_data_transaksi']['name']) ;
move_uploaded_file($_FILES['file_data_transaksi']['tmp_name'], $target);

chmod($_FILES['file_data_transaksi']['name'],0777);

$data = new Spreadsheet_Excel_Reader($_FILES['file_data_transaksi']['name'],false);

$jumlah_baris = $data->rowcount($sheet_index=0);

$berhasil = 0;
 
for ($i=1; $i<=$jumlah_baris; $i++){

    $transaction_date       = $data->val($i, 1);
    $produk                 = $data->val($i, 2);
 
    $sql="INSERT into transaksi (transaction_date,produk) values ('$transaction_date','$produk')";
    $value_in = array();
    $db_object->db_query($sql);                         
    $berhasil++; 
}

unlink($_FILES['file_data_transaksi']['name']);
 
// alihkan halaman ke index.php
echo "<script>window.alert('sukses import $berhasil data!')</script>";
echo "<script>window.location='index.php?menu=data_transaksi'</script>";
 
?>