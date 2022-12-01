<head>
  <title>Two_Intellisense_om_oredoReport  PROMOTIONS </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<div id="next_report">
<?php
include("Connection.php");

$today_date=$_GET['date'];
?>

<?php
$sql3="SELECT status,count(status) as counter From game2play_uae_etisalat_pin_verify where DATE(date) between '$today_date' and '$today_date' group by status";
// print_r($sql3);
$result3 = $mysqli->query($sql3);
?>

<div class="container" >
<table class="table table-striped">
    <thead>
    <tr>
  <th>STATUS</th>
  <th>COUNT</th>
    </tr>
    </thead>
  <tbody>
<?php
while($row3=$result3->fetch_array())
{ ?>
    <tr>
    <td><?php echo $row3['status']; ?></td>
    <td><?php echo $row3['counter']; ?></td>
    </tr>
  </tbody>
<?php
} ?>
    <?php
    $today_date=$_GET['date'];
    date_default_timezone_set("Asia/Calcutta");
    $today_date=date("Y-m-d");
    $sql="SELECT  count(distinct msisdn) as counter  FROM `game2play_uae_etisalat_pin_verify`  where DATE(date) between '$today_date' and '$today_date'";
    $sql2="SELECT  count(distinct msisdn) as counter  FROM game2play_uae_etisalat_pin_verify  where `status` IN ('PASSED', 'BLOCK') AND DATE(date) between '$today_date' and '$today_date'";
    $result3 = $mysqli->query($sql);
    $row3=$result3->fetch_array();
    $x=$row3['counter'];
    $result4 = $mysqli->query($sql2);
    $row4=$result4->fetch_array();
    $y=$row4['counter'];
    $z=($y*100)/$x;
    ?><tr>
    <td style="color: black;">CR</td>
    <td><?php echo intval($z);?></td>
    </tr>
</table>
</div>
<br>
<?php
$today_date=$_GET['date'];
$sql1="SELECT * From game2play_uae_etisalat_pin_verify where date(date) between '$today_date' and '$today_date' order by id desc";
//exit();
//exit();
$result = $mysqli->query($sql1);
if ($result->num_rows > 0) {
 ?>
  <div class="container">
  <h2>Datewise Numbers Successfully Done.</h2>
<table class="table table-striped">
    <thead>
    <tr>
    <th>S.NO</th>
  <th>MSISDN</th>
  <th>CID</th>
  <th>RESULT</th>
  <!--<th>SUBSCRIPTION-RESULT</th>-->
  <th>STATUS</th>
  <th>DATE</th>
    </tr>
    </thead>
    <tbody>

    <?php
    $sno=0;
    while($row3=$result->fetch_array())
    { $sno++;
      ?>
    <tr>
    <td><?php echo $sno; ?></td>
    <td><?php echo $row3['msisdn']; ?></td>
    <td><?php echo $row3['cid']; ?></td>
    <td><?php echo $row3['subscriptionResult']; ?></td>
    <!--<td><?php //echo $row3['subscriptionResult'];?></td>-->
    <td><?php echo $row3['status'];?></td>
    <td><?php echo $row3['date'];?></td>
    </tr>
    <?php }?>
   </tbody>

   </table>
   </div>


<?php }
else
{
    echo "0 results";
}


?>
</div>