<?php
/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Date: 2017-04-05
 * Time: 12:18 PM
 */
function ProfileImg($img){

    $file_name = $img . ['name'];
    $file_size = $img . ['size'];
    $file_error_code = $img . ['error'];

    // if there is a problem, inform user of error
    if ($file_error_code > 0)
    {
        echo "Problem";
        switch ($file_error_code)
        {
            // if the file exceeds the max upload size
            case 1:
                echo "File exceeded upload_max_filesize.";
                break;
            // if
            case 2:
                echo "File exceeded max_file_size";
                break;
            case 3:
                echo "File only partially uploaded.";
                break;
            case 4:
                echo "No file uploaded.";
                break;
        }
        // if a problem occurs, exit the function
        exit;
    }

    $max_file_size = 200000;
    if($file_size > $max_file_size)
    {
        echo "file size too big";
        exit;
    }

    // if no errors occur, save image within ProfileImages directory
    $target_path =  "Dashboard/ProfileImages/";
    return  $target_path .  $file_name;

}
