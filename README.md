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
Protect application with shibboleth in Apache virtualhost configuration, this one uses lazy login.
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
    ShibRequireSession Off
    require shibbolet
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
                              'loginAction' => [
                                'controller' => 'attribute/releases',
                                'action' => 'index'
                              ],
                              'flash' => [
                                'element' => 'error',
                                'key' => 'auth'
                              ],
                            ]);
        if ($this->request->env('Shib-Session-ID')!==null && $this->Auth->user('role')===null) :
            $role =  (strtolower($this->request->env('schachomeorganization'))=='csc.fi') ? 'admin' : 'user';
            $this->Auth->setUser(array('username'=>$this->request->env('displayname'),
                                       'email'=>$this->request->env('mail'),
                                       'eppn'=>$this->request->env('edupersonprincipalname'),
                                       'sn'=>$this->request->env('sn'),
                                       'givenname'=>$this->request->env('givenname'),
                                       'role'=>$role
                                       ));
        elseif ($this->request->env('Shib-Session-ID')===null && $this->Auth->user('role')!==null) :
          $this->Auth->logout();
        endif;
        $this->Auth->allow(['index','test','view']);

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
Enable login/logout buttons in 'src/Template/Layout/TwitterBootstrap/dashboard.ctp'
```
<?php if ($this->request->session()->read('Auth.User.role') != null) : ?>
  <a href="https://<?=$this->request->host();?>/Shibboleth.sso/Logout?return=https://<?=$this->request->host();?>/attribute/attributes/test" title="Logout" class="btn btn-default glyphicon glyphicon-log-out navbar-nav navbar-right"></a>
<?php else :  ?>
  <a href="https://<?=$this->request->host();?>/Shibboleth.sso/Login?target=https://<?=$this->request->host();?>/attribute/attributes/test&entityID=https://testidp.funet.fi/idp/shibboleth" title="Login" class="btn btn-default glyphicon glyphicon-log-in navbar-nav navbar-right"></a>
<?php endif; ?>
```

To show also Auth related flash messages, make sure you have both renders in your 'src/Template/Layout/TwitterBootstrap/dashboard.ctp'
```
echo $this->Flash->render();
echo $this->Flash->render('auth');
```
Now you should be good to go. Attribute plugin should be found from https://YOUR_SITE/attribute/attributes/index.
