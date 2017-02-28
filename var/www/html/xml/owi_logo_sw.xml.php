<?php

    ini_set("session.use_cookies",0);
    ini_set("session.use_only_cookies", 0);
    session_id("snom");
    session_start();
    
    $_SESSION['snomd345_ip']=$_SERVER['REMOTE_ADDR'];
    
?>


<?xml version="1.0" encoding="UTF-8"?>
<SnomIPPhoneImageFile state="others_except_mb" dtmf="off" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" id="main" document_id="owi_logo_sw">
<LocationX>0</LocationX>
<LocationY>0</LocationY>
<URL>http://<?php echo $_SERVER['SERVER_ADDR'];?>/img/owi_logo_sw.bmp</URL>
<SoftKeyItem>
    <Name>F4</Name>
    <Label>VIDEO</Label>
    <URL>http://<?php echo $_SERVER['SERVER_ADDR'];?>/xml/cam_start_345.xml.php</URL>
</SoftKeyItem>
</SnomIPPhoneImageFile>
