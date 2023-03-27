<?php 
  $insert = false;
  $update = false;
  $delete = false;
  // Connect to the database 
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database = "mytodo";

  // Create a connection 
  $conn = mysqli_connect($servername, $username, $password, $database);

  // Die if connection was not successful
  if(!$conn){
    error_log("Sorry we failed to connect ". mysqli_connect_error());
  }
  
  if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true;

    $sql = "DELETE FROM `todos` WHERE `todos`.`sno` = '$sno'";
    $result = mysqli_query($conn, $sql);
  }

  if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset( $_POST['snoEdit'])){
      // Update the record 
      $sno = $_POST["snoEdit"];
      $title = $_POST["titleEdit"];
      $description = $_POST["descriptionEdit"];

      // sql query to be executed
      $sql = "UPDATE `todos` SET `title` = '$title' , `description` = '$description' WHERE `todos`.`sno` = '$sno' ";
      $result = mysqli_query($conn, $sql);

      if($result){
        $update = true;
      }
      else {
        echo "we could not update the record successfully";
      }
    }
    else {
      $title = $_POST["title"];
      $description = $_POST["description"];

      // sql query to be executed
      $sql = "INSERT INTO `todos` ( `title`, `description`) VALUES ('$title','$description')";
      $result = mysqli_query($conn, $sql);

      // Add a new todo to table in the database
      if($result){
        // echo "The Record has been inserted Successfully<br>";
        $insert = true;
      }
      else {
        echo "the record was not inserted successfully" . mysqli_error($conn);
      }
    }
  }
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">

  <title>ToDos - add your todo</title>

</head>

<body>
  <!-- Edit Modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
  Edit Modal
</button> -->

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="editModalLabel">Edit Task</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="/php_projects/MyTodo/index.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="snoEdit" id="snoEdit">
            <div class="mb-3">
              <label for="title" class="form-label">Task Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit">
            </div>
            <div class="form-group">
              <label for="desc" class="form-label">Task Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"
                style="height: 100px"></textarea>
            </div>
          </div>
          <div class="modal-footer d-block mr-auto">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>  
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="/todo.PNG"  style="height: 40px;" alt="todos logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <?php
    if($insert){
      echo '<div class="alert alert-success alert-dismissible fade show " role="alert">
      <strong>Success!</strong> Your task is added.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
  ?>

  <?php
    if($update){
      echo '<div class="alert alert-success alert-dismissible fade show " role="alert">
      <strong>Success!</strong> Your task is updated.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
  ?>

  <?php
    if($delete){
      echo '<div class="alert alert-success alert-dismissible fade show " role="alert">
      <strong>Success!</strong> Your task is deleted.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
  ?>


  <!-- Form -->
  <div class="container my-4 mx-auto" style="width: 1000px;">
    <h2 class="pb-1">Add a Todo</h2>
    <form action="/index.php" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Task Title</label>
        <input type="text" class="form-control" id="title" name="title">
      </div>
      <div class="form-group">
        <label for="desc" class="form-label">Task Description</label>
        <textarea class="form-control" id="description" name="description" style="height: 100px"></textarea>
      </div>
      <button type="submit" class="btn btn-primary mt-3">Add Task</button>
    </form>
  </div>

  <!-- Form Data -->
  <div class="container mx-auto" style="width: 1000px;">
    <table class="table my-4" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Task</th>
          <th scope="col">Description</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $sql = "SELECT * FROM `todos` ";
        $result = mysqli_query($conn, $sql);
        
        $sno = 0;
        while($row = mysqli_fetch_assoc($result)){
          $sno = $sno + 1;
          echo "<tr>
          <th scope='row'>" .$sno. "</th>
          <td>" .$row['title']. "</td>
          <td>" .$row['description']. "</td>
          <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-danger' id=d".$row['sno'].">Delete</button></td>
          </tr>";
        }
      ?>
      </tbody>

    </table>
  </div>

  <hr>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous">
  </script>
  <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E="
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script>
    //let table = new DataTable('#myTable');
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
  <script>
    // Get all elements with class "edit"
    const edits = document.getElementsByClassName('edit');

    // Convert the collection to an array and add an event listener to each element
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ", );
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id)
        $('#editModal').modal('toggle');
      });
    });


    // Delete button 

    const deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ", );
        sno = e.target.id.substr(1, );

        if (confirm("Are you sure yiu want to delete this task? ")) {
          console.log("YES");
          window.location = `/index.php?delete=${sno}`;
          //TODO : create a form and use post request to submit a form

        } else {
          console.log("NO")
        }

      });
    });
  </script>
</body>

</html>