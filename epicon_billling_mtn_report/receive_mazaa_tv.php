<head>
  <title>epicon_billing_mtn PROMOTIONS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>
<?php
include("Connection.php");
//print_r($_POST);
if(!isset($_POST['from']))
{
  $from=$_POST['excelfrom'];
}
else
{
  $from=$_POST['from'];
}
if(!isset($_POST['to']))
{
  $modified_to=$_POST['excelto'];;
}
else
{ $to=$_POST['to'];
 $modified_to=$to." "."23:59:59";
}
?>
<!---FOR FORM CENTER @rajendra.singh.bisht----------->
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-10 col-md-8 col-lg-6">
          <!---FOR FORM CENTER----------->
          <form method="post" action="receive_detailed_mazaa_tv.php" >
            <input type="hidden" name="excelfrom" value="<?php echo $from;?>" readonly/>
            <input type="hidden" name="excelto" value="<?php echo $modified_to;?>" readonly/>
            <input type="submit" name="export" class="btn btn-success" value="Downlaod Detailed Report" />
          </form>
        </div>
    </div>
</div>
<!--FORM CENTER CLOSE---->
<?php //Testing
//$from='2020-11-01';
//$modified_to='2020-11-26 23:59:59';
?>

<br>
<?php
//$sql3="SELECT response,count(response) as counter From epicon_billing_mtn where DATE(date) between '$from' and '$modified_to' group by response";
//exit();
$result3 = $mysqli->query($sql3);
//exit();
?>
<!-- <div class="container" >
<table class="table table-striped">
    <thead>
    <tr>
  <th>STATUS</th>
  <th>COUNT</th>
    </tr>
    </thead>
    <tbody> -->
<?php
while($row3=$result3->fetch_array())
{ ?>
    <!-- <tr> -->
    <!-- <td><?php //echo $row3['response']; ?></td> -->
    <!-- <td><?php //echo $row3['counter']; ?></td> -->
    <!-- </tr> -->
      
  

    <!-- </tbody> -->
<?php

} ?>
    <!-- //CODE FOR CR -->
    <?php
   // $sql="SELECT  count(distinct msisdn) as counter  FROM `epicon_billing_mtn`  where DATE(date) between '$from' and '$modified_to'";
   // $sql2="SELECT  count(distinct msisdn) as counter  FROM epicon_billing_mtn  where `response` IN ('PASSED', 'BLOCK') AND DATE(date) between '$from' and '$modified_to'";
    $result3 = $mysqli->query($sql);
    $row3=$result3->fetch_array();
    $x=$row3['counter'];
    $result4 = $mysqli->query($sql2);
    $row4=$result4->fetch_array();
    $y=$row4['counter'];
    $z=($y*100)/$x;
    ?><tr>
    <!-- //<td style="color: black;">CR</td> -->
    <!-- <td><?php //echo intval($z);?></td> -->
    <!-- //CODE FOR CR -->
    </tr>
</table>
</div>
<br>
<?php
$sql1="SELECT * From epicon_billing_mtn where date(date_india) between '$from' and '$modified_to' order by id desc";
//exit();
//exit();
// print_r('dd');
$result = $mysqli->query($sql1);
// SELECT distinct msisdn,response From mis_listener where time_india
// -> between '2020-04-01' and '2020-04-16'and country='th' group by msisdn;
//echo $result->num_rows;
//exit();
if ($result->num_rows > 0) {
 ?>
  <div class="container">
  <h2>Datewise Numbers Successfully Done.</h2>
<table class="table table-striped">
    <thead>
    <tr>
    <th>S.NO</th>
  <th>request_ref</th>
  <th>status</th>
  <th>msisdn</th>
  <th>serviceId</th>
  <th>subscriptionId</th>
  <th>operatorName</th>
  <th>name</th>
  <th>contentName</th>
  <th>billedAmount</th>
  <th>billingRate-</th>
  <th>date_india</th>
  <th>date_za</th>
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
    <td><?php echo $row3['request_ref']; ?></td>
    <td><?php echo $row3['status']; ?>
    <td><?php echo $row3['msisdn']; ?></td>
   <td><?php echo $row3['serviceId'];?></td>
    <td><?php echo $row3['subscriptionId'];?></td>
    <td><?php echo $row3['operatorName'];?></td>
    <td><?php echo $row3['name'];?></td>
    <td><?php echo $row3['contentName'];?></td>
    <td><?php echo $row3['billedAmount'];?></td>
    <td><?php echo $row3['billingRate'];?></td>
    <td><?php echo $row3['date_india'];?></td>
    <td><?php echo $row3['date_za'];?></td>
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
<!-- Added By Rajendra -->
<!-- MY CODE STARTS FROM HERE -->
