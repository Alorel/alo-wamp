![Logo](https://cloud.githubusercontent.com/assets/4998038/7652717/3ced6726-fb07-11e4-9d2e-7201085c2831.png)

[![Licence](https://img.shields.io/github/license/alorel/aloWAMP.svg?style=plastic&label=Licence)](LICENCE)

[![NuGet release](http://img.shields.io/nuget/v/aloWAMP.svg?label=NuGet%20release&style=plastic)](https://www.nuget.org/packages/AloWAMP/) [![NuGET pre-release](http://img.shields.io/nuget/vpre/aloWAMP.svg?label=NuGet%20pre-release&color=orange&style=plastic)](https://www.nuget.org/packages/AloWAMP/) 

[![Packagist release](https://img.shields.io/packagist/v/alorel/alo-wamp.svg?style=plastic&label=Packagist%20release)](https://packagist.org/packages/alorel/alo-wamp) [![Packagist pre-release](https://img.shields.io/packagist/vpre/alorel/alo-wamp.svg?style=plastic&label=Packagist%20pre-release)](https://packagist.org/packages/alorel/alo-wamp)

[![NuGET downloads](http://img.shields.io/nuget/dt/aloWAMP.svg?label=NuGET%20downloads&style=plastic)](https://www.nuget.org/packages/AloWAMP/) [![Packagist downloads](https://img.shields.io/packagist/dt/alorel/alo-wamp.svg?style=plastic&label=Packagist%20downloads)](https://packagist.org/packages/alorel/alo-wamp) 


# What is this? #
AloWAMP is, well, a functioning web-server for Windows machines. It a Windows Memcache port as well as:

* An automatically updateable **PHP** installer
* Automatically updateable **MySQL** installer
* Automatically updateable **Apache HTTPD** installer
* Automatically updateable **Redis** installer
* An old, but functioning Windows port for **Memcache**

# Table of Contents #

* [Why should I use this WAMP Stack](#why-should-i-use-this-wamp-stack)
* [Setup](#setup)
* [Files](#files)
* [Controlling Services](#controlling-services)
* [FAQ](#faq)
	* [The installer fails to install services](#the-installer-fails-to-install-services)
* [Supporting the Project](#supporting-the-project)
* [Other Alo products](#other-alo-products)

# Why Should I Use This Wamp Stack #

* **Range of products**. Most WAMPs will only offer PHP, Apache and MySQL while AloWAMP also gives you Memcache and Redis.
* **Most up-to date binaries, always**. It's easy to update to a new version of a binary from within AloWAMP (be sure to actually switch to it afterwards); most WAMPs only offer pre-installed versions and take ages to update them.

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

----------

Q: How do you update your binaries?

A: I simply get the page HTML via cURL, parse it and produce links. The installer then downloads them and performs the required setup. The downside of this, of course, is that changes in the pages' HTML *can* make downloads impossible, in which case simply report an issue and it'll get fixed.

----------

Q: Where do you get your binaries?

A: Memcache is hosted on this repository while everything else is fetched from the official websites.

----------

Q: Which versions do you use?
A: To keep everything nice and available, all versions are 32-bit and PHP versions are thread-safe. The only exception is Redis, which is only available for 64-bit processors.

^[TOC](#table-of-contents)

# Supporting the Project #
Any support is greatly appreciated - whether you're able to [send a Paypal donation](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UEPH3KQJKEQDE), [become a ClixSense referral](http://www.clixsense.com/?r=4639931&c=alo-wamp&s=102) or simply [drop an email](mailto:a.molcanovas@gmail.com) I'll be very greatful. :)

^[TOC](#table-of-contents)

# Other Alo Products #

* [AloFramework](https://github.com/Alorel/alo-framework), a simple yet powerful PHP framework.

^[TOC](#table-of-contents)