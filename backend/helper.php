<?php
// include './table.php';


class Helper
{
    public function unique_id($size = 6, $type = "alphanumeric")
    {
        $alphanumericString = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0987654321";
        $numericString = "0987654321";
        $string =  $alphanumericString;
        $uniqueId = "";

        if ($type === "numeric") {
            $string =  $numericString;
        } else {
            $string = $alphanumericString;
        }

        for ($i = 0; $i < $size; $i++) {
            $uniqueId .= $string[mt_rand(0, strlen($string) - 1)];
        }

        return $uniqueId;
    }



    function getUsers($conn, $dbName, $table)
    {
        $query = "SELECT * FROM $dbName.$table";
        $data = mysqli_query($conn, $query);
        if (mysqli_num_rows($data) > 0) {
            return $data;
        } else {
            return null;
        }
    }


    function getUser($key, $value, $conn, $dbName, $table)
    {
        $query = "SELECT * FROM $dbName.$table WHERE $key = '$value'";
        $data = mysqli_query($conn, $query);
        if (mysqli_num_rows($data) > 0) {
            return $data;
        } else {
            return null;
        }
    }


    function getNotifications($conn, $dbName, $table)
    {
        $query = "SELECT * FROM $dbName.$table";
        $data = mysqli_query($conn, $query);

        if (mysqli_num_rows($data) > 0) {
            return $data;
        } else {
            return null;
        }
    }


    function deleteNotification($key, $value, $conn, $dbName, $table)
    {
        $query = "DELETE FROM $dbName.$table WHERE $key = $value";
        $data = mysqli_query($conn, $query);


        if ($data) {
            return $this->getNotifications($conn, $dbName, $table);
        } else {
            return null;
        }
    }
};
