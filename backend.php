<?php

$conn = mysqli_connect('localhost', 'root', 'root', 'crud');

extract($_POST);
if(isset($_POST['readRecord'])){
    $data = '<table class="table table-bordered table-striped">
                <tr>
                    <th>No.</th>  
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Image</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>';

        $displayQuery = "SELECT * FROM `crudtable`";
        $result = mysqli_query($conn, $displayQuery);
        
        if(mysqli_num_rows($result) > 0){
            $number = 1;
            while($row = mysqli_fetch_array($result)){
                $data .= '<tr>
                            <td>'.$number.'</td>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['mobile'].'</td>
                            <td>'.$row['email'].'</td>
                            <td>'.$row['age'].'</td>
                            <td><img src=uploads/'.$row["upload"].' height="50px" width="50px"></td>
                            <td><button onclick="GetUserDetails('.$row['id'].')" class="btn btn-warning">Update</button></td>
                            <td><button onclick="DeleteUser('.$row['id'].')" class="btn btn-danger">Delete</button></td>
                        </tr>';
                $number++;
            }
        }
        $data .='</table>';
        echo $data;
}

if(isset($_POST['name']) && isset($_POST['mobile']) && isset($_POST['email']) && isset($_POST['age']) && isset($_FILES['photo']))
{
    $photo = $_FILES['photo']['name'];
    $new_name = rand() . '_' . $photo;
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $filepath = 'uploads/'.$new_name;
    move_uploaded_file($photo_tmp, $filepath);
    $query = "INSERT INTO `crudtable`(`name`, `mobile`, `email`, `age`, `upload`) VALUES ( '$name','$mobile','$email','$age','$new_name')";    
    if(mysqli_query($conn, $query)){
        echo 'Data Inserted';
        print_r($query);
    }else{
        echo 'Data Not Inserted';
        print_r($query);
    }
}

if(isset($_POST['deleteid'])){
    $deleteid = $_POST['deleteid'];
    $imgquery = "select upload FROM `crudtable` WHERE id = '$deleteid'";
    $result = mysqli_query($conn, $imgquery);
    unlink('uploads/'.mysqli_fetch_array($result)['upload']);
    $delquery = "DELETE FROM `crudtable` WHERE id = $deleteid";
    mysqli_query($conn, $delquery);
}

if(isset($_POST['id']) && isset($_POST['id']) !=''){
    $user_id = $_POST['id'];
    $editquery = "SELECT * FROM `crudtable` WHERE id = $user_id";
    if(!$result = mysqli_query($conn, $editquery)){
        exit(mysqli_error($conn));
    }

    $response = array();
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $response = $row;
        }
    }
    else{
        $response['status'] = 200;
        $response['message'] = "Data not found!";
    }
    echo json_encode($response);

}
else{
        $response['status'] = 200;
        $response['message'] = "Invalid Request!";
}



if(isset($_POST['updatehidden_user_id'])){
    $hidden_user_idupdate = $_POST['updatehidden_user_id'];
    $nameupdate = $_POST['updatename'];
    $mobileupdate = $_POST['updatemobile'];
    $emailupdate = $_POST['updateemail'];
    $ageupdate = $_POST['updateage'];

    if($_FILES['updatephoto'] != null ){
        $query = "SELECT upload FROM `crudtable` WHERE id = $hidden_user_idupdate";
        $result = mysqli_query($conn, $query);
        unlink('uploads/'.mysqli_fetch_array($result)['upload']);

        $photo = $_FILES['updatephoto']['name'];
        $new_name = rand() . '_' . $photo;
        $photo_tmp = $_FILES['updatephoto']['tmp_name'];
        $filepath = 'uploads/'.$new_name;
        move_uploaded_file($photo_tmp, $filepath);
        $query = "UPDATE `crudtable` SET `name`='$nameupdate',`mobile`='$mobileupdate',`email`='$emailupdate',`age`='$ageupdate',`upload`='$new_name' WHERE id = $hidden_user_idupdate";
        mysqli_query($conn, $query);
    }
    else
    {
        $query = "UPDATE `crudtable` SET `name`='$nameupdate',`mobile`='$mobileupdate',`email`='$emailupdate',`age`='$ageupdate' WHERE id = $hidden_user_idupdate";
        mysqli_query($conn, $query);
    }

}



?>