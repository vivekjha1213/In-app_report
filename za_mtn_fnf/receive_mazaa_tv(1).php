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

    //FOR SUBSCRIBE(DAILY ACTIVE)
    $sql="SELECT count(distinct msisdn) as daily_active from  funnflixActiveBase   where DATE(date_za) = '$dateData'  and status IN ('ACTIVE','GRACE')";
    $result3 = $mysqli->query($sql);
    $row3=$result3->fetch_array();
    $daily_active=$row3['daily_active'];

    //SUB COUNT
    $sql7="SELECT count(msisdn) as msds   From funnflixActiveBase where DATE(date_za) ='$dateData'  and status='ACTIVE'";
    $result7 = $mysqli->query($sql7);
    $row7=$result7->fetch_array();
    $sub_count=$row7['msds'];

    //SUB REVENUE
    $sql3="SELECT count(distinct a.msisdn) as msd,sum(b.billedAmount) as bill,DATE(a.date_za) as dt from  funnflixActiveBase a inner join funnflix_billing_mtn b on a.msisdn=b.msisdn and DATE(a.date_za)=DATE(b.date_za)  where a.status='ACTIVE' and DATE(a.date_za)='$dateData'  GROUP  BY DATE(a.date_za)";
    $result4 = $mysqli->query($sql3);
    $row4=$result4->fetch_array();
    $sub_rev=$row4['bill']/100;

    // REN COUNT
    $sql5="SELECT count(distinct msisdn) ren_count  From funnflix_billing_mtn where DATE(date_za) ='$dateData'  and status='SUCCESS'";
    $result5 = $mysqli->query($sql5);
    $row5=$result5->fetch_array();
    $ren_count=$row5['ren_count'];
   
    // REN REV
    $sql6="SELECT sum(billedAmount) as rev  From funnflix_billing_mtn where DATE(date_za) ='$dateData'  and status='SUCCESS'";
    $result6 = $mysqli->query($sql6);
    $row6=$result6->fetch_array();
    $rev=$row6['rev'];
    $rev=$rev/100;
    $rev=$rev-$sub_rev;
    // CHUNK
    $sql="SELECT count(distinct msisdn) as chunk from  tb_transaction_mtn_funnflix   where DATE(date_za) = '$dateData'  and status='SUSPENDED'";
    $result3 = $mysqli->query($sql);
    $row3=$result3->fetch_array();
    $chunk=$row3['chunk'];


    $sql="SELECT count(msisdn) as counters from  funnflix_mtn_status_changed   where DATE(date_za) <=  '$dateData' and status='ACTIVE'";
    $sql2=" SELECT count(msisdn) as counter from  funnflix_mtn_status_changed   where DATE(date_za) <= '$dateData' and status='SUSPENDED'";
    $result3 = $mysqli->query($sql);
    $row3=$result3->fetch_array();
    $x=$row3['counters'];
    $result4 = $mysqli->query($sql2);
    $row4=$result4->fetch_array();
    $y=$row4['counter'];
    $z=$x-$y;


    $x=array("DATE"=>"$dateData","ACTIVE"=>"$daily_active","SUB COUNT"=>"$sub_count","SUB REVENUE"=>"$sub_rev","REN COUNT"=>"$ren_count","REN REV"=>"$rev","CHUNK"=>"$chunk","ACTIVE BASE"=>$z);
    array_push($a,$x);
   


}

?>
 <div class="container">
 <h2>FUNFLIX ZA</h2>
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

