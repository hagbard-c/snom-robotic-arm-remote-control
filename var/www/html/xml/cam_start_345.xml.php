<?php

    ini_set("session.use_cookies",0);
    ini_set("session.use_only_cookies", 0);
    session_id("snom");
    session_start();

    shell_exec('mjpg_streamer -i "/usr/local/lib/input_uvc.so -d /dev/video0 -r 320x240 -n" -o "/usr/local/lib/output_http.so -p 8080 -w /usr/local/www -n" > /dev/null 2>&1 &');
    $_SESSION['cam']['status'] = "on";

    shell_exec('curl http://' . $_SESSION['snomd345_ip'] . '/command.htm?number=' . $_SESSION['snomd765user']);

?>
<?xml version="1.0" encoding="UTF-8"?>
<SnomIPPhoneImageFile state="others_except_mb" dtmf="off" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" id="pre_video">
    <LocationX>00</LocationX>
    <LocationY>00</LocationY>
    <URL>http://<?php echo $_SERVER['SERVER_ADDR'];?>/img/owi_logo_sw.bmp</URL>
</SnomIPPhoneImageFile>

