## Integration with Personify

Add Personify credentials to your settings.php file.

```
# Personify SSO data.
$config['personify.settings']['prod_wsdl'] = ''
$config['personify.settings']['stage_wsdl'] = ''
$config['personify.settings']['vendor_id'] = ''
$config['personify.settings']['vendor_username'] = ''
$config['personify.settings']['vendor_password'] = ''
$config['personify.settings']['vendor_block'] = ''

# Personify Prod endpoint.
$config['personify.settings']['prod_endpoint'] = ''
$config['personify.settings']['prod_username'] = ''
$config['personify.settings']['prod_password'] = ''

# Personify Stage endpoint.
$config['personify.settings']['stage_endpoint'] = ''
$config['personify.settings']['stage_username'] = ''
$config['personify.settings']['stage_password'] = ''
```