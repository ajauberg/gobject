A Google Maps based management system that displays wireless nodes with transmission parameters, signal strength and link quality. Data is pushed from the wireless nodes using standard Linux commands such as `ifconfig`, `iwconfig` and `iwlist` utilizing HTTP GET.

![http://gobject.googlecode.com/svn/trunk/gObjects.jpg](http://gobject.googlecode.com/svn/trunk/gObjects.jpg)

The system has the following features:

  * Flexible status and performance settings through database tables
  * The wireless nodes can perform behind a firewall since no polling occurs
  * The links are drawn based on how good a node receives another node

The following components apply:

  1. A [HTML page using Google Maps](Map.md) that reads its data from XML-files implemented in [PHP](PHPFiles.md)
  1. A [MySQL database](Database.md) storing the management information
  1. A set of [Linux scripts](LinuxUtilities.md) collecting management information from the wireless nodes
  1. A [report generator](Reports.md) for displaying Signal, Noise, Quality and transmission data.