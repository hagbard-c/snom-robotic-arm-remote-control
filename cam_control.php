<?php

    ini_set("session.use_cookies",0);
    ini_set("session.use_only_cookies", 0);
    session_id("snom");
    session_start();

    switch($_GET['action'])
    {
         case "cam_start":
            shell_exec('mjpg_streamer -i "/usr/local/lib/input_uvc.so -d /dev/video0 -r 320x240 -n" -o "/usr/local/lib/output_http.so -p 8080 -w /usr/local/www -n" > /dev/null 2>&1 &');
            $_SESSION['cam']['status'] = "on";
            break;

        case "cam_stop":
            shell_exec('killall -SIGINT mjpg_streamer');
            $_SESSION['cam']['status'] = "off";
            break;
    }

?>
