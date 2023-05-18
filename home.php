<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/style2.css">
    <title>Home</title>
</head>
<body>
    <div class="nav">
        <div class="logo">
            <p><a href="home.php">BMI For Health</a> </p>
        </div>

        <div class="right-links">

            <?php 
            $id = $_SESSION['id'];
            $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id");

            while($result = mysqli_fetch_assoc($query)){
                $res_Uname = $result['Username'];
                $res_Email = $result['Email'];
                $res_Age = $result['Age'];
                $res_id =  $result['Id'];
                $res_BMI = $result['BMI'];
            }
            
          
            ?>

            <a href="php/logout.php"> <button class="btn">Log Out</button> </a>

        </div>
    </div>
    <main>

       <div class="main-box top">
          <div class="top">
            <div class="box">
                <p>Hello <b><?php echo $res_Uname ?></b>, Welcome</p>
            </div>
            <div class="box">
                <p>Your Last BMI Score is : <b><?php echo $res_BMI ?></b>.</p>
            </div>
          </div>
          <div class="bottom">
             
          </div>
       </div>
       </main>
       <!--  CALCULATER HERE    -->
       <div class="bmi"> 
       <BR>
       
       <div class="containerB">
        <div class="boxB">
          <h1>BMI Calculator</h1>
          <div class="content">


            <div class="input">
                <label for="height">Age</label>
                <input type="text" class="text-input" id="age" autocomplete="off" required/>
            </div>

            <div class="gender">

                <label class="containerB">
                    <input type="radio" name="radio" id="m"><p class="text">Male</p>
                    <span class="checkmark"></span>
                  </label>
                <label class="containerB">
                    <input type="radio" name="radio" id="f" ><p class="text">Female</p>
                      <span class="checkmark"></span>
                    </label>

            </div>

            <div class="containerBHW">
            <div class="inputH">
              <label for="height">Height(cm)</label>
              <input type="number" id="height" required>
            </div>

            <div class="inputW">
              <label for="weight">Weight(kg)</label>
              <input type="number" id="weight" required>
            </div>
          </div>

            <button class="calculate" id="submit" onclick="calculate();">Calculate BMI</button>
          </div>
          <div class="result">
            <p>Your BMI is</p>
            <div  id="result">00.00</div>
            <!-- saveing -->
            <DIV>
      <?php 
               if(isset($_POST['submit'])){
                $bmi = $_POST['bmio'];

                $id = $_SESSION['id'];

                $edit_query = mysqli_query($con,"UPDATE users SET BMI='$bmi' WHERE Id=$id ") or die("error occurred");

                if($edit_query){
                    echo "<div class='message'>
                    <p>Data saved!</p>
                </div> <br>";
              echo "<a href='home.php'><button class='btn'>Go Home</button>";
       
                }
               }else{

                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id ");

                while($result = mysqli_fetch_assoc($query)){
                    
                    $res_BMI = $result['BMI'];
                }

            ?>
            <form action="" method="post">
                <input step="any" name="bmio" id="bmio" type="number" hidden>
                    <input type="submit" class="btn" name="submit" value="SAVE" required>
                </div>
                
            </form>
        </div>
        <?php } ?>
        <p class="comment"></p>
        </div>
            
            
          </div>        
        </div>
        
      </div>
      
    <!-- The Modal -->
    <div id="myModal" class="modal">
      <!-- Modal content -->
    <div class="modal-content">
      <span class="close">&times;</span>
      <p id="modalText"></p>


    </div>


</div>

    
           
     

</div>
<!--  CALC END    -->


</body>
</html>
<SCRIPT>
var age = document.getElementById("age");
var height = document.getElementById("height");
var weight = document.getElementById("weight");
var male = document.getElementById("m");
var female = document.getElementById("f");
var form = document.getElementById("form");
let resultArea = document.querySelector(".comment");

modalContent = document.querySelector(".modal-content");
modalText = document.querySelector("#modalText");
var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];


function calculate(){
 
  if(age.value=='' || height.value=='' || weight.value=='' || (male.checked==false && female.checked==false)){
    modal.style.display = "block";
    modalText.innerHTML = `All fields are required!`;

  }else{
    countBmi();
  }

}


function countBmi(){
  var p = [age.value, height.value, weight.value];
  if(male.checked){
    p.push("male");
  }else if(female.checked){
    p.push("female");
  }

  var bmi = Number(p[2])/(Number(p[1])/100*Number(p[1])/100);
      
  var result = '';
  if(bmi<18.5){
    result = 'Underweight';
     }else if(18.5<=bmi&&bmi<=24.9){
    result = 'Healthy';
     }else if(25<=bmi&&bmi<=29.9){
    result = 'Overweight';
     }else if(30<=bmi&&bmi<=34.9){
    result = 'Obese';
     }else if(35<=bmi){
    result = 'Extremely obese';
     }

resultArea.style.display = "block";
document.querySelector(".comment").innerHTML = `You are <span id="comment">${result}</span>`;
document.querySelector("#result").innerHTML = bmi.toFixed(2);
document.getElementById("bmio").value= bmi.toFixed(2);
}





// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

</SCRIPT>