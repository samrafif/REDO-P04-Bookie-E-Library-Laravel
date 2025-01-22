<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>LAPOR! | Admin Dashboard</title>  
    <link rel="shortcut icon" href="assets/images/BookieLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
      @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
      }

      button {
        padding: 12px;
        width: 50%;
        border: none;
        cursor: pointer;
        background-color: black;
        color: white;
        /* box-shadow: 5px 5px black; */
        transition: all 200ms;
      }

      button:active {
        background-color: white;
        color: black;
        /* box-shadow: 0px 0px;
        translate: 5px 5px; */
      }
    </style></head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
        <h2>Admin Dashboard</h2>
    </div>

    <div class="card-body">
        <h3>Welcome {{ Auth::user()->name }}</h3>
        <h5>Email: {{ Auth::user()->email }}</h5>
        <h5>Role: {{ Auth::user()->role }}</h5>
        <a href="{{ route('logout') }}" class="btn btn-danger mr-2" role="button">Logout</a>
        <a href="{{ route('home') }}" class="btn btn-info mr-2" role="button">Go to Home</a>
        <a href="{{ route('admin.users') }}" class="btn btn-info mr-2" role="button">User Management</a>

        </div>
        </div>

</div>

</body>
</html>