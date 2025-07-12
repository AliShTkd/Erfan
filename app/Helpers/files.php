<?php
/*
 * All helpers function for files and media
 */

//get file type
function helper_core_files_get_type($extension=null) :string
{
    $extension = strtolower($extension);

    if (in_array($extension,['png','svg','jpg','jpeg'])) {
        return 'image';
    }

    if (in_array($extension,['mp4','avi','mkv','mpeg','fly','webm','mov'])) {
        return 'video';
    }

    if (in_array($extension,['mp3','wav','wma','aac'])) {
        return 'audio';
    }

    if (in_array($extension,['zip','rar','7zip','tar','gz','tar.gz','zipx','zz'])) {
        return 'archive';
    }

    if (in_array($extension,['txt','pdf','doc','docx','rtf','wps'])) {
        return 'text';
    }

    if (in_array($extension,['xlsx','xlsm','xltx','xltm','ppt','pot','pps','ppa','accda','accdb','accde','one','ecf','pub'])) {
        return 'office';
    }

    return 'unknown';

}

//get file name explode with "/"
function helper_core_files_get_file_name($path) :string
{
    $explode = explode('/',$path);
    return end($explode);


}
