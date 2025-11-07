<!doctype html>
<html lang="en">
  <head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <title>Forgot-Password</title>
    <style>

      *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: 'sans serif', arial; 
      }
      body{
        background: url(./images/360_F_96243602_hgZuimFj1cJFqrrvERCnsq7NZ8VRZ7y7.jpg);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
        display: flex;   
        max-width: 100%;
      }

      .container{
       max-height: 40vh; 
       width: 370px;
       display: flex;
       justify-content: center;
       align-items: center;
       border: 1px solid #ccc;
       margin: 0 auto;
       background-color: rgb(255, 255, 255);
       margin-top: 10rem;
       border-radius: 10px;
       padding: 30px;
      }

      .form{
              display: flex;
              flex-direction: column;
              justify-content: center;
              align-items: center;
              margin-top: 20px;
            }

       h2{
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: -40px;
        margin-bottom: 30px;
      }

      label{
        font-size: 15px;
        margin-bottom: 10px;
        align-self: flex-start;
      }

      input{
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 30px;
        margin-top: 5px;
      }

      button{
        display: flex;
        padding: 10px 50px;
        border-radius: 5px;
        border: none;
        background-color: rgb(123, 216, 123);
        color: white;
        font-size: 16px;
        cursor: pointer;
        margin: 0 auto;
      }
      </style>
  </head>

  <body>
    <div class="container">
      <div class="form">
        <form action="forgot.inc.php" method="POST">
           <h2>Forgot Password</h2>
               <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email"  required>    
               <button type="submit" class="btn btn-primary" name="ehelp">Next</button>
            </div>
         </form>
      </div>
    </div>
   </body>
</html>
