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

Sign in with the admin account, and then navigate to the administrator menu function
'Reload Audits'

This will trigger a reload of all template and audit data from the iAuditor system (may take 2-3 minutes).



Libraries used:
- Template engine (albeit, heavily modified and updated to Bootstrap 3.0)
http://www.grocerycrud.com/codeigniter-simplicity

- Form building(bootstrap) 'codeigniter_bootstrap_form_builder'
https://github.com/wallter/codeigniter_bootstrap_form_builder

- ION Auth
http://benedmunds.com/ion_auth/



