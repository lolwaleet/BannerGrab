# ~ BannerGrab

BannerGrab is a php-based tool, which helps you find juicy headers, subdomains, and if the target site is running WordPress or Joomla it scans all the themes/plugins/components.

### Screenshots

#### Wordpress
![Wordpress](http://i.imgur.com/MHpxIME.png)
#### Joomla
![Joomla](http://i.imgur.com/qYpQ6DC.png)

### Prerequisities

To get the subdomains I have used abdul3la's sublist3r (one of the best subdomain finders!) which is coded in .. python
So, you must have Python 2.7.x installed, support for Python 3.x isn't provided .. also, you must have the following dependencies installed .. 

~ requests  [ `sudo apt-get install python-requests`  ]  
~ dnspython [ `sudo apt-get install python-dnspython` ]  
~ argparse  [ `sudo apt-get install python-argparse`  ]

### Installing
After python-stuff is done, you may move the BannerGrab folder to your homedir ~/ and add this line in your .bashrc  
`alias BannerGrab='php ~/BannerGrab/BannerGrab.php'`
### PS
	don't mind my shitty coding techniques
	don't forget to change sublist3r's path in BannerGrab.php
	in wp.php, don't mind the 'extra-functions', i like 'em beatiphul!
	if you're having any troubles message me at noreply@lolwaleet.com [ it's an email from which I don't reply ]

~ Abk Khan [ @asystolik ]
