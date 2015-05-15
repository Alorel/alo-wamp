![alowamp](https://cloud.githubusercontent.com/assets/4998038/7642238/60e80d32-fa87-11e4-9324-55aa30403a66.png)

 ![apache](https://img.shields.io/badge/Apache-UPDATEABLE-brightgreen.png?style=plastic) ![mysql](https://img.shields.io/badge/MySQL-UPDATEABLE-brightgreen.png?style=plastic) ![php](https://img.shields.io/badge/PHP-UPDATEABLE-brightgreen.png?style=plastic) ![redis](https://img.shields.io/badge/Redis-UPDATEABLE-brightgreen.png?style=plastic) ![memcache](https://img.shields.io/badge/Memcache-Preset-yellow.png?style=plastic)

[![NuGet](http://img.shields.io/nuget/v/aloWAMP.png?label=NuGet%20release&style=plastic)](https://www.nuget.org/packages/AloWAMP/) [![NuGET](http://img.shields.io/nuget/vpre/aloWAMP.png?label=NuGet%20pre-release&color=orange&style=plastic)](https://www.nuget.org/packages/AloWAMP/) 
[![Packagist](https://img.shields.io/packagist/v/alorel/alo-wamp.png?style=plastic&label=Packagist%20release)](https://packagist.org/packages/alorel/alo-wamp) [![Packagist](https://img.shields.io/packagist/vpre/alorel/alo-wamp.png?style=plastic&label=Packagist%20pre-release)](https://packagist.org/packages/alorel/alo-wamp)

[![NuGET](http://img.shields.io/nuget/dt/aloWAMP.png?label=NuGET%20downloads&style=plastic)](https://www.nuget.org/packages/AloWAMP/) [![Packagist](https://img.shields.io/packagist/dt/alorel/alo-wamp.png?style=plastic&label=Packagist%20downloads)](https://packagist.org/packages/alorel/alo-wamp) ![GitHub](https://img.shields.io/github/downloads/alorel/aloWAMP/latest/total.png?label=GitHub%20downloads&style=plastic)

[![Licence](https://img.shields.io/github/license/alorel/aloWAMP.png?style=plastic)](LICENCE)

# What is this? #
AloWAMP is, well, a functioning web-server for Windows machines. It a Windows Memcache port as well as:

* An automatically updateable **PHP** installer
* Automatically updateable **MySQL** installer
* Autmiatically updateable **Apache HTTPD** installer
* Automatically updateable **Redis** installer
* An old, but functioning Windows port for **Memcache**

# Table of Contents #

1. [Why should I use this WAMP Stack](#why-should-i-use-this-wamp-stack)
2. [Setup](#setup)
3. [Files](#files)
4. [Controlling Services](#controlling-services)
5. [FAQ](#faq)
6. [Supporting the Project](#supporting-the-project)
7. [Other Alo products](#other-alo-products)

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
Q: How do you update your binaries?
A: I simply get the page HTML via cURL, parse it and produce links. The installer then downloads them and performs the required setup. The downside of this, of course, is that changes in the pages' HTML *can* make downloads impossible, in which case simply report an issue and it'll get fixed.

Q: Where do you get your binaries?
A: Memcache is hosted on this repository while everything else is fetched from the official websites.

Q: Which versions do you use?
A: To keep everything nice and available, all versions are 32-bit and PHP versions are thread-safe. The only exception is Redis, which is only available for 64-bit processors.

^[TOC](#table-of-contents)

# Supporting the Project #
Any support is greatly appreciated - whether you're able to [send a Paypal donation](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UEPH3KQJKEQDE), [become a ClixSense referral](http://www.clixsense.com/?r=4639931&c=alo-wamp&s=102) or simply [drop an email](mailto:a.molcanovas@gmail.com) I'll be very greatful. :)

^[TOC](#table-of-contents)

# Other Alo Products #

* [AloFramework](https://github.com/Alorel/alo-framework), a simple yet powerful PHP framework.

^[TOC](#table-of-contents)