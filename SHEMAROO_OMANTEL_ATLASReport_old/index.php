<!DOCTYPE html>
<html lang="en">
<head>
  <?php include("Connection.php"); ?>
  <title>SHEMAROO_OMANTEL_ATLASReport_Old</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  <script>
$(document).ready(function(){
    $("#submitBtn").click(function(){
        $("#myForm").submit();
         var from = $("#from").val();
         var to= $("#to").val();
         $.ajax({
            type        : 'POST',
            url         : 'receive_mazaa_tv.php',
            data        : {from:from,to:to},
            dataType    : 'text',

             beforesend:function()
                                  {
                                      $('.loader').show();
                                  },
             success: function(data){
                                     $('#table_xy').html(data);
                                     $('.loader').hide()
                                },
              error: function(){
                                    alert('failure');
                                }
                }) ;
    });
});
</script>
</head>
<body>
<div class="container">
  <h2>REPORT(SHEMAROO_OMANTEL_ATLASReport_Old conversion tracker)</h2>
  <p>Details of SHEMAROO_OMANTEL_ATLASReport_Old.</p>
   <div class="text-right">

        <a href="http://beyondhealth.info/INAPP" class="btn btn-info btn-lg">
          <span class="glyphicon glyphicon-home"></span> Home
        </a>
      </div>

  <form class="form-inline" action="index.php">
    <label for="from">From: </label>
    <input type="date" class="form-control" id="from" placeholder="Enter from" name="from">
    <label for="to">To: </label>
    <input type="date" class="form-control" id="to" placeholder="Enter to" name="to">
    <br><br>
    <button type="button" class="btn btn-primary" id="submitBtn">Submit</button>
  </form>
</div>

<br>
<br>
<!-- <div class="getter">
</div> -->
<div id="table_xy">
 </div>
</body>
</html>
