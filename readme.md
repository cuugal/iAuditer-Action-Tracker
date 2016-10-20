**iAuditor Action Tracker**

Codeigniter/PHP5.3/Bootstrap

Installation:
- Pull down files from GitHub
- Command prompt to the project directory
- Run `php composer.phar install`
- Point webroot to `/iAuditer-Action-Tracker/vendor/ellislab/codeigniter/`

System uses SQLite, to set up tables navigate to webroot and run:
`php index.php tools migrate`

This will create the table structure and also a super-user:
`Email: admin@admin.com
Password: password`
