# AMP

AMP stands for Agile Music Project.

This is the code for AgileMusicProject.com.

Setup
1. Install Apache, PHP, and MySql. The consider doing this as one step via Lamp, Wamp, etc.
2. Install Git if not installed. Download source.
3. Set up the virtual host on Apache. Make sure mod_php and rewrite are enabled in Apache.
4. Add hosts entry for your virtual host.
5. Run .composer.phar install from the project root directory.
6. Import the scripts in scripts\db to MySql.
7. Set up these environment variables:
	MYSQL_USER
	MYSQL_PASSWORD
	MYSQL_DBNAME
	MYSQL_HOST
8. (Re)start Apache.
9. Visit the site. Try to log in. Follow WordPress installation prompts.
10. Enable responsive-child theme in WordPress admin.


Automatic Wordpress updates have been disabled, so Wordpress must be udpated manually then pushed.

![Codeship Status](https://www.codeship.io/projects/8ec68400-c4df-0131-6d9b-120e87d70e60/status)
