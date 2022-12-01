<head>
  <title>ATLAS_om_ooredooReport Report PROMOTIONS </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<?php
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
?>
<?php
include("Connection.php");
$from=$_POST['excelfrom'];
$to=$_POST['excelto'];
 $modified_to=$from." "."23:59:59";
?>
<table class="table table-striped">
    <thead>
    <tr>
  <th>STATUS</th>
  <th>COUNT</th>
    </tr>
    </thead>
    <tbody>
<?php
    $sql="SELECT count(msisdn) as counters from  bl_xcis_mtn_za_status_changed   where DATE(date_za) <=  '$modified_to' and status='ACTIVE'";
    $sql2=" SELECT count(msisdn) as counter from  bl_xcis_mtn_za_status_changed   where DATE(date_za) <= '$modified_to' and status='SUSPENDED'";
    $result3 = $mysqli->query($sql);
    $row3=$result3->fetch_array();
    $x=$row3['counters'];
    $result4 = $mysqli->query($sql2);
    $row4=$result4->fetch_array();
    $y=$row4['counter'];
    $z=$x-$y;
   $sql3="select count(distinct a.msisdn) as msd,sum(b.billedAmount) as bill,DATE(a.date_za) as dt from  tb_transaction_mtn_bl_xcis a inner join bl_xcis_mtn_za_billing b on a.msisdn=b.msisdn and DATE(a.date_za)=DATE(b.date_za)  where a.status='ACTIVE' and DATE(a.date_za)='$from'  GROUP  BY DATE(a.date_za)";
// echo $sql3;
    $result4 = $mysqli->query($sql3);
    $row4=$result4->fetch_array();
    $msd=$row4['msd'];
    $bill=$row4['bill'];
    $dt=$row4['dt'];
  $sql="  SELECT count(distinct msisdn) as chunk from  tb_transaction_mtn_bl_xcis   where DATE(date_za) = '$from'  and status='SUSPENDED'";
  $result3 = $mysqli->query($sql);
    $row3=$result3->fetch_array();
    $chunk=$row3['chunk'];


   $sql5="SELECT count(distinct msisdn) ren_count  From bl_xcis_mtn_za_billing where DATE(date_za) ='$from'  and status='SUCCESS'";
    $sql6="SELECT sum(billedAmount) as rev  From bl_xcis_mtn_za_billing where DATE(date_za) ='$from'  and status='SUCCESS'";
    $result5 = $mysqli->query($sql5);
    $row5=$result5->fetch_array();
    $ren_count=$row5['ren_count'];
    $result6 = $mysqli->query($sql6);
    $row6=$result6->fetch_array();
    $rev=$row6['rev'];

    ?>
   <td style="color: black;">DATE</td>
    <td><?php echo $dt;?></td>
    </tr> 
    <td style="color: black;">ACTIVE</td>
    <td><?php echo $msd;?></td>
    </tr> 
        <td style="color: black;">SUB COUNT</td>
    <td><?php echo $msd;?></td>
    </tr> 
      <tr>
    <td style="color: black;">SUB REVENEUE</td>
    <td><?php echo $bill;?></td>
    </tr>

  <tr>
    <td style="color: black;">REN COUNT</td>
    <td><?php echo $ren_count;?></td>
    </tr>

     <tr>
    <td style="color: black;">REN REV</td>
    <td><?php echo $rev;?></td>
    </tr>

  
     <tr>
    <td style="color: black;">CHUNK</td>
    <td><?php echo $chunk;?></td>
    </tr>
  <tr>
    <td style="color: black;">ACTIVE BASE</td>
    <td><?php echo $z;?></td>
    </tr>


</table>
</div>
<br>
<br>


?>
