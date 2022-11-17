# Mage2 Module Pvpcookie ConsumerExample

    ``pvpcookie/consumerexample``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Specifications](#markdown-header-specifications)


## Main Functionalities
A simple module illustrating how to create consumer for the Magento 2 Message Queue
- Simple Algorithm calculation example
- Simple Rest Request example
## Installation

You will need to restart you cron and insure the corn is working for the consumers to function without the consumer commands
See more here: [Configure cron jobs](https://experienceleague.adobe.com/docs/commerce-operations/configuration-guide/cli/configure-cron-jobs.html)

From <mage2_root> folder:

```bash
git clone git@github.com:pvpcookie/ConsumerExample.git app/code/Pvpcookie/ConsumerExample
php bin/magento module:enable Pvpcookie_ConsumerExample
php bin/magento setup:upgrade
php bin/magento setup:di:compile
```

### For Rest Reqwuest tests i recoment using: Webhook Site
Open `https://webhook.site/` in your browser and copy the link under "Your unique URL (Please copy it from here, not from the address bar!)" 

## Specifications

 - Console Command
	- `bin/magento pvpcookie:fibonacci:push {integer}`
    - `bin/magento pvpcookie:http:push {endpoint}`
 - Consumer Command
    - `bin/magento queue:consumers:start pvpcookie.fibonacci.calculate --multi-process`
    - ` bin/magento queue:consumers:start pvpcookie.rest.get --multi-process`



