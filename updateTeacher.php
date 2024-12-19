<?php
session_start();
include "./backend/table.php";
if (isset($_SESSION["warning"])) {
    echo "<script>alert('" . $_SESSION['warning'] . "')</script>";
    unset($_SESSION["warning"]);
}
if (isset($_SESSION["error"])) {
    echo "<script>alert('" . $_SESSION['error'] . "')</script>";
    unset($_SESSION["error"]);
}

$teacherName = $fatherName = $motherName = $dob =   $email = $phone = $address =  $oldImage = $oldCertificate = "";
$gender = "Male";
$subject = "Hindi";
$image = "localProfile.png";
$education = "B. A.";
$teacherNameError = $dobError  = $subjectError  = $emailError = $phoneError = $addressError =  $educationError = $certificateError = "";

if (isset($_SESSION["errors"]) && isset($_SESSION["formData"])) {
    $teacherName = $_SESSION["formData"]["teacherName"]  ?? "";
    $dob = $_SESSION["formData"]["dob"]  ?? "";
    $subject = $_SESSION["formData"]["subject"]  ?? "";
    $education = $_SESSION["formData"]["education"]  ?? "";
    $gender = $_SESSION["formData"]["gender"]  ?? "";
    $email = $_SESSION["formData"]["email"]  ?? "";
    $phone = $_SESSION["formData"]["phone"]  ?? "";
    $address = $_SESSION["formData"]["address"]  ?? "";
    $image = $_SESSION["formData"]["oldImage"]  ?? "";
    $certificate = $_SESSION["formData"]["olgCertificate"]  ?? "";



    $teacherNameError = $_SESSION["errors"]["teacherName"]  ?? "";
    $dobError = $_SESSION["errors"]["dob"]  ?? "";
    $subjectError = $_SESSION["errors"]["subject"]  ?? "";
    $educationError = $_SESSION["errors"]["education"]  ?? "";
    $emailError = $_SESSION["errors"]["email"]  ?? "";
    $phoneError = $_SESSION["errors"]["phone"]  ?? "";
    $addressError = $_SESSION["errors"]["address"]  ?? "";
    $certificateError = $_SESSION["errors"]["certificate"]  ?? "";
    unset($_SESSION["errors"]);
    unset($_SESSION["formData"]);
}
if (isset($_GET["teacherId"])) {
    $id = $_GET["teacherId"];
    $query = "SELECT * FROM $dbName.$teacherTable WHERE teacherId = '$id' ";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $teacherId = $data["teacherId"]  ?? "";
        $teacherName = $data["teacherName"]  ?? "";
        $dob = $data["dob"]  ?? "";
        $subject = $data["subject"]  ?? "";
        $education = $data["education"]  ?? "";
        $gender = $data["gender"]  ?? "";
        $email = $data["email"]  ?? "";
        $phone = $data["phone"]  ?? "";
        $address = $data["address"]  ?? "";
        $image = $data["profileImage"]  ?? "";
        $certificate = $data["certificate"]  ?? "";
    }
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
                    <h3 class="text-center mb-4">Update Teacher </h3>
                    <form action="./backend/process.php" method="POST" enctype="multipart/form-data">

                        <div class="row mb-3 align-items-center">
                            <div class="col-md-6">
                                <label for="teacherName" class="form-label">Teacher Name</label>
                                <input type="text" class="form-control <?php echo !empty($teacherNameError) ? 'is-invalid' : ''; ?>" id="teacherName" name="teacherName" value="<?php echo $teacherName; ?>" placeholder="Enter teacher name">
                                <div class="invalid-feedback">
                                    <?php echo $teacherNameError; ?>
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
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control <?php echo !empty($emailError) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo $email; ?>" placeholder="Enter your email">
                                <div class="invalid-feedback">
                                    <?php echo $emailError; ?>
                                </div>
                            </div>
                        </div>


                        <div class="row align-items-center mb-3">
                            <div class="col-md-6">
                                <label for="subject" class="form-label">Subject</label>
                                <select aria-label="Select subject" class="form-select <?php echo !empty($subjectError) ? 'is-invalid' : ''; ?>" id="subject" name="subject">
                                    <option value="Hindi" <?php if ($subject == 'Hindi') echo 'selected'; ?>>Hindi</option>
                                    <option value="English" <?php if ($subject == 'English') echo 'selected'; ?>>English</option>
                                    <option value="Social Science" <?php if ($subject == 'Social Science') echo 'selected'; ?>>Social Science</option>
                                    <option value="Urdu" <?php if ($subject == 'Urdu') echo 'selected'; ?>>Urdu</option>
                                    <option value="Science" <?php if ($subject == 'Science') echo 'selected'; ?>>Science</option>
                                    <option value="Mathematics" <?php if ($subject == 'Mathematics') echo 'selected'; ?>>Mathematics</option>
                                    <option value="Art" <?php if ($subject == 'Art') echo 'selected'; ?>>Art</option>
                                    <option value="Computer" <?php if ($subject == 'Computer') echo 'selected'; ?>>Computer</option>
                                    <option value="Histery" <?php if ($subject == 'Histery') echo 'selected'; ?>>Histery</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?php echo $subjectError; ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="education" class="form-label">Education</label>
                                <select aria-label="Select education" class="form-select <?php echo !empty($educationError) ? 'is-invalid' : ''; ?>" id="education" name="education">
                                    <option value="B. A." <?php if ($education == 'B. A.') echo 'selected'; ?>>B. A.</option>
                                    <option value="B. Sc." <?php if ($education == 'B. Sc.') echo 'selected'; ?>>B. Sc.</option>
                                    <option value="M. Sc." <?php if ($education == 'M. Sc.') echo 'selected'; ?>>M. Sc.</option>
                                    <option value="TET" <?php if ($education == 'TET') echo 'selected'; ?>>TET</option>
                                    <option value="PTET" <?php if ($education == 'PTET') echo 'selected'; ?>>PTET</option>
                                    <option value="M. Tech." <?php if ($education == 'M. Tech.') echo 'selected'; ?>>M. Tech.</option>
                                    <option value="B. Tech." <?php if ($education == 'B. Tech.') echo 'selected'; ?>>B. Tech.</option>
                                    <option value="BCA" <?php if ($education == 'BCA') echo 'selected'; ?>>BCA</option>
                                    <option value="MCA" <?php if ($education == 'MCA') echo 'selected'; ?>>MCA</option>
                                    <option value="Ph. D." <?php if ($education == 'Ph. D.') echo 'selected'; ?>>Ph. D.</option>
                                    <option value="M. A." <?php if ($education == 'M. A.') echo 'selected'; ?>>M. A.</option>
                                </select>
                                <div class="invalid-feedback">
                                    <?php echo $educationError; ?>
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

                        <div class="row d-flex  mb-3 text-center mx-auto ">
                            <div class="col-md-6 ">
                                <div class="col-md-6 my-1  align-items-center justify-content-center">
                                    <p>Old Profile Image</p>
                                    <img height="100px" width="100px" src="./public/teacher/<?php echo htmlspecialchars($image) ?>" class="" alt="<?php echo htmlspecialchars($image) ?>">
                                </div>
                                <div id="imageContainer" style="display: none;" class="col-md-6   align-items-center justify-content-center">
                                    <p>New Profile Image</p>
                                    <img height="100px" id="newImage" width="100px" src="" class="" alt="New Image">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-6 my-1   align-items-center justify-content-center">
                                    <p>Old Certificate</p>
                                    <iframe height="100px" width="100px" src="./public/teacher/<?php echo htmlspecialchars($certificate) ?>" class="" alt="<?php echo htmlspecialchars($certificate) ?>"></iframe>
                                </div>
                                <div id="pdfContainer" style="display: none;" class="col-md-6  align-items-center justify-content-center">
                                    <p>New Certificate</p>
                                    <iframe height="100px" id="newPdf" width="100px" src="" frameborder="0" class="" alt="New pdf"></iframe>
                                </div>
                            </div>


                        </div>


                        <div class="mb-3">
                            <label for="profileImage" class="form-label">Certificate </label>
                            <input type="file" class="form-control <?php echo !empty($certificateError) ? 'is-invalid' : ''; ?>" id="certificate" name="certificate">
                            <div class="invalid-feedback">
                                <?php echo $certificateError; ?>
                            </div>
                        </div>


                        <div class="mb-3">
                            <label for="profileImage" class="form-label">Profile Image</label>
                            <input type="file" class="form-control" id="profileImage" name="profileImage">
                        </div>
                        <input type="hidden" name="teacherId" value="<?php echo htmlspecialchars($teacherId)  ?>">
                        <input type="hidden" name="oldCertificate" value="<?php echo htmlspecialchars($certificate)  ?>">
                        <input type="hidden" name="oldImage" value="<?php echo htmlspecialchars($image)  ?>">
                        <button type="submit" name="updateTeacher" class="btn btn-primary w-100">Update teacher</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        let imageBox = document.getElementById("imageContainer");
        let pdfBox = document.getElementById("pdfContainer");
        let image = document.getElementById("newImage");
        let pdf = document.getElementById("newPdf");

        console.log(pdf);
        let imageInput = document.getElementById("profileImage");
        let pdfInput = document.getElementById("certificate");


        function preview(event, container, box) {
            const file = event.target.files[0]; // Get the selected file
            if (file) {
                let src = URL.createObjectURL(file);
                console.log(src);
                box.setAttribute("src", src);
                container.style.display = 'block'; // Hide the preview if no file is selected

            } else {
                container.style.display = 'none'; // Hide the preview if no file is selected
            }
        }


        imageInput.addEventListener("change", (event) => {
            preview(event, imageBox, image);
        });

        pdfInput.addEventListener("change", (event) => {
            preview(event, pdfBox, pdf);
        });
    </script>





</body>



</html>