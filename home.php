

<style>

  *{

    font-family: Arial, Helvetica, sans-serif;
  }
  .welcome {
    box-sizing: border-box;
    border: 1px solid transparent;
    box-shadow: 10px 20px 3px 5px grey;
    width: 840px;
    padding: 10px 10px;
    margin-left: 270px;
    border-radius: 10px;
    background-color: solid white;
    margin-top: 40px;

  }
  .welcome h2, p {
    padding: 10px;
    
  }
  
  .dashboard-links {
    margin-top: 20px;
  }
  
  .dashboard-links a {
    display: block;
    margin-bottom: 10px;
  }

  *{

        
font-family: Arial, sans-serif;
}
.My-Classes {

 margin-top: 50px;
 margin-left: 270px;

}











</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Ty/5zgA9fP5LL1x+X5xq++T9qz5l+LZ3e8y6biD7bKUHnvm+Of6D7oBMmYp40l" crossorigin="anonymous">

<div class = "home-content">

<?php 
/*include 'teach-calendar.php';*/?>
<div class="welcome">
  <h2>Welcome to the Teacher Dashboard</h2>
  <p>In this teacher dashboard, you can easily manage and access all your classes. Each class is listed with its corresponding subject</p>
  
</div>

    
<div class = "My-Classes">

  <div class = "title-clas">
    <h2 style = "font-size: 34px; font-weight: 500;">Recent View Class</h2>

   
  </div>
    <div class = "class-listed" style = "margin-left: -250px; width: 850px; ">

        <?php include 'recent_view.php';?>

    </div>

 
</div>
</div>
<style>

    /* CSS code */
.class {
  display: none;
  opacity: 0;
  transition: opacity 0.5s;
}

.displayed {
  display: block;
  opacity: 1;
}
 </style>
