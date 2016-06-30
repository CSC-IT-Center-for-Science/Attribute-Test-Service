# SAML Attribute Test Service plugin for CakePHP

## Requirements
* apache2
* shibboleth service provider
* php >=5.5.9
* cakephp/cakephp : ~3.2
* friendsofcake/bootstrap-ui : ^0.5.0

## Functionalities
* Population of all active attributes from the /etc/shibboleth/attribute-map.xml
* Basic add/delete functionality for attributes
* You can add validation regex for attributes 
* Comparation of received attributes against attributes in database with validation.

## Preconditions

Apache2 webserver installed with libapache2-mod-shib2

modify /etc/shibboleth/shibboleth2.xml
```
<SSO entityID="https://<YOUR_IDP>/idp/shibboleth"
  SAML2
</SSO>
.
# Remember to download certificate https://confluence.csc.fi/x/wQHcAQ
<MetadataProvider type="XML" uri="https://haka.funet.fi/metadata/haka_test_metadata_signed.xml" backingFilePath="haka_test_metadata_signed.xml" reloadInterval="7200">
  <MetadataFilter type="RequireValidUntil" maxValidityInterval="2419200"/>
  <MetadataFilter type="Signature" certificate="/etc/ssl/certs/haka_testi_2015_sha2.crt"/>
</MetadataProvider>
.
<CredentialResolver type="File" key="sp.key" certificate="sp.crt"/>
```
Protect application with shibboleth
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
mkdir ../db
chmod 777 ../db
```

### Install attribute-test-service plugin
```
composer require csc-it-center-for-science/attribute-test-service

# Migrate database tables and load plugin
./bin/cake migrations migrate -p CscItCenterForScience/AttributeTestService
./bin/cake plugin load -r CscItCenterForScience/AttributeTestService

```

### Configure Bootstrap framwork
```
cp -R vendor/friendsofcake/bootstrap-ui/src/Template/Layout/examples src/Template/Layout/TwitterBootstrap
./bin/cake plugin load BootstrapUI
```
Configure src\View\AppView.php accordingly.
```
...
# use Cake\View\View;
use BootstrapUI\View\UIView;
...
# class AppView extends View
class AppView extends UIView

public function initialize()  {
  // Don't forget to call the parent::initialize()
  parent::initialize();
}

...
```
Get bootstrap and Jquery files under
```
webroot/css/bootstrap
webroot/css/fonts

webroot/js/bootstrap
webroot/js/jquery
```

