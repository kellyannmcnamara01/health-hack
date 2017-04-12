<?php
/**
 * Created by PhpStorm.
 * User: bryanstephens
 * Date: 2017-04-05
 * Time: 12:18 PM
 */

// valid that image has no errors
function ImgCode($img){

    $file_error_code = $img;

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
            // if the file exceeds the max
            case 2:
                echo "File exceeded max_file_size";
                break;
            // if the file is only partially uploaded
            case 3:
                echo "File only partially uploaded.";
                break;
            // if no file is present
            case 4:
                echo "No file uploaded.";
                break;
        }
        // if a problem occurs, exit the function
        exit;
    }
    //if a success return true
    return true;
}

// valid size of image
function ImgSize($img){

    $file_size = $img;

    $max_file_size = 200000;
    if($file_size > $max_file_size)
    {
        echo "file size too big";
        exit;
    }

    //if a success return true
    return true;
}

// map the path of img
function ImgPath($img, $username){

    //require_once '../opt-imgs';
    $imgPath = $img;
    $user = $username;
    //set up target path
    $target_path = "opt-imgs/";

    // create path for image and move image there
    $path = $target_path . "user?" .  $user . "/profile-image?" . $imgPath;
    return $path;
}


