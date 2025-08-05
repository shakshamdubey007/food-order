<?php

//include constants.php file here
include('../config/constants.php');


//1.get the id of admin to be deleted
$id= $_GET['id'];

//2.create sql query to delete admin
$sql= "DELETE FROM tbl_admin WHERE id=$id";

//execute the query
$res = mysqli_query($conn,$sql);

//check the query executed successfully
if ($res==true)
    {
        $_SESSION['delete']="<div class='success'>Admin Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
else
{
   // echo "Failed to delete admin";
   $_SESSION['delete']= "<div class='error'>Failed To Delete Admin. Try Again.</div>";
   header('location:'.SITEURL.'admin/manage-admin.php');
}
//3. redirect to manage admin page with message(success/error)










?>