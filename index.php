<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <title>CRUD</title>
</head>

<body>
    <div class="container">
        <h1 class="text-primary text-center"> PHP JQUERY TASK</h1>
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">
                Open modal
              </button>
        </div>
        <h2 class="text-danger"> ALL RECORDS</h2>
        <div id="records_contant"></div>

        <!-- The Modal -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Enter Details</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile Number:</label>
                            <input type="number" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number">
                        </div>
                        <div class="form-group">
                            <label for="email">Email ID:</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email Id">
                        </div>
                        <div class="form-group">
                            <label for="age">Age:</label>
                            <input type="date" name="age" id="age" class="form-control" placeholder="Age">
                        </div>
                        <div class="form-group">
                            <label for="upload">image Upload:</label>
                            <input type="file" name="upload_file" id="upload_file" class="form-control" placeholder="File">
                        </div>
                    </div>

                    <!-- Modal footer -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="addRecord()">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Update -->
        <div class="modal" id="update_user_modal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Enter Details</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="update_name">Name:</label>
                            <input type="text" name="name" id="update_name" class="form-control" placeholder="Name">
                            <h5 id=""></h5>
                        </div>
                        <div class="form-group">
                            <label for="update_mobile">Mobile Number:</label>
                            <input type="number" name="mobile" id="update_mobile" class="form-control" placeholder="Mobile Number">
                        </div>
                        <div class="form-group">
                            <label for="update_email">Email ID:</label>
                            <input type="email" name="email" id="update_email" class="form-control" placeholder="Email Id">
                        </div>
                        <div class="form-group">
                            <label for="update_age">Age:</label>
                            <input type="date" name="age" id="update_age" class="form-control" placeholder="Age">
                        </div>
                        <div class="form-group">
                            <label for="update_upload">image Upload:</label>
                            <input type="file" name="upload_file" id="update_upload_file" class="form-control" placeholder="File">
                        </div>
                    </div>

                    <!-- Modal footer -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="updateUserDetails()">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <input type="hidden" name="" id="hidden_user_id">
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script type="text/javascript">

        $(document).ready(function() {
            readRecords();
        });


        function readRecords(){
            var readRecord = "readRecord";
            $.ajax({
                url:"backend.php",
                type:"post",
                data:{readRecord:readRecord},
                success:function(data, status){
                    $('#records_contant').html(data);
                }
            });
        }


        function addRecord(){
            var name = $('#name').val();
            var mobile = $('#mobile').val();
            var email = $('#email').val();
            var age = $('#age').val();
            var photo = $('#upload_file')[0].files[0];

            //Get Age Data
            var ageCheck = age.split('-');
            var year = ageCheck[0];
            var month = ageCheck[1];
            var day = ageCheck[2];
            //get current date
            var today = new Date();
            var nowyear = today.getFullYear();
            var nowmonth = today.getMonth();
            var nowday = today.getDate();
            //get age in months days year
            var getYear = nowyear - year;
            var getMonth = nowmonth - month;
            var getDay = nowday - day;
            //check if its less than 18 or greater than 90
            if(getYear < 18){
                alert('Age should be greater than 18');
                return false;
            }
            else if(getYear > 90){
                alert('Age should be less than 90');
                return false;
            }

            var date = getYear + 'years' + getMonth + 'months' + getDay + 'days old';

            const form_data = new FormData();
            form_data.append("name",name);
            form_data.append("mobile",mobile);
            form_data.append("email",email);
            form_data.append("age",date);
            form_data.append("photo",photo);

            if(name === ''){
                alert('Enter Name');
                return false;
            }else if(mobile === '')
            {
                alert('Enter Mobile Number');
                return false;
            }else if(email === '')
            {
                alert('Enter Email');
                return false;
            }
            if(mobile.length != 10 || mobile.charAt(0) == '0' || mobile.charAt(0) == '1' || mobile.charAt(0) == '2' || mobile.charAt(0) == '3' || mobile.charAt(0) == '4'){
                alert('Enter 10 digit Valid Mobile Number');
                return false;
            }
            if(email.indexOf('@') == -1 || email.indexOf('.') == -1){
                alert('Enter Valid Email');
                return false;
            }
            if(age === ''){
                alert('Enter Age');
                return false;
            }
            var regEx = /^[0-9a-zA-Z]+$/;
            if(!name.match(regEx)){
            alert("Please enter alphanumberic only.");
            return false;
            }

            fileName = document.querySelector('#upload_file').value;
            var extension = fileName.split('.').pop();
            if(extension !== 'jpg' && extension !== 'png' && extension !== 'jpeg'){
                alert('Please select an image file of type jpg or png');
                return false;
            }
            $.ajax({
                url: 'backend.php',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false, 
                data: form_data,
                beforeSend: function(){
                    console.log('sending...');
                },
                success: function(data, status) {
                    readRecords();
                },
            });
        }



        function DeleteUser(deleteid){
            var conf = confirm("Are you sure?");
            if(conf == true){
                $.ajax({
                    url:"backend.php",
                    type:"post",
                    data:{deleteid:deleteid},
                    success:function(data, status){
                        readRecords();
                    }
                });
            }
        }

        function GetUserDetails(id){
            $('#hidden_user_id').val(id);

            $.post("backend.php", {
                id: id
            }, function(data, status){
                var user = JSON.parse(data);
                $('#update_name').val(user.name);
                $('#update_mobile').val(user.mobile);
                $('#update_email').val(user.email);
                $('#update_age').val(user.age);
            }
            );
            $('#update_user_modal').modal('show');
        }

        function updateUserDetails(){
            var updatename = $('#update_name').val();
            var updatemobile = $('#update_mobile').val();
            var updateemail = $('#update_email').val();
            var updateage = $('#update_age').val();
            var updatephoto = $('#update_upload_file')[0].files[0];
            var updatehidden_user_id = $('#hidden_user_id').val();


            //Get Age Data
            var ageCheck = updateage.split('-');
            var year = ageCheck[0];
            var month = ageCheck[1];
            var day = ageCheck[2];
            //get current date
            var today = new Date();
            var nowyear = today.getFullYear();
            var nowmonth = today.getMonth();
            var nowday = today.getDate();
            //get age in months days year
            var getYear = nowyear - year;
            var getMonth = nowmonth - month;
            var getDay = nowday - day;
            //check if its less than 18 or greater than 90
            if(getYear < 18 || getYear > 90){
                alert('Age should be greater than 18 and less than 90');
                return false;
            }

            var updatedate = getYear + 'years-' + getMonth + 'months' + getDay + 'days old';

            const form_data = new FormData();
            form_data.append("updatename",updatename);
            form_data.append("updatemobile",updatemobile);
            form_data.append("updateemail",updateemail);
            form_data.append("updateage",updatedate);
            form_data.append("updatephoto",updatephoto);
            form_data.append("updatehidden_user_id",updatehidden_user_id);

            if(updatename === ''){
                alert('Enter Name');
                return false;
            }else if(updatemobile === '')
            {
                alert('Enter Mobile Number');
                return false;
            }else if(updateemail === '')
            {
                alert('Enter Email');
                return false;
            }

            if(updatemobile.length != 10 || updatemobile.charAt(0) == '0' || updatemobile.charAt(0) == '1' || updatemobile.charAt(0) == '2' || updatemobile.charAt(0) == '3' || updatemobile.charAt(0) == '4'){
                alert('Enter 10 digit Valid Mobile Number');
                return false;
            }

            if(updateemail.indexOf('@') == -1 || updateemail.indexOf('.') == -1){
                alert('Enter Valid Email');
                return false;
            }

            var regEx = /^[0-9a-zA-Z]+$/;
            if(!updatename.match(regEx)){
            alert("Please enter alphanumberic only.");
            return false;
            }
            
                uploadfileName = document.querySelector('#update_upload_file').value;
                if(uploadfileName !== ''){
                var uploadextension = uploadfileName.split('.').pop();
                if(uploadextension !== 'jpg' && uploadextension !== 'png' && uploadextension !== 'jpeg'){
                alert('Please select an image file of type jpg or png');
                return false;
                }}
            
            $.ajax({
                url: 'backend.php',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false, 
                data: form_data,
                beforeSend: function(){
                    console.log('sending...');
                },
                success: function(data, status) {
                    readRecords();
                },
            });
        }
    </script>

</body>

</html>