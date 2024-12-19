<?php
include "./table.php";
include "./helper.php";
include "./mail.php";


$userFolder = "../public/user/";
$studentFolder = "../public/student/";
$teacherFolder = "../public/teacher/";

$helper = new Helper();

if (isset($_GET["resend"]) && isset($_GET["email"])) {
    $otp = $helper->unique_id(6, "numeric");
    $email = $_GET['email'];

    $query = "UPDATE $dbName.$userTable SET verification_token = '$otp' WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (sendtOTP($email, "", $otp)) {
            $_SESSION["success"] = "Email send successfully.";
            $_SESSION["formData"]['email'] = $email;


            header("location: ../verify.php");
            exit();
        } else {
            $_SESSION["error"] = "Email not send.";
            $_SESSION["formData"]['email'] = $email;

            header("location: ../verify.php");
            exit();
        }
    } else {
        $_SESSION["error"] = "Something went wrong.";
        $_SESSION["formData"]['email'] = $email;

        header("location: ../verify.php");
        exit();
    }
}



if (isset($_POST["register"])) {
    session_start();
    $userId = $helper->unique_id(6, "numeric");
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $profileImage = $_FILES["profileImage"]["name"];
    $imageTmp_name = $_FILES["profileImage"]["tmp_name"];

    if (empty($username)) {
        $_SESSION["errors"]["username"] = "Username is requred.";
    }
    if (empty($email)) {
        $_SESSION["errors"]["email"] = "Email is requred.";
    }
    if (empty($password)) {
        $_SESSION["errors"]["password"] = "Password is requred.";
    }



    $ext = pathinfo($profileImage, PATHINFO_EXTENSION);
    $imagePath = $helper->unique_id(10) . "." . $ext ?? "";
    $hashPassword = password_hash($password, PASSWORD_BCRYPT);


    if (!empty($_SESSION["errors"])) {
        $_SESSION['formData']["username"] = $username ?? "";
        $_SESSION['formData']["email"] = $email ?? "";
        $_SESSION['formData']["password"] = $password ?? "";
        header("location: ../register.php");
        exit();
    };

    $token = $helper->unique_id(6, "numeric");


    $query = "SELECT userId,username,email FROM $dbName.$userTable WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $_SESSION["warning"] = "User already exist.";
        header("location: ../register.php");
        exit();
    }

    $query = "INSERT INTO $dbName.$userTable(userId,username,email,password,profileImage,role,verification_token) VALUES('$userId','$username','$email','$password','$imagePath','admin','$token');";

    $result = mysqli_query($conn, $query);

    if ($result) {

        $verification_code = bin2hex(random_bytes(16));;
        if (sendtOTP($email, $verification_code, $token)) {
            move_uploaded_file($imageTmp_name, $userFolder . $imagePath);
            $_SESSION["success"] = "Email send successfully Please verify your email.";
            header("location: ../verify.php");
            exit();
        }
    }
};



if (isset($_POST["verifyEmail"]) || isset($_GET["verifyEmail"])) {
    session_start();

    $email = trim($_POST["verifyEmail"]) ?? trim($_GET["verifyEmail"]);
    $otp = trim($_POST["otp"]) ?? trim($_GET["token"]);

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";


    if (empty($email)) {
        $_SESSION["errors"]["email"] = "Email is requred.";
    }
    if (empty($otp)) {
        $_SESSION["errors"]["otp"] = "OTP is requred.";
    }


    if (!empty($_SESSION["errors"])) {
        $_SESSION['errors']['otp'] = "OTP is required";
        $_SESSION['formData']['email'] = $email;

        header("location: ../verify.php");
        exit();
    };

    echo "<pre>";
    print_r($_GET);
    echo "</pre>";

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";


    // $query = "SELECT * FROM $dbName.$userTable WHERE email = '$email'";
    // $result = mysqli_query($conn, $query);
    // if (mysqli_num_rows($result) > 0) {
    //     $data = mysqli_fetch_assoc($result);
    //     echo "<pre>";
    //     print_r($data);



    //     if ($otp === $data["verification_token"]) {
    //         $query = "UPDATE $dbName.$userTable SET email_verified = 1,verification_token = '' WHERE email = '$email'";
    //         $result = mysqli_query($conn, $query);

    //         if ($result) {
    //             $_SESSION["success"] = "Email verified successfully.";
    //             header("location: ../login.php");
    //             exit();
    //         } else {
    //             $_SESSION["error"] = "Something went wrong.";
    //             header("location: ../verify.php");
    //             exit();
    //         }
    //     } else {
    //         $_SESSION["error"] = "OTP is wrong.";
    //         $_SESSION["formData"]['email'] = $data['email'];
    //         header("location: ../verify.php");
    //         exit();
    //     }
    // }
}





if (isset($_POST["login"])) {
    session_start();

    $username = trim($_POST["username"]);

    $password = trim($_POST["password"]);


    if (empty($username)) {
        $_SESSION["errors"]["username"] = "Username is requred.";
    }

    if (empty($password)) {
        $_SESSION["errors"]["password"] = "Password is requred.";
    }




    if (!empty($_SESSION["errors"])) {
        $_SESSION['formData']["username"] = $username ?? "";
        $_SESSION['formData']["password"] = $password ?? "";
        header("location: ../login.php");
        exit();
    };

    $query = "SELECT * FROM $dbName.$userTable WHERE (username = '$useranme' OR email = '$username')";
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();



        $psw = $password === $data["password"] ? true : false;

        if (!$psw) {
            $_SESSION["warning"] = "Email or password is wrong.";
            header("location: ../login.php");
            exit();
        }

        if ($data['email_verified'] == 1 && $data['verification_token'] == '') {
            $_SESSION["success"] = "Login successfully.";
            $_SESSION["username"] = $data["username"];
            $_SESSION["loginTime"] = time();
            $_SESSION['userData'] = $data;
            header("location: ../index.php");
            exit();
        } else {
            $_SESSION["warning"] = "Please first verify your email.";

            header("location: ../login.php");
        }
    } else {
        $_SESSION["error"] = "User not exist.";
        header("location: ../login.php");
        exit();
    }
};




if (isset($_POST["logout"])) {
    session_start(); // Start the session

    // Unset all session variables
    $_SESSION = [];

    // If you want to destroy the session completely, also delete the session cookie
    // if (ini_get("session.use_cookies")) {
    //     $params = session_get_cookie_params();
    //     setcookie(
    //         session_name(),
    //         '',
    //         time() - 42000,
    //         $params["path"],
    //         $params["domain"],
    //         $params["secure"],
    //         $params["httponly"]
    //     );
    // }

    // Finally, destroy the session
    session_destroy();

    // Redirect to the login page or home page
    header("Location: ../login.php");
    exit();
}




if (isset($_POST["forgetPassword"])) {
    session_start();

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $cpassword = trim($_POST["cpassword"]);

    if (empty($username)) {
        $_SESSION["errors"]["username"] = "Username is requred.";
    }

    if (empty($password)) {
        $_SESSION["errors"]["password"] = "Password is requred.";
    }
    if (empty($cpassword)) {
        $_SESSION["errors"]["cpassword"] = "Confirm Password is requred.";
    } else if ($cpassword != $password) {
        $_SESSION["errors"]["password"] = "Password not matched.";
    }


    // $hashPassword = password_hash($password, PASSWORD_DEFAULT);


    if (!empty($_SESSION["errors"])) {
        $_SESSION['formData']["username"] = $username ?? "";
        $_SESSION['formData']["password"] = $password ?? "";
        $_SESSION['formData']["cpassword"] = $cpassword ?? "";
        header("location: ../forgetPassword.php");
        exit();
    };

    $query = "SELECT * FROM $dbName.$userTable WHERE (username = '$useranme' OR email = '$username')";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $query = "UPDATE $dbName.$userTable SET password = '$password' WHERE (username = '$useranme' OR email = '$username')";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            $_SESSION["error"] = "Password not updated.";
            header("location: ../forgetPassword.php");
            exit();
        }

        $_SESSION["success"] = "Password updated successfully.";
        header("location: ../login.php");
        session_destroy();
        session_unset();
        exit();
    } else {
        $_SESSION["error"] = "User not exist.";
        header("location: ../forgetPassword.php");
        exit();
    }
};




if (isset($_POST["addStudent"]) || isset($_POST["updateStudent"])) {
    session_start();
    $studentId = "";
    $studentName = trim($_POST["studentName"]);
    $fatherName = trim($_POST["fatherName"]);
    $motherName = trim($_POST["motherName"]);
    $dob = trim($_POST["dob"]);
    $gender = trim($_POST["gender"]);
    $class = trim($_POST["class"]);
    $section = trim($_POST["section"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);
    $olgImage = trim($_POST["oldImage"]);
    $profileImage = $_FILES["profileImage"]["name"];
    $imageTmp_name = $_FILES["profileImage"]["tmp_name"];

    if (empty($studentName)) {
        $_SESSION["errors"]["studentName"] = "Student Name is requred.";
    }
    if (empty($fatherName)) {
        $_SESSION["errors"]["fatherName"] = "Father name is requred.";
    }
    if (empty($motherName)) {
        $_SESSION["errors"]["motherName"] = "Mother name is requred.";
    }
    if (empty($dob)) {
        $_SESSION["errors"]["dob"] = "Dob is requred.";
    }
    if (empty($class)) {
        $_SESSION["errors"]["class"] = "Class is requred.";
    }
    if (empty($email)) {
        $_SESSION["errors"]["email"] = "Email is requred.";
    }
    if (empty($phone)) {
        $_SESSION["errors"]["phone"] = "Phone is requred.";
    }
    if (empty($address)) {
        $_SESSION["errors"]["address"] = "Address is requred.";
    }


    $ext = pathinfo($profileImage, PATHINFO_EXTENSION);
    $imagePath = $ext ?  $helper->unique_id(10) . "." . $ext : $olgImage;




    if (isset($_POST["addStudent"])) {
        $studentId = $helper->unique_id(6, "numeric");
        if (!empty($_SESSION["errors"])) {
            $_SESSION["formData"]["studentName"] = $studentName ?? "";
            $_SESSION["formData"]["fatherName"] = $fatherName  ?? "";
            $_SESSION["formData"]["motherName"] = $motherName ?? "";
            $_SESSION["formData"]["dob"] = $dob ?? "";
            $_SESSION["formData"]["gender"] = $gender ?? "";
            $_SESSION["formData"]["class"] = $class ?? "";
            $_SESSION["formData"]["section"] = $section ?? "";
            $_SESSION["formData"]["email"] = $email ?? "";
            $_SESSION["formData"]["address"] = $address ?? "";
            $_SESSION["formData"]["phone"] = $address ?? "";
            header("location: ../addStudent.php");
            exit();
        };

        $query = "SELECT * FROM $dbName.$studentTable WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $_SESSION["warning"] = "Student already exist with email.";
            header("location: ../addStudent.php");
            exit();
        }

        $query = "INSERT INTO $dbName.$studentTable(studentId,studentName,fatherName,motherName,dob,gender,class,section,email,phone,address,profileImage) VALUES('$studentId','$studentName','$fatherName','$motherName','$dob','$gender','$class','$section','$email','$phone','$address','$imagePath');";

        $result = mysqli_query($conn, $query);

        if ($result) {
            move_uploaded_file($imageTmp_name, $studentFolder . $imagePath);
            $_SESSION["success"] = "Student Added Successfully.";
            header("location: ../student.php");
            exit();
        }
    }



    if (isset($_POST["updateStudent"])) {
        $studentId = $_POST["studentId"];
        if (!empty($_SESSION["errors"])) {
            $_SESSION["formData"]["studentName"] = $studentName ?? "";
            $_SESSION["formData"]["fatherName"] = $fatherName  ?? "";
            $_SESSION["formData"]["motherName"] = $motherName ?? "";
            $_SESSION["formData"]["dob"] = $dob ?? "";
            $_SESSION["formData"]["gender"] = $gender ?? "";
            $_SESSION["formData"]["class"] = $class ?? "";
            $_SESSION["formData"]["section"] = $section ?? "";
            $_SESSION["formData"]["email"] = $email ?? "";
            $_SESSION["formData"]["address"] = $address ?? "";
            $_SESSION["formData"]["oldImage"] = $olgImage;
            header("location: ../updateStudent.php");
            exit();
        };


        $query = "UPDATE $dbName.$studentTable SET 
        studentName = '$studentName',
        fatherName = '$fatherName',
        motherName = '$motherName',
        dob = '$dob',
        gender = '$gender',
        class = '$class',
        section = '$section',
        email = '$email',
        phone = '$phone',
        address = '$address',
        profileImage = '$imagePath'
         WHERE studentId = '$studentId'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if ($ext) {
                move_uploaded_file($imageTmp_name, $studentFolder . $imagePath);
                unlink($studentFolder . $olgImage);
            }
            $_SESSION["success"] = "Student Updated Successfully.";
            header("location: ../student.php");
            exit();
        } else {
            $_SESSION["error"] = "Student not Updated.";
            header("location: ../updateStudent.php");
            exit();
        }
    }
};





if (isset($_POST["addTeacher"]) || isset($_POST["updateTeacher"])) {

    session_start();
    $teacherId = "";
    $teacherName = trim($_POST["teacherName"]);
    $dob = trim($_POST["dob"]);
    $gender = trim($_POST["gender"]);
    $subject = trim($_POST["subject"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $education = trim($_POST["education"]);
    $address = trim($_POST["address"]);
    $olgImage = trim($_POST["oldImage"]) ?? "";
    $olgCertificate = trim($_POST["oldCertificate"]) ?? "";
    $profileImage = $_FILES["profileImage"]["name"];
    $imageTmp_name = $_FILES["profileImage"]["tmp_name"];
    $certificate = $_FILES["certificate"]["name"];
    $certificateTmp_name = $_FILES["certificate"]["tmp_name"];

    if (empty($teacherName)) {
        $_SESSION["errors"]["teacherName"] = "Teacher Name is requred.";
    }
    if (empty($dob)) {
        $_SESSION["errors"]["dob"] = "Dob is requred.";
    }
    if (empty($subject)) {
        $_SESSION["errors"]["subject"] = "Subject is requred.";
    }
    if (empty($email)) {
        $_SESSION["errors"]["email"] = "Email is requred.";
    }
    if (empty($phone)) {
        $_SESSION["errors"]["phone"] = "Phone is requred.";
    }
    if (empty($address)) {
        $_SESSION["errors"]["address"] = "Address is requred.";
    }
    if (empty($education)) {
        $_SESSION["errors"]["education"] = "Education is requred.";
    }



    $ext1 = pathinfo($profileImage, PATHINFO_EXTENSION);
    $imagePath = $ext1 ?  $helper->unique_id(10) . "." . $ext1 ?? "" : $olgImage;


    $ext2 = pathinfo($certificate, PATHINFO_EXTENSION);
    $certificatePath = $ext2 ?  $helper->unique_id(10) . "." . $ext2 ?? "" : $olgCertificate;



    if (isset($_POST["addTeacher"])) {
        if (empty($certificate)) {
            $_SESSION["errors"]["certificate"] = "Certificate is requred.";
        }

        if (!empty($_SESSION["errors"])) {
            $_SESSION["formData"]["teacherName"] = $teacherName ?? "";
            $_SESSION["formData"]["dob"] = $dob ?? "";
            $_SESSION["formData"]["gender"] = $gender ?? "";
            $_SESSION["formData"]["subject"] = $class ?? "";
            $_SESSION["formData"]["email"] = $email ?? "";
            $_SESSION["formData"]["address"] = $address ?? "";
            $_SESSION["formData"]["phone"] = $address ?? "";
            $_SESSION["formData"]["education"] = $education ?? "";

            header("location: ../addTeacher.php");
            exit();
        };

        $teacherId = $helper->unique_id(6, "numeric");

        $query = "SELECT * FROM $dbName.$teacherTable WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $_SESSION["warning"] = "Teacher already exist with email.";
            header("location: ../addTeacher.php");
            exit();
        }

        $query = "INSERT INTO $dbName.$teacherTable(teacherId,teacherName,dob,gender,subject,education,email,phone,address,certificate,profileImage) 
        VALUES('$teacherId','$teacherName','$dob','$gender','$subject','$education','$email','$phone','$address','$certificatePath','$imagePath');";

        $result = mysqli_query($conn, $query);

        if ($result) {
            move_uploaded_file($imageTmp_name, $teacherFolder . $imagePath);
            move_uploaded_file($certificateTmp_name, $teacherFolder . $certificatePath);

            $_SESSION["success"] = "Teacher Added Successfully.";
            header("location: ../teacher.php");
            exit();
        }
    }



    if (isset($_POST["updateTeacher"])) {
        if (empty($olgCertificate)) {
            $_SESSION["errors"]["certificate"] = "Certificate is requred.";
        }
        $teacherId = $_POST["teacherId"];
        if (!empty($_SESSION["errors"])) {
            $_SESSION["formData"]["teacherName"] = $teacherName ?? "";
            $_SESSION["formData"]["dob"] = $dob ?? "";
            $_SESSION["formData"]["gender"] = $gender ?? "";
            $_SESSION["formData"]["subject"] = $class ?? "";
            $_SESSION["formData"]["email"] = $email ?? "";
            $_SESSION["formData"]["address"] = $address ?? "";
            $_SESSION["formData"]["phone"] = $address ?? "";
            $_SESSION["formData"]["education"] = $education ?? "";
            $_SESSION["formData"]["oldImage"] = $olgImage;
            $_SESSION["formData"]["olgCertificate"] = $olgCertificate ?? "";
            header("location: ../updateTeacher.php");
            exit();
        };

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        echo "<pre>";
        print_r($_FILES);
        echo "</pre>";
        $query = "UPDATE $dbName.$teacherTable SET 
        teacherName = '$teacherName',
        dob = '$dob',
        gender = '$gender',
        subject = '$subject',
        education = '$education',
        email = '$email',
        phone = '$phone',
        address = '$address',
        profileImage = '$imagePath',
        certificate = '$certificatePath'
         WHERE teacherId = '$teacherId'";
        $result = mysqli_query($conn, $query);



        echo $result;

        if ($result) {
            if ($ext1) {
                move_uploaded_file($imageTmp_name, $teacherFolder . $imagePath);
                unlink($teacherFolder . $olgImage);
            }
            if ($ext2) {
                move_uploaded_file($certificateTmp_name, $teacherFolder . $certificatePath);
                unlink($teacherFolder . $olgCertificate);
            }
            $_SESSION["success"] = "Teacher Updated Successfully.";
            header("location: ../teacher.php");
            exit();
        } else {
            $_SESSION["error"] = "Teacher not Updated.";
            header("location: ../updateTeacher.php");
            exit();
        }
    }
};


function getUserData($key, $value, $conn, $dbName, $table)
{

    $query = "SELECT * FROM $dbName.$table WHERE $key = '$value'";
    $data = mysqli_query($conn, $query);
    if (mysqli_num_rows($data) > 0) {
        return mysqli_fetch_assoc($data);
    } else {
        return null;
    }
};





if (isset($_GET['action']) && $_GET['action'] === 'view') {
    session_start();
    $id = "";
    $data = "";

    if (isset($_GET["studentId"])) {

        $id =  $_GET["studentId"];
        $data =  getUserData("studentId", $id, $conn, $dbName, $studentTable);
        if ($data) {
            $_SESSION["getUserData"] = $data;
            print_r($_SESSION["getUserData"]);
            header("location: ../student.php");
            exit();
        }
    }

    if (isset($_GET["teacherId"])) {
        $id =  $_GET["teacherId"];

        $data =  getUserData("teacherId", $id, $conn, $dbName, $teacherTable);
        if ($data) {
            $_SESSION["getUserData"] = $data;
            print_r($_SESSION["getUserData"]);
            header("location: ../teacher.php");
            exit();
        }
    }
}


if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    session_start();
    $id = "";
    $data = "";

    if (isset($_GET["studentId"])) {
        $id = $_GET["studentId"];
        echo "Student Id : " . $id;

        $query = "SELECT profileImage FROM $dbName.$studentTable WHERE studentId = '$id'";
        $result = mysqli_query($conn, $query);


        if (mysqli_num_rows($result) > 0) {
            $userData = mysqli_fetch_array($result);
            $query = "DELETE FROM $dbName.$studentTable WHERE studentId = '$id'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                unlink($studentFolder . $userData["profileImage"]);
                $_SESSION["success"] = "Student Deleted Successfully.";
                header("location: ../student.php");
                exit();
            } else {
                $_SESSION["error"] = "Student not Deleted.";
                header("location: ../student.php");
                exit();
            }
        } else {
            $_SESSION["error"] = "Something went wrong.";
            header("location: ../student.php");
            exit();
        }
    }


    if (isset($_GET["teacherId"])) {
        $id = $_GET["teacherId"];
        echo "Teacher Id : " . $id;
        $query = "SELECT profileImage,certificate FROM $dbName.$teacherTable WHERE teacherId = '$id'";
        $result = mysqli_query($conn, $query);


        if (mysqli_num_rows($result) > 0) {
            $userData = mysqli_fetch_array($result);
            $query = "DELETE FROM $dbName.$teacherTable WHERE teacherId = '$id'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                unlink($teacherFolder . $userData["profileImage"]);
                unlink($teacherFolder . $userData["certificate"]);
                $_SESSION["success"] = "Teacher Deleted Successfully.";
                header("location: ../teacher.php");
                exit();
            } else {
                $_SESSION["error"] = "Teacher not Deleted.";
                header("location: ../teacher.php");
                exit();
            }
        } else {
            $_SESSION["error"] = "Something went wrong.";
            header("location: ../teacher.php");
            exit();
        }
    }


    if (isset($_GET["notificationId"])) {
        $id = $_GET["notificationId"];

        $data = $helper->deleteNotification('id', $id, $conn, $dbName, $notification);
        header("location: ../index.php");
        exit();
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'download') {
    $teacherId = $_GET['teacherId']; // Get the file ID from the URL

    // Fetch the file information from the database
    $query = "SELECT * FROM $dbName.$teacherTable WHERE teacherId = '$teacherId'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $fileName = $row['certificate'];

        // Construct the full file path
        $filePath = $teacherFolder . $fileName;

        echo $filePath;

        // Check if the file exists
        if (file_exists($filePath)) {
            // Set headers to force download
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf'); // Change this if you are serving other file types
            header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            flush(); // Flush system output buffer
            readfile($filePath); // Read the file

            exit();
        } else {
            echo "File does not exist.";
        }
    } else {
        echo "No file found with the given ID.";
    }
}




// if(isset($_SERVER['REQUEST_METHOD']) === 'GET'){
//     if(isset($_POST['action'])){
//         switch($_POST['action']){
//             case 'getUsers':

//         }
//     }
// }

// ================================  Chat System ==================

// if(isset($_SERVER['REQUEST_METHOD']) === 'POST'){
//     if(isset($_POST['action'])){
//         switch($_POST['action']){
//             case 'sendMessage':
//                 $userId = $_POST['userId'];
//                 $senderId = $_POST['senderId'];
//                 $message = $_POST['message'];

//         }
//     }
// }
