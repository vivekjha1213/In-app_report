<head>
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

    //ACTIVE MSISDN TILL NOW
    $sql="SELECT count(msisdn) as counters from  bl_xcis_mtn_za_status_changed   where DATE(date_za) <=  '$dateData' and status='ACTIVE'";
    //UNUSB MSISDN TILL NOW
    $sql2=" SELECT count(msisdn) as counter from  bl_xcis_mtn_za_status_changed   where DATE(date_za) <= '$dateData' and status='SUSPENDED'";
    $result3 = $mysqli->query($sql);
    $row3=$result3->fetch_array();
    $x=$row3['counters'];
    $result4 = $mysqli->query($sql2);
    $row4=$result4->fetch_array();
    $y=$row4['counter'];
    //ACTIVE BASE COUNT
    $z=$x-$y;

    //FOR SUBSCRIBERS REVENUE (PORTAL REDIRECTION) 
    $sql3="SELECT count(a.msisdn) as msd,sum(b.billedAmount) as bill,DATE(a.date_za) as dt from  blActiveBase a inner join bl_xcis_mtn_za_billing b on a.msisdn=b.msisdn and DATE(a.date_za)=DATE(b.date_za)  where a.status='ACTIVE' and DATE(a.date_za)='$dateData'  GROUP  BY DATE(a.date_za)";
    $result4 = $mysqli->query($sql3);
    $row4=$result4->fetch_array();
    $msd=$row4['msd'];
    $bill=$row4['bill']/100;

    //FOR SUBSCRIBE(DAILY ACTIVE)
    $sql="SELECT count(msisdn) as daily_active from  tb_transaction_mtn_bl_xcis   where DATE(date_za) = '$dateData'  and status='ACTIVE'";
    $result3 = $mysqli->query($sql);
    $row3=$result3->fetch_array();
    $daily_active=$row3['daily_active'];

    //FOR UNSUBCRIBE
    $sql="SELECT count(distinct msisdn) as chunk from  tb_transaction_mtn_bl_xcis   where DATE(date_za) = '$dateData'  and status='SUSPENDED'";
    $result3 = $mysqli->query($sql);
    $row3=$result3->fetch_array();
    $chunk=$row3['chunk'];

    // DAILY RENEWAL  
    $sql5="SELECT count(distinct msisdn) ren_count  From bl_xcis_mtn_za_billing where DATE(date_za) ='$dateData'  and status='SUCCESS'";
    // DAILY RENEWAL REVENUE
    $sql6="SELECT sum(billedAmount) as rev  From bl_xcis_mtn_za_billing where DATE(date_za) ='$dateData'  and status='SUCCESS'";
    $result5 = $mysqli->query($sql5);
    $row5=$result5->fetch_array();
    $ren_count=$row5['ren_count'];
    $result6 = $mysqli->query($sql6);
    $row6=$result6->fetch_array();
    $rev=$row6['rev'];
    $rev=$rev/100;
    $rev=$rev-$bill;

    //FOR SUBSCRIBERS (PORTAL REDIRECTION)
    $sql7="SELECT count(msisdn) as msds   From blActiveBase where DATE(date_za) ='$dateData'  and status='ACTIVE'";
    $result7 = $mysqli->query($sql7);
    $row7=$result7->fetch_array();
    $msds=$row7['msds'];
    $x=array("DATE"=>"$dateData","ACTIVE"=>"$daily_active","SUB COUNT"=>"$msds","SUB REVENUE"=>"$bill","REN COUNT"=>"$ren_count","REN REV"=>"$rev","CHUNK"=>"$chunk","ACTIVE BASE"=>$z);
    array_push($a,$x);
   


}

?>
 <div class="container">
 <h2>BEYOND-LIFESTYLE ZA</h2>
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

