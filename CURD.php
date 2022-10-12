<?php

include'config.php';
<<<<<<< HEAD
include'config.php';
=======
include'edit_payment_details.php';
// zxcvbnm,
>>>>>>> trying-to-work-with-branch
if($_REQUEST['id'] )  //data Read or select
{
    if($_REQUEST['id'])
    $record_id = $_REQUEST['id'];
    else
    $record_id='';
    echo $sel="select * from resgistration where id='".$record_id."'";
    $ptr_query=mysql_query($sel);
    $data_query=mysql_fetch_array($ptr_query);
}
 

// hello github pulling
if($_POST['save'] )
{
    echo $name= $_POST['fullname'];
    echo $phone= $_POST['number'];
    echo $email= $_POST['email'];
    echo $password=$_POST['password'];
    echo $gender= $_POST['gender'];
    echo $checkbox= $_POST['checkbox'];
    echo $Ufile=$_POST['Ufile'];
    echo $query=$_POST['query'];

           
    $Ufile=$_FILES["Ufile"]["name"];  // uploading file (img)
    $tempname=$_FILES["Ufile"]["tmp_name"];
    $folder="uploads/" .$Ufile;
    move_uploaded_file($tempname,$folder);


    if($record_id)                   //data  edit or update
    {
         $update_rec="update resgistration set `fullname`='".$name."',`number`='".$phone."', `email`='".$email."',`password`='".$password."',`gender`='".$gender."',`checkbox`='".$checkbox."',`Ufile`='".$folder."', `query`='".$query."' where id='".$record_id."' ";
         $ptr_qry=mysql_query($update_rec);
    }
    else                              //data insert or create
    {    
         $insert_test="insert into resgistration(`fullname`, `number`, `email`, `password`, `gender`,`checkbox`,`Ufile`, `query`,`date`) values ('".$name."','".$phone."', '".$email."', '".$password."',  '".$gender."', '".$checkbox."', '".$folder."', '".$query."', CURRENT_TIMESTAMP)";
         $ptr_quesry=mysql_query($insert_test);
    }
                
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS ------->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style2.css">
    <script src="register.js"></script>
    <title> Student Registration Form</title>
</head>

<body class="bg-dark text-light">
    <h2 style="text-align: center;"> Student Registration Form</h2>
    <!-- form enctype="multipart/form-data"  ------->

    <form action="" name="form" method="post" enctype="multipart/form-data" onsubmit=" return valid()"
        class=" mx-auto mt-3" style="width:650px">
        <div class="form-group mt-3 ">
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" class="form-control" value="<?php echo $data_query['fullname']; ?>"
                id="fullN" Required placeholder="Enter your full  name">
            <b><span id="fullname" class="text-danger"> </span></b>

        </div>
        <div class="form-group mt-3">
            <label for="number">Contact Number</label>
            <input type="number" name="number" class="form-control" value="<?php echo $data_query['number']; ?>"
                id="number" placeholder="Enter your contact number">
            <b><span id="num" class="text-danger"> </span></b>
        </div>

        <div class="form-group mt-3">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" name="email" class="form-control" value="<?php echo $data_query['email']; ?>" id="email"
                aria-describedby="emailHelp" placeholder="Enter email">
            <b><span id="mail" class="text-danger"> </span></b>
        </div>
        <div class="form-group mt-3">
            <label for="exampleInputEmail1">Password</label>
            <input type="password" name="password" class="form-control" value="<?php echo $data_query['password']; ?>" id="password"
               placeholder="Enter Password">
            <b><span id="mail" class="text-danger"> </span></b>
        </div>
        <div class="btn-group btn-group-toggle mt-3" data-toggle="buttons">
            <label for="gender"> Gender :--</label>
            <label class="btn btn-secondary active">
                <input type="radio" name="gender" value="female" <?php if($data_query['gender']=='female' )
                    {echo"checked";}?>> Female
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="gender" value="male" <?php if($data_query['gender']=='male' )
                    {echo"checked";}?>> Male
            </label>
            <label class="btn btn-secondary">
                <input type="radio" name="gender" value="other" <?php if($data_query['gender']=='other' )
                    {echo"checked";}?>> Other
            </label>
        </div>

        <div class="form-row align-items-center mt-3">
            <div class="col-auto my-1">
                <label class="mr-sm-2" for="checkbox">Select Education</label>
                <select class="custom-select mr-sm-2" name="checkbox" id="inlineFormCustomSelect">
                    <option name="checkbox" selected disabled>Courses</option>
                    <option name="checkbox" <?php if($data_query['checkbox']=='Master of Business Administration' )
                        {echo"selected";}?> value="Master of Business Administration" >Master of Business Administration
                    </option>
                    <option name="checkbox" value="Engineering" <?php if($data_query['checkbox']=='Engineering' )
                        {echo"selected";}?>>Engineering</option>
                    <option name="checkbox" value="Fashion Designing" <?php
                        if($data_query['checkbox']=='Fashion Designing' ) {echo"selected";}?> >Fashion Designing
                    </option>
                    <option name="checkbox" value="Accounts & Finance" <?php
                        if($data_query['checkbox']=='Accounts & Finance' ) {echo"selected";}?>>Accounts & Finance
                    </option>
                    <option name="checkbox" value="Computer application" <?php
                        if($data_query['checkbox']=='Computer application' ) {echo"selected";}?>>Computer application
                    </option>
                </select>
            </div>
            <!--for="exampleFormControlFile1" -->

            <div class="form-group mt-3">
                <label>Upload Photo:</label>
                <input type="file" name="Ufile" class="form-control-file" id="uFile">
                <span>
                    <?php echo $data_query['Ufile'];?>
                </span>
                <b><span id="file" class="text-danger"> </span></b>

            </div>

            <div class="form-group mt-3">
                <label for="Query"> Query</label>
                <textarea name="query" class="form-control" id="text1" rows="4" placeholder="Write Your Query Here">
                <?php echo $data_query['query']; ?>
                </textarea>
                <b><span id="query" class="text-danger"> </span></b>
            </div>
            <small id="emailHelp" class="form-text text-muted">We ll never share your details with anyone</small>
            <center><input type="submit" name="save" class="  btn btn-success btn-lg btn-block mt-3" value="Submit">
            </center>

        </div>

    </form>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>
<!--    after body section adding comment line for github test -->

</html>
