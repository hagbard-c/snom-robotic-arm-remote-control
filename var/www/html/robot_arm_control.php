<?php

ini_set("session.use_cookies",0);
ini_set("session.use_only_cookies", 0);
session_id("snom");
session_start();

class owi
{
    private function control_arm($cmd0,$cmd1,$cmd2)
    {
        if ($_SESSION['arm_status']['light'] == "on")
        {
            $cmd2 = "01";
        }

        system("/var/www/html/robot_arm $cmd0 $cmd1 $cmd2",$retval);

        if ($retval != 0)
        {
            echo "Error! OWI not available. $retval";
            $_SESSION['arm_status']['light'] = "off";
        }
    }

    public function grip_close()
    {
        $this->control_arm("01","00","00");
    }

    public function grip_open()
    {
        $this->control_arm("02","00","00");
    }

    public function wrist_up()
    {
        $this->control_arm("04","00","00");
    }

    public function wrist_down()
    {
        $this->control_arm("08","00","00");
    }

    public function elbow_up()
    {
        $this->control_arm("10","00","00");
    }

    public function elbow_down()
    {
        $this->control_arm("20","00","00");
    }

    public function shoulder_up()
    {
        $this->control_arm("40","00","00");
    }

    public function shoulder_down()
    {
        $this->control_arm("80","00","00");
    }

    public function rotate_base_clockwise()
    {
        $this->control_arm("00","01","00");
    }

    public function rotate_base_counter_clocwise()
    {
        $this->control_arm("00","02","00");
    }
    
    public function light_on()
    {
        $_SESSION['arm_status']['light'] = "on";
        $this->control_arm("00","00","01");
    }

    public function light_off()
    {
        $_SESSION['arm_status']['light'] = "off";
        $this->control_arm("00","00","00");
    }
    
    public function light_toggle()
    { 
        if ($_SESSION['arm_status']['light'] == "on")
        {
            $_SESSION['arm_status']['light'] = "off";
            $this->control_arm("00","00","00");
        }
        else
        {
            $_SESSION['arm_status']['light'] = "on";
            $this->control_arm("00","00","01");
        }
    }
    
    public function stop_all()
    {
        $_SESSION['arm_status']['light'] = "off";
        $this->control_arm("00","00","00");
    }
    
    public function stop_movment()
    {
        $this->control_arm("00","00","00");
    }
}


$MyOWI = new owi();

switch($_GET['action'])
{
    case "grip_close":
        $MyOWI->grip_close();
        break;
        
    case "grip_open":
        $MyOWI->grip_open();
        break;
        
    case "wrist_up":
        $MyOWI->wrist_up();
        break;
        
    case "wrist_down":
        $MyOWI->wrist_down();
        break;
    
    case "elbow_up":
        $MyOWI->elbow_up();
        break;
    
    case "elbow_down":
        $MyOWI->elbow_down();
        break;

    case "shoulder_up":
        $MyOWI->shoulder_up();
        break;
    
    case "shoulder_down":
        $MyOWI->shoulder_down();
        break;
        
    case "rotate_base_clockwise":
        $MyOWI->rotate_base_clockwise();
        break;
    
    case "rotate_base_counter_clocwise":
        $MyOWI->rotate_base_counter_clocwise();
        break;
        
    case "light_on":
        $MyOWI->light_on();
        break;
        
    case "light_off":
        $MyOWI->light_off();
        break;
        
    case "light_toggle":
        $MyOWI->light_toggle();
        break;
        
    case "stop_all":
        $MyOWI->stop_all();
        break;
        
    case "stop_movment":
        $MyOWI->stop_movment();
        break;
     
    default:
        $MyOWI->stop_all();
}
?>




