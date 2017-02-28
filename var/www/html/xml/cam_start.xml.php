<?php

    ini_set("session.use_cookies",0);
    ini_set("session.use_only_cookies", 0);
    session_id("snom");
    session_start();

    if ($_SESSION['cam']['status'] != "on")
    {
            shell_exec('mjpg_streamer -i "/usr/local/lib/input_uvc.so -d /dev/video0 -r 320x240 -n" -o "/usr/local/lib/output_http.so -p 8080 -w /usr/local/www -n" > /dev/null 2>&1 &');
            $_SESSION['cam']['status'] = "on"; 
            $fetch_time=5000;
    }
    else
    {
        $fetch_time=10;
    }

?>

<?xml version="1.0" encoding="UTF-8"?>
<SnomIPPhoneImageFile state="others_except_mb" dtmf="off" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" id="pre_video">
    <LocationX>00</LocationX>
    <LocationY>00</LocationY>
    <URL>http://<?php echo $_SERVER['SERVER_ADDR'];?>/img/snom_owi_logo.jpg</URL>
    <fetch mil="<?php echo $fetch_time;?>">http://<?php echo $_SERVER['SERVER_ADDR'];?>/xml/video.xml.php</fetch>
</SnomIPPhoneImageFile>

