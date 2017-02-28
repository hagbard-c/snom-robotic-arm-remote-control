<?php

    ini_set("session.use_cookies",0);
    ini_set("session.use_only_cookies", 0);
    session_id("snom");
    session_start();

    shell_exec('killall -SIGINT mjpg_streamer');
    $_SESSION['cam']['status'] = "off";

    
    if (isset($_GET['snomd765user']))
    {
        $_SESSION['snomd765user']=$_GET['snomd765user'];
    }

    
    
?>
<?xml version="1.0" encoding="UTF-8"?>
<SnomIPPhoneImageFile state="others_except_mb" dtmf="off" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" id="main" document_id="10">
    <LocationX>00</LocationX>
    <LocationY>00</LocationY>
    <URL>http://<?php echo $_SERVER['SERVER_ADDR'];?>/img/snom_owi_logo.jpg</URL>
    <SoftKeyItem>
        <Name>F4</Name>
        <Label>VIDEO</Label>
        <URL>http://<?php echo $_SERVER['SERVER_ADDR'];?>/xml/cam_start.xml.php</URL>
    </SoftKeyItem>
</SnomIPPhoneImageFile>

