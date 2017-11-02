**iAuditor Action Tracker**

Codeigniter/PHP5.3/Bootstrap

Installation:
- Pull down files from GitHub
- Command prompt to the project directory
- Point webroot to `/iAuditer-Action-Tracker/vendor/ellislab/codeigniter/`

System uses SQLite, to set up tables navigate to webroot and run:

`php index.php tools migrate`
or alternatively, hit the URL: `[baseurl]/tools/migrate`

This will create the table structure and also a super-user:

`Email: admin@admin.com
Password: password`

Sign in with the admin account, and then navigate to the administrator menu function
'Reload Audits'

This will trigger a reload of all template and audit data from the iAuditor system (may take 2-3 minutes).

Edit \vendor\ellislab\codeigniter\application\models\Mail_model.php to configure mail server and default email address.
Edit the three files in \vendor\ellislab\codeigniter\application\views\emails to change wording and logo from UTS to suit your organisation.
Logo is stored in \vendor\ellislab\codeigniter\assets\images


Libraries used:
- Template engine (albeit, heavily modified and updated to Bootstrap 3.0)
http://www.grocerycrud.com/codeigniter-simplicity

- Form building(bootstrap) 'codeigniter_bootstrap_form_builder'
https://github.com/wallter/codeigniter_bootstrap_form_builder

- ION Auth
http://benedmunds.com/ion_auth/



