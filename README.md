# SAML Attribute Test Service plugin for CakePHP

## Requirements
* apache2
* shibboleth service provider
* php >=5.5.9
* cakephp/cakephp : ~3.2
* friendsofcake/bootstrap-ui : ^0.5.0

## Functionalities
* Populates all active attributes from the /etc/shibboleth/attribute-map.xml
* Basic add/delete functionality for attributes
* Optional validation regex for attributes
* Comparation of received attributes against attributes in database with validation
* Stores names of released attributes and validation status for each individual user (persistent-id, schachomeorganization stored as received)

## Preconditions

Apache2 webserver installed with libapache2-mod-shib2

modify /etc/shibboleth/shibboleth2.xml
```
<SSO entityID="https://<YOUR_IDP>/idp/shibboleth"
  SAML2
</SSO>
...
# Example below is for a test service registered to Haka-test federation. 
# It also uses certificate from https://confluence.csc.fi/x/wQHcAQ to validate metadata.

<MetadataProvider type="XML" uri="https://haka.funet.fi/metadata/haka_test_metadata_signed.xml" 
                  backingFilePath="haka_test_metadata_signed.xml" reloadInterval="7200">
  <MetadataFilter type="RequireValidUntil" maxValidityInterval="2419200"/>
  <MetadataFilter type="Signature" certificate="/etc/ssl/certs/haka_testi_2015_sha2.crt"/>
</MetadataProvider>
...

# Configure keys and certificates which will be used with SAML messaging.

<CredentialResolver type="File" key="sp.key" certificate="sp.crt"/>
```
Protect application with shibboleth in Apache virtualhost configuration.
```
<VirtualHost *:443>
  DocumentRoot <DOCUMENT ROOT> 
  ServerAlias <SERVER_ALIAS>
  ErrorLog /var/www/<YOUR_SITE>/log/error.log
  CustomLog /var/www/<YOUR_SITE>/log/access.log combined
  AllowEncodedSlashes On
  SSLEngine on
  <Location /www>
    AuthType shibboleth
    ShibRequireSession On
    require valid-user
  </Location>
</VirtualHost>
```
## Installation

### CakePHP

Download and install composer
```
curl -s https://getcomposer.org/installer | php
```
Create CakePHP project
```
php composer.phar create-project --prefer-dist cakephp/app www
or with global installation (used in these examples).
composer create-project --prefer-dist cakephp/app www
```

### Configure database
from just baked project directory www/config/app.php, replace following lines to use sqlite datasource.
```
'Datasources' => [
  'default' => [
    ...
    'driver' => 'Cake\Database\Driver\Sqlite',
    'database' => '/var/www/<YOUR_SITE>/db/database.sqlite',
    ...
```
And make sure that cakephp has access to directory where database will be created (example below is too permissive).
```
mkdir db; chmod 777 db
```

### Install attribute-test-service plugin
```
# Change to your created project directory
cd www

composer require csc-it-center-for-science/attribute-test-service

# copy needed bootstrap and jquery files in place.
cp -r vendor/csc-it-center-for-science/attribute-test-service/webroot/js/* webroot/js/.
cp -r vendor/csc-it-center-for-science/attribute-test-service/webroot/css/* webroot/css/.

# Migrate database tables and load plugin
./bin/cake migrations migrate -p CscItCenterForScience/AttributeTestService
chmod 777 ../db/database.sqlite
./bin/cake plugin load -r CscItCenterForScience/AttributeTestService
```

### Configure Bootstrap framework
```
# Copy extra layout types to your project layouts directory
cp -R vendor/friendsofcake/bootstrap-ui/src/Template/Layout/examples src/Template/Layout/TwitterBootstrap

./bin/cake plugin load BootstrapUI
```
Make your AppView class extend BootstrapUI\View\UIView (src/View/AppView.php).
```
# use Cake\View\View;
use BootstrapUI\View\UIView;
...
# class AppView extends View
class AppView extends UIView

public function initialize()  {
  // Don't forget to call the parent::initialize()
  parent::initialize();
}
```

### Authorization (Shibboleth handles the authentication)
To use Auth component with shibboleth SAML authentication. In your project 'src/Controller/AppController.php' modify accordingly.
```
   public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth',[
                              'authorize' => [
                                'Controller'
                              ],
                              'flash' => [
                                'element' => 'error',
                                'key' => 'auth'
                              ],
                            ]);
        $role =  (strtolower($this->request->env('schachomeorganization'))=='csc.fi') ? 'admin' : 'user';

        if (!$this->Auth->user()) :
          $this->Auth->setUser(array('username'=>$this->request->env('displayname'),
                                     'email'=>$this->request->env('mail'),
                                     'eppn'=>$this->request->env('edupersonprincipalname'),
                                     'sn'=>$this->request->env('sn'),
                                     'givenname'=>$this->request->env('givenname'),
                                     'role'=>$role
                              ));
        endif;
        $this->Auth->allow(['login','index','test','view']);

    }

    public function isAuthorized($user)
    {
      if(isset($user['role'])) :
        if ($user['role']=='admin') :
          return true;
        endif;
      endif;
      return false;
    }

```
To show also Auth related flash messages, make sure you have both renders in your 'src/Template/Layout/TwitterBootstrap/dashboard.ctp'
```
echo $this->Flash->render();
echo $this->Flash->render('auth');
```
Now you should be good to go. Attribute plugin should be found from https://YOUR_SITE/attribute/attributes/index.
