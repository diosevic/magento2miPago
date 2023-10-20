<header align="center">
<h1>MiPago Magento Module</h1>
<h3>César Hernández</h3>
</header>
<hr>

# Chernandez_MiPago

This is a Magento 2.4.5 module that creates a custom Payment method.<br>
<i>Code challenge for The Etailers.</i>

## Author
* **César Hernández** - [cesarhndev@gmail.com](mailto:cesarhndev@gmail.com)


### Prerequisites

Before testing this module, make sure that you meet the requirements.

```
A Magento 2.4.* working
Composer
```

## INSTALLATION
### Composer Installation
* Go to your Magento root folder
* Run composer command:
```sh
composer require chernandez/magento2-mipago:dev-main
```
### Manual Installation
* Extract files from ChernandezMiPago.zip archive
* Go to your Magento root folder
* Move files into Magento2 folder `app/code/`.


## ENABLE EXTENSION
* Make sure you have correct read/write permissions on your Magento root directory.
  Read about them [here](https://experienceleague.adobe.com/docs/commerce-operations/configuration-guide/deployment/file-system-permissions.html?lang=en).
* Go to Magento root folder

###  Enable Extension Using Magento CLI
Execute the following commands to manually install Chernandez_MiPago
   ```sh
  bin/magento module:status
   ``` 
You must see Chernandez_MiPago in the list of disabled modules.

- Enable module 
   ```sh
   bin/magento module:enable Chernandez_MiPago
   ```
- Launch the upgrade and regenerate the code dependencies:
   ```sh
   bin/magento setup:upgrade &&
   bin/magento setup:di:compile
   ```
  
- If you have your Magento running on Production mode you must regenerate your static content:
  ```sh
    bin/magento setup:static-content:deploy
  ```
- Clean the cache
   ```sh
   bin/magento cache:clean
   ```

### Configurations

Inside Magento backend go to:
```
Stores > Configuration > Sales > Payments Methods
```
This will show you all the payment methods.<br>
Inside <b>Other Payment Methods </b> you will see MiPago.
<br>All options are self explanatory.
- Enable MiPago to test all its functionalities.
- Enable <b>Extra charge</b> to allow an extra fee to the customers that select this payment 


## TODO
1. Fix workaround saving quote attribute <b>extracharge</b>.
2. Add <b>extracharge</b> to invoice and credit memo entities.
3. Add taxes management to <b>extracharge</b> attribute.
4. Add PHPUnit testing.

