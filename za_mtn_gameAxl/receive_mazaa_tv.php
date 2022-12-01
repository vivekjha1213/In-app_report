<head>
  <title>ATLAS_om_ooredooReport   PROMOTIONS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>
<?php
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=download.xls');
?>
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
  $modified_to=$_POST['excelto'];
}
else
{ $to=$_POST['to'];
 $modified_to=$to;
}


$d=(explode("-",$modified_to));
$a= $d[2];

$d1=(explode("-",$from));
$a1= $d1[2];
$q= $a-$a1;
$a=array();
?>
<!---FOR FORM CENTER @rajendra.singh.bisht----------->
<div class="container h-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-10 col-md-8 col-lg-6">
          <!---FOR FORM CENTER----------->
          <form method="post" action="receive_mazaa_tv.php" >
            <input type="hidden" name="excelfrom" value="<?php echo $from;?>" readonly/>
            <input type="hidden" name="excelto" value="<?php echo $modified_to;?>" readonly/>
            <input type="submit" name="export" class="btn btn-success" value="Downlaod Detailed Report" />
          </form>
        </div>
    </div>
</div>

<br>
<?php
 for ($i=0; $i <=$q ; $i++) { 
   $dateData=date("Y-m-d", strtotime("$from  +$i day")); 


    $sql="SELECT count(user_msisdn) as counters from  gameshubStatusAxl   where DATE(date_ZA)<='$dateData' and status_name IN('ACTIVE')";
    $sql2="SELECT count(user_msisdn) as counter from  gameshubStatusAxl   where DATE(date_ZA)<='$dateData' and status_name IN('SUSPENDED','EXPIRED')";
    $result3 = $mysqli->query($sql);
    $row3=$result3->fetch_array();
    $x=$row3['counters'];
    $result4 = $mysqli->query($sql2);
    $row4=$result4->fetch_array();
    $y=$row4['counter'];
    $z=$x-$y;
    $sql3="SELECT count(user_msisdn) as msd from  gameshubStatusAxl   where DATE(created_at)='$dateData' and status_name IN ('ACTIVE','GRACE')";
    $result4 = $mysqli->query($sql3);
    $row4=$result4->fetch_array();
    $msd=$row4['msd'];
    $sql8="SELECT sum(billing_rate) as bill,date_ZA from  gameshubBillingAxl   where DATE(subscription_started_at)='$dateData' and result_name='SUCCESS' and status_name='ACTIVE'";
    $result8 = $mysqli->query($sql8);
    $row8=$result8->fetch_array();
    $bill=$row8['bill']/100;
    $dt=$row8['date_ZA'];
    $sql="SELECT count(user_msisdn) as chunk from  gameshubStatusAxl   where DATE(date_ZA)='$dateData' and status_name IN('SUSPENDED','EXPIRED')";
    $result3 = $mysqli->query($sql);
    $row3=$result3->fetch_array();
    $chunk=$row3['chunk'];
    $sql5="SELECT count(user_msisdn) as ren_count from  gameshubBillingAxl   where DATE(date_ZA)='$dateData' and result_name='SUCCESS'";

    $sql6="select sum(billing_rate) as rev  from gameshubBillingAxl where result_name='SUCCESS' and DATE(date_ZA)='$dateData'";

    $result5 = $mysqli->query($sql5);
    $row5=$result5->fetch_array();
    $ren_count=$row5['ren_count'];
    $result6 = $mysqli->query($sql6);
    $row6=$result6->fetch_array();
    $rev=$row6['rev'];
    $rev=$rev/100;
    $rev=$rev-$bill;
    $sql7="SELECT count(msisdn) as msds   From gameshubAxlDailyActive where DATE(date_za) ='$dateData'  and result='ACTIVE'";
    $result7 = $mysqli->query($sql7);
    $row7=$result7->fetch_array();
    $msds=$row7['msds'];
    $x=array("DATE"=>"$dateData","ACTIVE"=>"$msd","SUB COUNT"=>"$msds","SUB REVENUE"=>"$bill","REN COUNT"=>"$ren_count","REN REV"=>"$rev","CHUNK"=>"$chunk","ACTIVE BASE"=>$z);
    array_push($a,$x);
   


}

?>
 <div class="container">
 <h2>GAMEZONE AXL ZA</h2>
 <table class="table table-striped">
    <thead>
      <tr>
        <th>DATE</th>
        <th>ACTIVE</th>
        <th>SUB COUNT</th>
        <th>SUB REVENUE</th>
        <th>REN COUNT</th>
        <th>REN REV</th>
        <th>CHUNK</th>
        <th>ACTIVE BASE</th>
      </tr>
    </thead>
    <tbody>
      <?php 
          for($i=0;$i<count($a);$i++)
          {  ?>
      <tr>
              <td><?php echo $a[$i]['DATE'];?></td>
              <td><?php echo $a[$i]['ACTIVE'];?></td>
              <td><?php echo $a[$i]['SUB COUNT'];?></td>
              <td><?php echo $a[$i]['SUB REVENUE'];?></td>
              <td><?php echo $a[$i]['REN COUNT'];?></td>
              <td><?php echo $a[$i]['REN REV'];?></td>
              <td><?php echo $a[$i]['CHUNK'];?></td>
              <td><?php echo $a[$i]['ACTIVE BASE'];?></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>

