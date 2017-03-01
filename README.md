# snom robotic arm remote control

## Introduction
 test

## How it works
test

## Table of content
test

## Used hardware
* [Raspberry Pi 2](https://www.raspberrypi.org/products/raspberry-pi-2-model-b/)
* [OWI-535 Robotic Arm Edge with USB interface](https://www.owirobot.com/robotic-arm-edge-1/)
* Microsoft LifeCam NX-6000
* [snomD345](https://www.snom.com/telephones/desk-telephones/300-series/snom-345-desk-telephone/)
* [snomD765](https://www.snom.com/telephones/desk-telephones/global-700-series-blackline/d765/)

## Setup
### OS
For this project i used an Raspberry Pi 2 but the steps shoud be more or less the same on all Debianbased distributions.

If u use an Raspberry Pi i recommend to install the latest version of [Raspbian Lite](https://www.raspberrypi.org/downloads/raspbian/).

No special steps are needed, just follow the [installation instruction](https://www.raspberrypi.org/documentation/installation/installing-images/).

### Udev rule
Normaly when u connect the OWI robotic arm via USB, normal users dont have the rights to write to that device.

To prevent the usage of sudo everytime u want to control the robotic arm u can apply an [owi.rules](etc/udev/rules.d/owi.rules).

Just copy the ```owi.rules``` to ```/etc/udev/rules.d```.


### Web server
To deliver the xml/php-files to the phone we need a web server with php. I use [lighttpd](https://www.lighttpd.net/) because its small an fast but for sure u can use [Apache](https://httpd.apache.org/) or [nginx](https://nginx.org) if u want.

Install lighttpd + php and reload lighttpd:
```Shell
$ sudo apt-get install lighttpd php5-cgi
$ sudo /etc/init.d/lighttpd force-reload
```

### Compile the OWI Robotic Arm Edge USB-commandline tool
First install an c-compiler and some dependencies:
```Shell
$ sudo apt-get install build-essential libusb-1.0-0 libusb-1.0-0-dev pkg-config
```
Now it can be compiled:
```Shell
$ cd src/
$ gcc -v -Wall robot_arm.c `pkg-config --libs --cflags libusb-1.0` -o robot_arm
```
After that u have an executible "robot_arm" in your directory.
Connect now the OWI robotic arm and do a first test.

Swich the light of the robot on:
```Shell
./robot_arm 00 00 01
```
and off:
```Shell
./robot_arm 00 00 00
```

If u got a message like ```Permission denied``` make sure u applied the udev rule.

## Usage
test
