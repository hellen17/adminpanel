<html>
 <head>
  <title>Admin Panel</title>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">

  <style>
  body
  {
   margin:0;
   padding:0;
   background-color:#f1f1f1;
  }
  .box
  {
   width:1270px;
   padding:20px;
   background-color:#fff;
   border:1px solid #ccc;
   border-radius:5px;
   margin-top:25px;
   box-sizing:border-box;
  }
    #header{
      width:100%;
      height: 120px;
      background:black;
      color: white;
    }
    #adminLogo{
        background: white;
        border-radius: 50px;
        height: 90px;

      }
  </style>
 </head>
 <body>


    <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">ADMIN PANEL</a>

    </div>
     <!--  <center><img src="adminavatar.png" alt="adminLogo" id="adminLogo" height="8"></center> -->
    <ul class="nav navbar-nav navbar-right">
   <li ><a href="adminhome.php">Home</a></li>
      <li><a class="active" href="viewgoods.php">View Goods</a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav> 




 <!--  <div id="header">

  <center><img src="adminavatar.png" alt="adminLogo" id="adminLogo"><br>Authorised Access Only!!</center>
 
 </div> -->
<div class="welcome" style="text-align: left;
  color: black;
  padding-top: 50px;
  font-weight: bolder;
  font-size: 20px;">

  <?php

  //start the session
    error_reporting(0);
   session_start();
   include("connect.php");

   if(isset($_SESSION['user']))
  {
    echo "Welcome ".$_SESSION['user'];
    echo " | <a href='logout.php' class='btn btn-danger' role='button'>Logout</a>";
  }
  ?>

</div>
 
  <div class="container box">
   <h1 align="center">View Items Posted</h1>
   <br />
   <div class="table-responsive">
   <br />
    <!-- <div align="right">
     <button type="button" name="add" id="add" class="btn btn-info">Add</button>
    </div> -->
    <br />
    <div id="alert_message"></div>
    <table id="user_data" class="table table-bordered table-striped">
     <thead>
      <tr>
      <th>Item ID</th>
       <th>User ID</th>
       <th>Name</th>
       <th>Description</th>
       <th>Price Estimate</th>
       <th>Category</th>
       <!-- <th>Gender</th> -->
       <th></th>

      </tr>
     </thead>
    </table>
   </div>
  </div>
 </body>
</html>

<script type="text/javascript" language="javascript" >
 $(document).ready(function(){
  
  fetch_data();

  function fetch_data()
  {
   var dataTable = $('#user_data').DataTable({
    "processing" : true,
    "serverSide" : true,//swutch client side to server side processing
    "order" : [],//enable column ordering
    "ajax" : {
     url:"fetch1.php",//sends request to fetch.php
     type:"POST"
    }
   });
  }
  
  function update_data(id, column_name, value)
  {
   $.ajax({
    url:"updategoods.php",
    method:"POST",
    data:{id:id, column_name:column_name, value:value},
    success:function(data)
    {
     $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
     $('#user_data').DataTable().destroy();
     fetch_data();
    }
   });
   setInterval(function(){
    $('#alert_message').html('');
   }, 5000);
  }

  $(document).on('blur', '.update', function(){
   var id = $(this).data("id");
   var column_name = $(this).data("column");
   var value = $(this).text();
   update_data(id, column_name, value);
  });
  
  $('#add').click(function(){
   var html = '<tr>';
  html += '<td contenteditable id="data1"></td>';
  html += '<td contenteditable id="data2"></td>';
  html += '<td contenteditable id="data3"></td>';
  html += '<td contenteditable id="data4"></td>';
  html += '<td contenteditable id="data5"></td>';
  // html += '<td contenteditable id="data6"></td>';
   html += '<td><button type="button" name="insert" id="insert" class="btn btn-success btn-xs">Insert</button></td>';
   html += '</tr>';
   $('#user_data tbody').prepend(html);
  });
  
  $(document).on('click', '#insert', function(){
   /*var id = $('#data1').text();*/
   var user_id = $('#data1').text();
    var name = $('#data2').text();
     var description = $('#data3').text();
      var price_estimate = $('#data4').text();
       var category = $('#data5').text();
        /*var created_at = $('#data6').text();*/
     // var gender = $('#data5').text();
   if( user_id != ''&& name != '' && description != '' && price_estimate != '' && category != ''  )
   {
    $.ajax({
     url:"insertgoods.php",
     method:"POST",
     data:{user_id:user_id,name:name,description:description, price_estimate:price_estimate, category:category },
     // dataType: 'text',
     success:function(data)
     {
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
      fetch_data();
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
   else
   {
    alert("Both Fields is required");
   }
  });
  
  $(document).on('click', '.delete', function(){
   var id = $(this).attr("id");
   if(confirm("Are you sure you want to remove this?"))
   {
    $.ajax({
     url:"deletegoods.php",
     method:"POST",
     data:{id:id},
     success:function(data){
      $('#alert_message').html('<div class="alert alert-success">'+data+'</div>');
      $('#user_data').DataTable().destroy();
      fetch_data();
     }
    });
    setInterval(function(){
     $('#alert_message').html('');
    }, 5000);
   }
  });
 });
</script>
