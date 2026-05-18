<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/css/all.min.css"/>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css">
    
    <style>
      body{
        background-color:none;
        background-image:url("");
     
      }
        .btn-color{
  background-color: #0e1c36;
  color: #fff;
  
}


.profile-image-pic{
  height: 120x;
  width: 120px;
  object-fit: cover;
  position: absolute;
   left: 140px;
   top: -50px;
}
.cardbody-color{
  background-color: #0e94b3;
  border-radius:5px;
  margin-top:100px;

}

a{
  text-decoration: none;
}
.card{
  margin:auto;
  width:400px;
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
  transition:none;
  transform:none;
  position: relative;
  background:rgb(50, 50, 70);

;
  height:400px;
  margin-top:100px !important;
}
.btn-color{

  border-radius:5px;
  border:#EB8921;
  height:30px;
  background-color:#0e94b3;
}
.btn- :hover{
  background-color:none;
  color:white;
  
}
.image-fluid{
 margin-top:0;
}
form i {
    margin-left: -30px;
    cursor: pointer;
}
.button.btn :hover{
background-color:#EB8921;
}
.mb-3 input[type=text],
.mb-3 input[type=password]
{
  height:50px !important;
 
}
.button{
  width:95%;
  margin:auto;
}
.form-control{
 width:300px !important;
}
.form-control{
  box-shadow:none !important;
}

    </style>
</head>
<body>
        <div class="card my-5 ">

          <form class="card-bodycolor  p-lg-5" name="form" action="authenticate.php" method="POST">

            <div class="text-center">
              <img src="/mylogo.png" height="50px" class="img-fluid profile-image-pic img-thumbnail rounded-circle"
                width="150px" alt="profile">
            </div>

            <div class="mb-3 mt-5 form-floating">
          

                <select class="form-select form-control"  id="floatingInput" name="username" id="Username" aria-label="Default select example" name="username" id="Username">
  <option selected disabled>--Username--</option>
  <option value="Administrator">Administrator</option>
  <option value="Member">Member</option>
  <option value="Financial">Financial Officer</option>
</select>
         
            </div>
            <div class="mb-3 mt-2 form-floating">
              <input type="password" class="form-control" id="floatingInput" name="password" id="Username" aria-describedby="emailHelp"
                placeholder="User Name" required>
                <label for="floatingInput">Password</label>
            </div>
            <div class="text-center button">
        <button type="submit" name="submit" class="btn-color px-4 mb-5 w-100" style="marin-bottom:20px">
        Login</button>
      </div>
      <hr style="color:white">

      </form>
     
        </div>
  
    
 

</body>
</html>