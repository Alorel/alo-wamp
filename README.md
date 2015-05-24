![Logo](https://cloud.githubusercontent.com/assets/4998038/7652717/3ced6726-fb07-11e4-9d2e-7201085c2831.png)

[![Licence](https://img.shields.io/github/license/alorel/aloWAMP.svg?style=plastic&label=Licence)](LICENCE)

[![NuGet release](http://img.shields.io/nuget/v/aloWAMP.svg?label=NuGet%20release&style=plastic)](https://www.nuget.org/packages/AloWAMP/) [![NuGET pre-release](http://img.shields.io/nuget/vpre/aloWAMP.svg?label=NuGet%20pre-release&color=orange&style=plastic)](https://www.nuget.org/packages/AloWAMP/) 

[![Packagist release](https://img.shields.io/packagist/v/alorel/alo-wamp.svg?style=plastic&label=Packagist%20release)](https://packagist.org/packages/alorel/alo-wamp) [![Packagist pre-release](https://img.shields.io/packagist/vpre/alorel/alo-wamp.svg?style=plastic&label=Packagist%20pre-release)](https://packagist.org/packages/alorel/alo-wamp)

[![NuGET downloads](http://img.shields.io/nuget/dt/aloWAMP.svg?label=NuGET%20downloads&style=plastic)](https://www.nuget.org/packages/AloWAMP/) [![Packagist downloads](https://img.shields.io/packagist/dt/alorel/alo-wamp.svg?style=plastic&label=Packagist%20downloads)](https://packagist.org/packages/alorel/alo-wamp) 


# What is this? #
AloWAMP is, well, a functioning web-server for Windows machines. It has a Windows Memcache port as well as:

* An automatically updatable **PHP** installer
* Automatically updatable **MySQL** installer
* Automatically updatable **Apache HTTPD** installer
* Automatically updatable **Redis** installer
* An old, but functioning Windows port for **Memcache**

# Table of Contents #

* [Why should I use this WAMP Stack](#why-should-i-use-this-wamp-stack)
* [Requirements](#requirements)
* [Setup](#setup)
* [Files](#files)
* [Controlling Services](#controlling-services)
* [Changelog](#changelog)
* [FAQ](#faq)
	* [The installer fails to install services](#the-installer-fails-to-install-services)
	* [How do you update your binaries?](#how-do-you-update-your-binaries)
	* [Where do you get your binaries?](#where-do-you-get-your-binaries)
	* [Which versions do you use?](#which-versions-do-you-use)
* [Supporting the Project](#supporting-the-project)
* [Other Alo products](#other-alo-products)

# Why Should I Use This Wamp Stack #
* **Range of products**. Most WAMPs will only offer PHP, Apache and MySQL while AloWAMP also gives you Memcache and Redis.
* **Most up-to date binaries, always**. It's easy to update to a new version of a binary from within AloWAMP (be sure to actually switch to it afterwards); most WAMPs only offer pre-installed versions and take ages to update them.

# Requirements #
* [Visual C++ Redistributable for Visual Studio 2012](https://www.microsoft.com/en-us/download/details.aspx?id=30679)
	* This is a required installation to use PHP. Only the 32-bit version is required for AloWAMP, but, if you have a 64-bit machine, I would recommend installing the 64-bit version too as you might need it in future.

# Setup #
Simply run setup.bat and it will handle everything for you.  **Any batch file should be run with admin privileges**.

^[TOC](#table-of-contents)

# Files #
You should only need to care about three directories:

* **logs**, once installed, contain all the, you've guessed it, logs.
* **wamp** contains the batch files that control services, versions etc
* **www** is where you'll be placing your project files

^[TOC](#table-of-contents)

# Controlling Services #
Simply use the appropriate start/restart/stop/uninstall batch files.

^[TOC](#table-of-contents)

# Changelog #
See [changelog.md](changelog.md)

^[TOC](#table-of-contents)

# FAQ #
## The installer fails to install services ##
This can only be caused by running the batch files without admin permissions. Run the **reset installation.bat** file and try running it via right click: 

![Run as admin - right click](https://cloud.githubusercontent.com/assets/4998038/7687571/0d8bfd44-fd96-11e4-93c8-04b27b023836.png)

or by running **cmd** as admin, navigating to where you have AloWAMP installed and running setup manually, for example (the example assumes you have AloWAMP source unzipped to **C:\Program files\AloWAMP**):

![cmd as admin](https://cloud.githubusercontent.com/assets/4998038/7687570/0d890f76-fd96-11e4-9d51-de89831bf4d4.png)

```
C:\
cd "Program Files\AloWAMP"
setup.bat
```

^[TOC](#table-of-contents)

## How do you update your binaries? ##
I simply get the page HTML via cURL, parse it and produce links. The installer then downloads them and performs the required setup. The downside of this, of course, is that changes in the pages' HTML *can* make downloads impossible, in which case simply report an issue and it'll get fixed.

^[TOC](#table-of-contents)

## Where do you get your binaries? ##
Memcache is hosted on this repository while everything else is fetched from the official websites.

^[TOC](#table-of-contents)

## Which versions do you use? ##
To keep everything nice and available, all versions are 32-bit and PHP versions are thread-safe. The only exception is Redis, which is only available for 64-bit processors.

^[TOC](#table-of-contents)

# Supporting the Project #
Any support is greatly appreciated - whether you're able to [send a Paypal donation](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UEPH3KQJKEQDE), [become a ClixSense referral](http://www.clixsense.com/?r=4639931&c=alo-wamp&s=102) or simply [drop an email](mailto:a.molcanovas@gmail.com) I'll be very greatful. :)

^[TOC](#table-of-contents)

# Other Alo Products #
You can find other open source Alo products at [alorel.weebly.com](http://alorel.weebly.com/).

^[TOC](#table-of-contents)