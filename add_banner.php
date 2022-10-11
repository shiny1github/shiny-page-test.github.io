<?php include 'inc_classes.php';?>
<?php include "admin_authentication.php";?>
<?php include "../classes/thumbnail_images.class.php";?>
<?php
if($_REQUEST['record_id'])
{
    $record_id=$_REQUEST['record_id'];
    $sql_record= "SELECT * FROM PB_banner where banner_id='".$record_id."'";
    if(mysql_num_rows($db->query($sql_record)))
        $row_record=$db->fetch_array($db->query($sql_record));
    else
        $record_id=0;
}
if($record_id && $_REQUEST['deleteThumbnail'])
{
    $update_news="update PB_banner set image_url='' where banner_id='".$record_id."'";
    //echo $update_events;
    $db->query($update_news);

    if($row_record['image_url'] && file_exists("../UserData/".$row_record['image_url']))
        unlink("../UploadedData/".$row_record['image_url']);
    $row_record=$db->fetch_array($db->query($sql_record));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($record_id) echo "Edit"; else echo "Add";?> Banner</title>
<?php include "include/headHeader.php";?>
<?php include "include/functions.php"; ?>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>
<!--    <script type='text/javascript' src='js/jquery-1.6.2.min.js'></script>-->
    <script src="js/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        jQuery(document).ready( function() 
        {
            // binds form submission and fields to the validation engine
            jQuery("#jqueryForm").validationEngine('attach', {promptPosition : "topLeft"});
        });
        function limitText(limitField, limitCount, limitNum) 
        {
            if (limitField.value.length > limitNum) 
            {
                limitField.value = limitField.value.substring(0, limitNum);
            } 
            else 
            {
                limitCount.value = limitNum - limitField.value.length;
            }
        }
    </script>
    
<!--        <script src="../js/jquery.custom/development-bundle/jquery-1.4.2.js"></script>-->
    <link rel="stylesheet" href="js/development-bundle/demos/demos.css"/>
    <script src="js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript">
    $(document).ready(function()
        {            
            $('.datepicker').datepicker({ changeMonth: true,changeYear: true, showButtonPanel: true, closeText: 'Clear'});
            $.datepicker._generateHTML_Old = $.datepicker._generateHTML; $.datepicker._generateHTML = function(inst)
            {
                res = this._generateHTML_Old(inst); res = res.replace("_hideDatepicker()","_clearDate('#"+inst.id+"')"); return res;
            }
        });
    </script>
</head>
<body>
<?php include "include/header.php";?>
<!--info start-->
<div id="info">
<!--left start-->
<?php include "include/menuLeft.php"; ?>
<!--left end-->
<!--right start-->
<div id="right_info">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="top_left"></td>
    <td class="top_mid" valign="bottom"><?php include "include/banner_menu.php"; ?></td>
    <td class="top_right"></td>
  </tr>
  <tr>
    <td class="mid_left"></td>
    <td class="mid_mid">
        <table width="100%" cellspacing="0" cellpadding="0">            
        <?php
                        $errors=array(); $i=0;
                        $success=0;
                        if($_POST['save_changes'])
                        {
                            $name=$_POST['name'];
                            $description=$_POST['description'];
//                            $designation=$_POST['designation'];
                            
                            if($name=="")
                            {
                                    $success=0;
                                    $errors[$i++]="Enter name ";
                            }                            
                           
                            $uploaded_url="";
                            if(count($errors)==0 && $_FILES['image_url']["name"])
                            {
                                if($record_id)
                                {
                                    $update_news="update PB_expert_speak set image_url='' where expert_speak_id='".$record_id."'";
                                    $db->query($update_news);

                                    if($row_record['image_url'] && file_exists("../UploadedData/".$row_record['image_url']))
                                        unlink("../UploadedData/".$row_record['image_url']);
                                    if($row_record['image_url'] && file_exists("../UploadedData/".$row_record['image_url']))
                                        unlink("../UploadedData/".$row_record['image_url']);
                                }
                                $uploaded_url=time().basename($_FILES['image_url']["name"]);
                                $newfile = "../UploadedData/";

                                $filename = $_FILES['image_url']['tmp_name']; // File being uploaded.
                                $filetype = $_FILES['image_url']['type'];// type of file being uploaded
                                $filesize = filesize($filename); // File size of the file being uploaded.
                                $source1 = $_FILES['image_url']['tmp_name'];
                                $target_path1 = $newfile.$uploaded_url;

                                list($width1, $height1, $type1, $attr1) = getimagesize($source1);
                                if(strtolower($filetype) == "image/jpeg" || strtolower($filetype) == "image/pjpeg" || strtolower($filetype) == "image/GIF" || strtolower($filetype) == "image/gif" || strtolower($filetype) == "image/png")
                                {
                                    
                                    if(move_uploaded_file($source1, $target_path1))
                                    {
                                        $thump_target_path="../UploadedData/".$uploaded_url;
                                        copy($target_path1,$thump_target_path);

                                        list($width, $height, $type, $attr) = getimagesize($thump_target_path);
                                        //echo $width.$height;
                                        if($width<=446 && $height<=248)
                                        {
                                            $file_uploaded=1;
                                        }
                                        else
                                        {
                                            //------------resize the image----------------
                                            $obj_img1 = new thumbnail_images();
                                            $obj_img1->PathImgOld = $thump_target_path;
                                            $obj_img1->PathImgNew = $thump_target_path;
                                            $obj_img1->NewWidth = 446;
                                            $obj_img1->NewHeight = 248;
                                            if (!$obj_img1->create_thumbnail_images())
                                            {
                                                $file_uploaded=0;
                                                unlink($target_path1);
                                                $success=0;
                                                $errors[$i++]="There are some errors while uploading image, please try again";
                                            }
                                            else
                                            {
                                                $file_uploaded=1;
                                               /* list($width, $height, $type, $attr) = getimagesize($thump_target_path);
                                                //echo $width.$height;
                                                if($height>100)
                                                {
                                                    //------------resize the image----------------
                                                    $obj_img1 = new thumbnail_images();
                                                    $obj_img1->PathImgOld = $thump_target_path;
                                                    $obj_img1->PathImgNew = $thump_target_path;
                                                    $obj_img1->NewHeight = 100;
                                                    if (!$obj_img1->create_thumbnail_images())
                                                    {
                                                        $file_uploaded=0;
                                                        unlink($target_path1);
                                                        $uploaded_url="";
                                                    }                                                    
                                                }
                                                */
                                            }
                                        }
                                    }
                                    else
                                    {
                                        $file_uploaded=0;
                                        $success=0;
                                        $errors[$i++]="There are some errors while uploading image, please try again";
                                    }
                                }
                                else
                                {
                                    $file_uploaded=0;
                                    $success=0;
                                    $errors[$i++]="Location image: Only image files allowed";
                                }
                            }
                            if(count($errors))
                            {
                                ?>
                            <tr><td> <br></br>
                                <table align="left" style="text-align:left;" class="alert">
                                <tr><td ><strong>Please correct the following errors</strong><ul>
                                        <?php
                                        for($k=0;$k<count($errors);$k++)
                                                echo '<li style="text-align:left;padding-top:5px;" class="green_head_font">'.$errors[$k].'</li>';?>
                                        </ul>
                                </td></tr>
                                </table>
                            </td></tr>   <br></br>  
                                <?php
                            }
                            else
                            {
                                $success=1;
                                $data_record['title'] =$name;
                                $data_record['description'] =$description; 
//                                $data_record['designation'] = $designation;
                                
                                if($file_uploaded)
                                    $data_record['image_url'] = $uploaded_url;

                               if($record_id)
                                {
                                    $where_record=" banner_id='".$record_id."'";
                                    $db->query_update("banner", $data_record,$where_record);
                                    echo '<br></br><div id="msgbox" style="width:40%;">Record updated successfully</center></div><br></br>';
                                }
                                else
                                {
                                    $data_record['added_date'] =date("Y-m-d H:i:s");
                                    $record_id=$db->query_insert("banner", $data_record);
                                    echo ' <br></br><div id="msgbox" style="width:40%;">Record added successfully</center></div> <br></br>';
                                }
                            }
                        }
                        if($success==0)
                        {
                        
                        ?>
            <tr><td>
        <form method="post" id="jqueryForm" enctype="multipart/form-data">
	<table border="0" cellspacing="15" cellpadding="0" width="100%">
              <tr>
                <td colspan="3" class="orange_font">* Mandatory Fields</td>
                </tr>
              <tr>
                  <td width="20%" valign="top">Title<span class="orange_font">*</span></td>
                <td width="40%"><input type="text"  class="validate[required] input_text" name="name" id="name" value="<?php if($_POST['save_changes']) echo $_POST['name']; else echo $row_record['title'];?>" /></td> 
                <td width="40%"></td>
              </tr>
              <tr>
                  <td width="20%" valign="top">Description<span class="orange_font">*</span></td>
                <td width="40%"><textarea type="text" class="validate[required] input_textarea" name="description" id="description" rows="5"><?php if($_POST['save_changes']) echo $_POST['description']; else echo $row_record['description'];?></textarea></td> 
                <td width="40%"></td>
              </tr>
<!--             <tr>
                  <td width="20%" valign="top"> Designation</td>
                <td width="40%"><input type="text"  class="input_text" name="designation" id="designation" value="<?php if($_POST['save_changes']) echo $_POST['designation']; else echo $row_record['designation'];?>" /></td> 
                <td width="40%"></td>
              </tr>-->
              <tr>
                    <td width="20%" valign="top">Image<span class="orange_font">*</span></td>
                    <td width="40%"><?php
                    if($record_id && $row_record['image_url'] && file_exists("../UploadedData/".$row_record['image_url']))
                        echo '<img height="77px" width="77px" src="../UploadedData/'.$row_record['image_url'].'"><br><a href="'.$_SERVER['PHP_SELF'].'?deleteThumbnail=1&record_id='.$record_id.'">Delete / Upload new</a></td><td width="40%"></td>';
                    else
                        echo '<input type="file" name="image_url" id="image_url" class="validate[required] input_text"></td>';?>
                    </td>
                    <td></td>
              </tr>              
              <tr>
                  <td>&nbsp;</td>
                  <td><input type="submit" class="input_btn" value="<?php if($record_id) echo "Update"; else echo "Add";?> Banner" name="save_changes"  /></td>
                  <td></td>
              </tr>
        </table>
        </form>
        </td></tr>
<?php
                        } ?>
	 
        </table></td>
    <td class="mid_right"></td>
  </tr>
  <tr>
    <td class="bottom_left"></td>
    <td class="bottom_mid"></td>
    <td class="bottom_right"></td>
  </tr>
</table>

</div>
<!--right end-->

</div>
<!--info end-->
<div class="clearit"></div>
<!--footer start-->
<div id="footer"><? require("include/footer.php");?></div>
<!--footer end-->
</body>
</html>
<?php $db->close();?>