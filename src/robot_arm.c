/*

    OWI Robotic Arm Edge USB protocol
    Copyright (C) 2010  Vadim Zaliva

        * http://notbrainsurgery.livejournal.com/38622.html
        * http://www.crocodile.org/lord/

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

#include <stdlib.h>
#include <stdio.h>
#include <sys/types.h>
#include <string.h>
#include <libusb-1.0/libusb.h>

#define EP_INTR	(1 | LIBUSB_ENDPOINT_IN)
#define ARM_VENDOR       0x1267
#define ARM_PRODUCT      0
#define CMD_DATALEN      3

libusb_device * find_arm(libusb_device **devs)
{
    libusb_device *dev;
    int i = 0;

    while ((dev = devs[i++]) != NULL)
    {
        struct libusb_device_descriptor desc;
        int r = libusb_get_device_descriptor(dev, &desc);

        if (r < 0)
        {
            fprintf(stderr, "failed to get device descriptor");
            return NULL;
        }

        if(desc.idVendor == ARM_VENDOR && desc.idProduct == ARM_PRODUCT)
        {
            return dev;
        }
    }
    return NULL;
}

int main(int ac, char **av)
{
    if (ac != 4)
    {
        fprintf(stderr,"Usage: robot_arm CMD0 CMD1 CMD2\n");
        return 1;
    }

    unsigned char cmd[3];

    cmd[0]=(unsigned char)strtol(av[1],NULL,16);
    cmd[1]=(unsigned char)strtol(av[2],NULL,16);
    cmd[2]=(unsigned char)strtol(av[3],NULL,16);

    libusb_device **devs;
    libusb_device *dev;
    struct libusb_device_handle *devh = NULL;
    int r;
    ssize_t cnt;

    r = libusb_init(NULL);

    if (r < 0)
    {
        fprintf(stderr, "failed to initialize libusb\n");
        return r;
    }

    libusb_set_debug(NULL,2);
    cnt = libusb_get_device_list(NULL, &devs);

    if (cnt < 0)
    {
        return (int) cnt;
    }

    dev=find_arm(devs);

    if (!dev)
    {
        fprintf(stderr, "Robot Arm not found\n");
        return -1;
    }

    r = libusb_open(dev,&devh);

    if (r!=0)
    {
        fprintf(stderr, "Error opening device\n");
        libusb_free_device_list(devs, 1);
        libusb_exit(NULL);
        return -1;
    }

    fprintf(stderr, "Sending %02X %02X %02X\n",
            (int)cmd[0],
            (int)cmd[1],
            (int)cmd[2]);

    int actual_length=-1;

    r = libusb_control_transfer(devh,
                                0x40,   //uint8_t 	bmRequestType,
                                6,      //uint8_t 	bRequest,
                                0x100,  //uint16_t 	wValue,
                                0,      //uint16_t 	wIndex,
                                cmd,
                                CMD_DATALEN,
                                0
                                );

    if (!(r == 0 && actual_length >= CMD_DATALEN))
    {
        fprintf(stderr, "Write err %d. len=%d\n",r,actual_length);
    }

    libusb_close(devh);
    libusb_free_device_list(devs, 1);
    libusb_exit(NULL);

    fprintf(stderr, "Done\n");
    return 0;
}

