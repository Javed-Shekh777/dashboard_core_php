<?php
include "./backend/table.php";
include "./backend/helper.php";

$helper = new Helper();
session_start();




$username = $password  = $warning = $search = "";
$result = "";
$usernameError =  $passwordError =  "";
$userData = "";
unset($_SESSION["formData"]);
unset($_SESSION["errors"]);
if (isset($_SESSION["warning"])) {
    echo "<script>alert('" . $_SESSION['warning'] . "')</script>";
    unset($_SESSION["warning"]);
}
if (isset($_SESSION["error"])) {
    echo "<script>alert('" . $_SESSION['error'] . "')</script>";
    unset($_SESSION["error"]);
}
if (isset($_SESSION["success"])) {
    echo "<script>alert('" . $_SESSION['success'] . "')</script>";
    unset($_SESSION["success"]);
}

if (!isset($_SESSION["username"])) {
    header("location: ./login.php");
    exit();
}

// ?action=view&studentId=<?php echo $row['studentId']; 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["search"])) {
        $search = $_POST["search"];
        $query = "SELECT * FROM $dbName.$studentTable WHERE (studentName LIKE '%$search%' OR fatherName LIKE '%$search%' OR motherName LIKE '%$search%' OR email LIKE '%$search%'  )";
        $result = mysqli_query($conn, $query);
    } else if (isset($_POST["cut"])) {
        $search = "";
        // $query = "SELECT * FROM $dbName.$studentTable ";
        // $result = mysqli_query($conn, $query);
        // $result = $helper->getUsers("","",$conn,$dbName,$studentTable);
        $result = $helper->getUsers($conn, $dbName, $studentTable);
    }
} else {
    // $query = "SELECT * FROM $dbName.$studentTable ";
    // $result = mysqli_query($conn, $query);
    $result = $helper->getUsers($conn, $dbName, $studentTable);
}

if (isset($_SESSION["getUserData"])) {
    $userData = $_SESSION["getUserData"];
    unset($_SESSION["getUserData"]);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
   <!-- Bootstrap CSS --> 
     <!-- Bootstrap CSS --> 
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css" />
    <style>
        .card h6 {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-custom {
            position: relative;
            border: none;
            border-radius: 10px;
            background-color: #6b6161;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .card-custom::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 6px;
            height: 100%;
            background-color: #007bff;
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .table-responsive {
            overflow-x: auto;
            scrollbar-width: "thin";
        }

        .table {
            width: auto;
            min-width: 100%;
        }

        th,
        td {
            white-space: nowrap;
            text-align: left;
        }
    </style>
</head>

<body>



    <?php include "./sidebar.php" ?>


    <!-- Main Content -->
    <div class="flex-grow-1">
        <?php include "./header.php" ?>


        <div class="container" style="margin-top:70px;">
            <section class="bg-secondary p-3">
                <div class="container">
                    <div class="d-flex align-items-center gap-2">
                        <!-- Search Bar -->
                        <form method="POST" action="" class="w-100">
                            <div class="input-group">

                                <input type="text" name="search" <?php if ($search) echo htmlspecialchars("disabled") ?> class="form-control" placeholder="Search by Name or Email" value="<?php echo htmlspecialchars($search); ?>" required>

                                <?php if ($search) : ?>
                                    <div class="input-group-append">
                                        <input type="hidden" name="cut">
                                        <button name="cut" class="btn btn-primary" type="submit">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                <?php endif; ?>
                                <?php if (!$search) : ?>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </form>



                        <!-- Dropdown -->
                        <div class="dropdown mr-2">
                            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Dropdown
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">Action 1</a>
                                <a class="dropdown-item" href="#">Action 2</a>
                                <a class="dropdown-item" href="#">Action 3</a>
                            </div>
                        </div>

                        <!-- Button -->
                        <button class="btn btn-primary"><a href="./addStudent.php" class="text-white text-decoration-none">Add</a></button>
                    </div>
                </div>
            </section>




        </div>

        <div class="container">
            <div class="bg-secondary p-3">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 text-center table-responsive">

                            <table class="table table-striped table-light text-white flex-shrink-0">
                                <thead>
                                    <tr class="flex-shrink-0">
                                        <th>Student_Id</th>
                                        <th>Name</th>
                                        <th>Father name</th>
                                        <th>Mother name</th>
                                        <th>Gender</th>
                                        <th>DOB</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Image</th>
                                        <th>Operations</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result) :
                                        while ($row = mysqli_fetch_assoc($result)): ?>
                                            <tr>
                                                <td><?php echo $row['studentId']; ?></td>
                                                <td><?php echo $row['studentName']; ?></td>
                                                <td><?php echo $row['fatherName']; ?></td>
                                                <td><?php echo $row['motherName']; ?></td>
                                                <td><?php echo $row['gender']; ?></td>
                                                <td><?php echo $row['dob']; ?></td>
                                                <td><?php echo $row['class']; ?></td>
                                                <td><?php echo $row['section']; ?></td>
                                                <td><?php echo $row['phone']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td><img src="./public/student/<?php echo $row['profileImage']; ?>" alt="Image" height="33" style="object-fit: cover;" width="50"></td>
                                                <td class="d-flex align-items-center gap-2">
                                                    <a href="./backend/process.php?action=view&studentId=<?php echo $row['studentId']; ?>" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?php echo $row['studentId']; ?>" class="btn p-1 btn-info text-white">View</a>
                                                    <a class="btn p-1 btn-danger text-white" href="./backend/process.php?action=delete&studentId=<?php echo $row['studentId']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
                                                    <a class="btn p-1 btn-success text-white" href="./updateStudent.php?studentId=<?php echo $row['studentId']; ?>">Update</a>
                                                </td>
                                            </tr>

                                    <?php endwhile;
                                    else : echo "<p class='text-danger'> Data not found</p>";
                                    endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                </section>
            </div>



        </div>
    </div>



    <!-- Button trigger modal -->

    <!-- Modal -->
    <?php if (isset($userData)) :  ?>
        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Student Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    <div class="signup-card bg-white p-4">
                                        <div class="row mb-3 text-center mx-auto ">
                                            <div class="   align-items-center justify-content-center">
                                                <p>Profile Image</p>
                                                <img height="100px" width="100px" src="./public/student/<?php echo htmlspecialchars($userData['profileImage']) ?>" class="" alt="new image">
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-6">
                                                <label>Student Name</label>
                                                <p class="border-2 border rounded-3 p-2 "><?php echo htmlspecialchars($userData['studentName']) ?></p>
                                            </div>
                                            <div class=" col-md-6">
                                                <label for="fatherName" class="form-label">Father Name</label>
                                                <p class="border-2 border rounded-3 p-2 "><?php echo htmlspecialchars($userData['fatherName']) ?></p>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-6">
                                                <label for="motherName" class="form-label">Mother Name</label>
                                                <p class="border-2 border rounded-3 p-2 "><?php echo htmlspecialchars($userData['motherName']) ?></p>

                                            </div>
                                            <div class="col-md-6">
                                                <label for="dob" class="form-label">Dob</label>
                                                <p class="border-2 border rounded-3 p-2 "><?php echo htmlspecialchars($userData['dob']) ?></p>
                                            </div>
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-6 ">
                                                <label for="gender" class="form-label d-block">Gender</label>
                                                <p class="border-2 border rounded-3 p-2 "><?php echo htmlspecialchars($userData['gender']) ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="section" class="form-label d-block">Section</label>
                                                <p class="border-2 border rounded-3 p-2 "><?php echo htmlspecialchars($userData['section']) ?></p>
                                            </div>
                                        </div>


                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-6">
                                                <label for="class" class="form-label">Class</label>
                                                <p class="border-2 border rounded-3 p-2 "><?php echo htmlspecialchars($userData['class']) ?></p>

                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Email</label>
                                                <p class="border-2 border rounded-3 p-2 "><?php echo htmlspecialchars($userData['email']) ?></p>
                                            </div>
                                        </div>

                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-6">
                                                <label for="phone" class="form-label">Phone</label>
                                                <p class="border-2 border rounded-3 p-2 "><?php echo htmlspecialchars($userData['phone']) ?></p>

                                            </div>
                                            <div class="col-md-6">
                                                <label for="address" class="form-label">Address</label>
                                                <p class="border-2 border rounded-3 p-2 "><?php echo htmlspecialchars($userData['address']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>

    <?php else :  ?>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Student Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalContent">
                        Data not found
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>







 
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const toggler = document.querySelector('.sidebar-toggler');
        const sidebar = document.querySelector('.sidebar');

        toggler.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });

        
    </script>
</body>

</html>