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
// if(!isset($_POST['to']))
// {
//   $modified_to=$_POST['excelto'];
// }
// else
// { $to=$_POST['to'];
//  $modified_to=$to;
// }


// $d=(explode("-",$modified_to));
// $a= $d[2];

// $d1=(explode("-",$from));
// $a1= $d1[2];
// $q= $a-$a1;
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
    $sql="SELECT `serviceId` from `in_app_pin_verify` order by id desc limit 1";
    $result=mysql_query($sql);
    $row = mysql_fetch_array($result);
    $serviceId=$row['serviceId'];

 // for ($i="ARSH0001"; $i <="ARSH0001" ; $i++) { 
 //   $dateData=date("Y-m-d", strtotime("$from  +$i day")); 


   //CR%
    $sql="SELECT  count(distinct msisdn) as counter,serviceName,serviceId  FROM `in_app_pin_verify`  where  DATE(date) = '$from' group  by serviceId";
    $result3 = $mysqli->query($sql);
    $row3=$result3->fetch_array();
    $x=$row3['counter'];

    $sql2="SELECT  count(distinct msisdn) as counter,serviceName,serviceId  FROM in_app_pin_verify  where `status` IN ('PASSED', 'BLOCK') AND  DATE(date) = '$from' group  by serviceId";
    $result4 = $mysqli->query($sql2);
    $row4=$result4->fetch_array();
    $y=$row4['counter'];
    $cr=($y*100)/$x;
    //PIN_VERIFY-TOTAL-FAIL 
    $pin_verify_total_fail=$x-$y;

    // // 
    // $sql4= "SELECT distinct  as offer  From in_app_pin_verify where serviceId='ARSH0001'";
    // $result5 = $mysqli->query($sql4);
    // $row5=$result5->fetch_array();
   

    // ADV AND PUB NAME and serviceName/OFFER-NAME and serviceId
    $sql5="SELECT advName,pubName,serviceName,serviceId  From in_app_pin_verify where DATE(date) = '$from' group  by serviceId";
    $result6 = $mysqli->query($sql5);
    $row6=$result6->fetch_array();
    $adv=$row6['adv'];
    $pubName=$row6['pubName'];
    $serviceId=$row6['serviceId'];
    $serviceName=$row5['serviceName'];
    // PIN_REQUEST-TOTAL-COUNT  
    $sql7="SELECT  count(distinct msisdn) as total_pin_request,serviceName,serviceId  FROM `in_app_pin_request`  where  DATE(date) = '$from' group  by serviceId";
     $result7 = $mysqli->query($sql7);
    $row7=$result7->fetch_array();
    $total_pin_request=$row7['total_pin_request'];

    //PIN_VERIFY-TOTAL-SUCCESS  
    $sql8="SELECT  count(distinct msisdn) as total_pin_verify,serviceName,serviceId  FROM `in_app_pin_verify`  where DATE(date) = '$from' group  by serviceId";
     $result8 = $mysqli->query($sql8);
    $row8=$result8->fetch_array();
    $total_pin_verify=$row8['total_pin_verify'];
   
    //PAASED
    $sql8=" SELECT  count(status) as paased,serviceName,serviceId  FROM `in_app_pin_verify`  where  status='PASSED' and DATE(date) = '$from' group  by serviceId";
    $result8 = $mysqli->query($sql8);
    $row8=$result8->fetch_array();
    $pass=$row8['paased'];

    //BLLOCK
    $sql8="SELECT  count(status) as block  FROM `in_app_pin_verify`  where  status='BLOCK' and DATE(date) = '$from' group  by serviceId";
    $result8 = $mysqli->query($sql8);
    $row8=$result8->fetch_array();
    $block=$row8['block'];

    $x=array("DATE"=>"$dateData","SERVICE NAME"=>"$serviceName","SERVICE ID"=>"$serviceId","ADVITIZER"=>"$adv","PUB NAME"=>"$pubName","CR"=>"$cr","PIN REQUEST TOTAL COUNT"=>"$total_pin_request","PIN VERIFY TOTAL COUNT"=>"$total_pin_verify","PASS"=>"$pass","BLOCK"=>"$block","PIN VERIFY TOTAL FAIL"=>"$pin_verify_total_fail");
    array_push($a,$x);
   
echo "$x";

// }
die();
?>
 <div class="container">
 <h2>GAMEZONE AXL ZA</h2>
 <table class="table table-striped">
    <thead>
      <tr>
        <th>DATE</th>
        <th>SERVICE NAME</th>
        <th>SERVICE ID</th>
        <th>ADVITIZER</th>
        <th>PUB NAME</th>
        <th>CR %</th>
        <th>PIN REQUEST TOTAL COUNT</th>
        <th>PIN VERIFY TOTAL COUNT</th>
        <th>PASS</th>
        <th>BLOCK</th>
        <th>PIN VERIFY TOTAL FAIL</th>
      </tr>
    </thead>
    <tbody>
   <!--    <?php 
          //for($i=0;$i<count($a);$i++)
          { 
           ?> -->
      <tr>
              <td><?php echo $a[$i]['DATE'];?></td>
              <td><?php echo $a[$i]['SERVICE NAME'];?></td>
              <td><?php echo $a[$i]['SERVICE ID'];?></td>
              <td><?php echo $a[$i]['ADVITIZER'];?></td>
              <td><?php echo $a[$i]['PUB NAME'];?></td>
              <td><?php echo $a[$i]['CR'];?></td>
              <td><?php echo $a[$i]['PIN REQUEST TOTAL COUNT'];?></td>
              <td><?php echo $a[$i]['PIN VERIFY TOTAL COUNT'];?></td>
              <td><?php echo $a[$i]['PASS'];?></td>
              <td><?php echo $a[$i]['BLOCK'];?></td>
              <td><?php echo $a[$i]['PIN VERIFY TOTAL FAIL'];?></td>
      </tr>
    <?php 

  // }//

   ?>
    </tbody>
  </table>
</div>

