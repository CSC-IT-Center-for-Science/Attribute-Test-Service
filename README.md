# Attribute-Test-Service
Attribute test service for shibboleth 

Preconditions
aptitude install libapache2-mod-shib2

modify /etc/shibboleth/shibboleth2.xml
```
<ApplicationDefaults entityID="https://<YOUR_SITE>/shibboleth" REMOTE_USER="eppn persistent-id targeted-id">
```

```
<SSO entityID="https://<YOUR_IDP>/idp/shibboleth" 
  SAML2
</SSO>
```
Remember to download certificate https://confluence.csc.fi/x/wQHcAQ
```
<MetadataProvider type="XML" uri="https://haka.funet.fi/metadata/haka_test_metadata_signed.xml"
  backingFilePath="haka_test_metadata_signed.xml" reloadInterval="7200">
  <MetadataFilter type="RequireValidUntil" maxValidityInterval="2419200"/>
  <MetadataFilter type="Signature" certificate="/etc/ssl/certs/haka_testi_2015_sha2.crt"/>
</MetadataProvider>
```
```
<CredentialResolver type="File" key="sp.key" certificate="sp.crt"/>
```
Protect your service with shibboleth
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

Download composer.json
composer update
composer create-project --prefer-dist cakephp/app www

