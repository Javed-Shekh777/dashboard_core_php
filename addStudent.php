<?php
session_start();
if (isset($_SESSION["warning"])) {
    echo "<script>alert('" . $_SESSION['warning'] . "')</script>";
    unset($_SESSION["warning"]);
}
if (isset($_SESSION["error"])) {
    echo "<script>alert('" . $_SESSION['error'] . "')</script>";
    unset($_SESSION["error"]);
}

$studentName = $fatherName = $motherName = $dob =   $email = $phone = $address =  "";
$gender = "Male";
$class = "Nursery";
$section = "A";
$studentNameError = $fatherNameError = $motherNameError = $dobError  = $classError  = $emailError = $phoneError = $addressError =  "";

if (isset($_SESSION["errors"]) && isset($_SESSION["formData"])) {
    $studentName = $_SESSION["formData"]["studentName"]  ?? "";
    $fatherName = $_SESSION["formData"]["fatherName"]  ?? "";
    $motherName = $_SESSION["formData"]["motherName"]  ?? "";
    $dob = $_SESSION["formData"]["dob"]  ?? "";
    $class = $_SESSION["formData"]["class"]  ?? "";
    $section = $_SESSION["formData"]["section"]  ?? "";
    $gender = $_SESSION["formData"]["gender"]  ?? "";
    $email = $_SESSION["formData"]["email"]  ?? "";
    $phone = $_SESSION["formData"]["phone"]  ?? "";
    $address = $_SESSION["formData"]["address"]  ?? "";


    $studentNameError = $_SESSION["errors"]["studentName"]  ?? "";
    $fatherNameError = $_SESSION["errors"]["fatherName"]  ?? "";
    $motherNameError = $_SESSION["errors"]["motherName"]  ?? "";
    $dobError = $_SESSION["errors"]["dob"]  ?? "";
    $classError = $_SESSION["errors"]["class"]  ?? "";
    $emailError = $_SESSION["errors"]["email"]  ?? "";
    $phoneError = $_SESSION["errors"]["phone"]  ?? "";
    $addressError = $_SESSION["errors"]["address"]  ?? "";

    unset($_SESSION["errors"]);
    unset($_SESSION["formData"]);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            /* height: ; */
            margin: 0;
        }

        .signup-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #6c63ff;
        }

        .btn-primary {
            background-color: #6c63ff;
            border-color: #6c63ff;
        }

        .btn-primary:hover {
            background-color: #5a54d6;
            border-color: #5a54d6;
        }
    </style>
</head>

<body class="bg-dark  bg-hover">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="signup-card bg-white p-4 mt-2">
                    <h3 class="text-center mb-4">Add Student </h3>
                    <form action="./backend/process.php" method="POST" enctype="multipart/form-data">

                        <div class="row mb-3 align-items-center">
                            <div class="col-md-6">
                                <label for="studentName" class="form-label">Student Name</label>
                                <input type="text" class="form-control <?php echo !empty($studentNameError) ? 'is-invalid' : ''; ?>" id="studentName" name="studentName" value="<?php echo $studentName; ?>" placeholder="Enter student name">
                                <div class="invalid-feedback">
                                    <?php echo $studentNameError; ?>
                                </div>
                            </div>
                            <div class=" col-md-6">
                                <label for="fatherName" class="form-label">Father Name</label>
                                <input type="text" class="form-control <?php echo !empty($fatherNameError) ? 'is-invalid' : ''; ?>" id="fatherName" name="fatherName" value="<?php echo $fatherName; ?>" placeholder="Enter your father name">
                                <div class="invalid-feedback">
                                    <?php echo $fatherNameError; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 align-items-center">
                            <div class="col-md-6">
                                <label for="motherName" class="form-label">Mother Name</label>
                                <input type="text" class="form-control <?php echo !empty($motherNameError) ? 'is-invalid' : ''; ?>" id="motherName" name="motherName" value="<?php echo $motherName; ?>" placeholder="Enter your mother name">
                                <div class="invalid-feedback">
                                    <?php echo $motherNameError; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="dob" class="form-label">Dob</label>
                                <input type="date" class="form-control <?php echo !empty($dobError) ? 'is-invalid' : ''; ?>" id="dob" name="dob" value="<?php echo $dob; ?>">
                                <div class="invalid-feedback">
                                    <?php echo $dobError; ?>
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-md-6 ">
                                <label for="gender" class="form-label d-block">Gender</label>
                                Male <input class="form-check-input me-3 " type="radio" name="gender" id="male" value="Male" <?php if ($gender == "Male") {
                                                                                                                                    echo "checked";
                                                                                                                                }  ?>>
                                Female <input class="form-check-input " type="radio" name="gender" id="female" value="Female" <?php if ($gender == "Female") {
                                                                                                                                    echo "checked";
                                                                                                                                } ?>>
                            </div>
                            <div class="col-md-6">
                                <label for="section" class="form-label d-block">Section</label>
                                A <input class="form-check-input me-3 " type="radio" name="section" id="A" value="A" <?php if ($section == "A") {
                                                                                                                            echo "checked";
                                                                                                                        }  ?>>
                                B <input class="form-check-input me-3 " type="radio" name="section" id="B" value="B" <?php if ($section == "B") {
                                                                                                                            echo "checked";
                                                                                                                        }  ?>>
                                C <input class="form-check-input me-3 " type="radio" name="section" id="C" value="C" <?php if ($section == "C") {
                                                                                                                            echo "checked";
                                                                                                                        }  ?>>
                                D <input class="form-check-input " type="radio" name="section" id="D" value="D" <?php if ($section == "D") {
                                                                                                                    echo "checked";
                                                                                                                }  ?>>
                            </div>
                        </div>


                        <div class="row align-items-center mb-3">
                            <div class="col-md-6">
                                <label for="class" class="form-label">Class</label>
                                <select aria-label="Select class" class="form-select <?php echo !empty($classError) ? 'is-invalid' : ''; ?>" id="class" name="class">
                                    <option value="Nursery" <?php if ($class == 'Nursery') echo 'selected'; ?>>Nursery</option>
                                    <option value="KG" <?php if ($class == 'KG') echo 'selected'; ?>>KG</option>
                                    <option value="1" <?php if ($class == '1') echo 'selected'; ?>>1st</option>
                                    <option value="2" <?php if ($class == '2') echo 'selected'; ?>>2nd</option>
                                    <option value="3" <?php if ($class == '3') echo 'selected'; ?>>3rd</option>
                                    <option value="4" <?php if ($class == '4') echo 'selected'; ?>>4th</option>
                                    <option value="5" <?php if ($class == '5') echo 'selected'; ?>>5th</option>
                                    <option value="6" <?php if ($class == '6') echo 'selected'; ?>>6th</option>
                                    <option value="7" <?php if ($class == '7') echo 'selected'; ?>>7th</option>
                                    <option value="8" <?php if ($class == '8') echo 'selected'; ?>>8th</option>
                                    <option value="9" <?php if ($class == '9') echo 'selected'; ?>>9th</option>
                                    <option value="10" <?php if ($class == '10') echo 'selected'; ?>>10th</option>
                                    <option value="11" <?php if ($class == '11') echo 'selected'; ?>>11th</option>
                                    <option value="12" <?php if ($class == '12') echo 'selected'; ?>>12th</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?php echo $classError; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control <?php echo !empty($emailError) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo $email; ?>" placeholder="Enter your email">
                                <div class="invalid-feedback">
                                    <?php echo $emailError; ?>
                                </div>
                            </div>
                        </div>


                        <div class="row align-items-center mb-3">
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control <?php echo !empty($phoneError) ? 'is-invalid' : ''; ?>" id="phone" name="phone" value="<?php echo $phone; ?>" placeholder="Enter your phone">
                                <div class="invalid-feedback">
                                    <?php echo $phoneError; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <textarea cols="3" style="resize: none;" class="form-control <?php echo !empty($addressError) ? 'is-invalid' : ''; ?>" id="address" name="address" placeholder="Enter your address"><?php echo htmlspecialchars($address); ?>
                                </textarea>
                                <div class="invalid-feedback">
                                    <?php echo $addressError; ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="profileImage" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="profileImage" name="profileImage">
                        </div>

                        <button type="submit" name="addStudent" class="btn btn-primary w-100">Add Student</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


</body>



</html>