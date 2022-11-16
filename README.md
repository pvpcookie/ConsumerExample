# Mage2 Module Pvpcookie ConsumerExample

    ``pvpcookie/consumerexample``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Specifications](#markdown-header-specifications)


## Main Functionalities
A simple module illustrating how to create consumer for the Magento 2 Message Queue

## Installation

From <mage2_root> folder:
```bash
git clone git@github.com:pvpcookie/ConsumerExample.git app/code/Pvpcookie/ConsumerExample
php bine/magento module:enable Pvpcookie_ConsumerExample
php bin/magento setup:upgrade
php bin/magento setup:di:compile
```

## Specifications

 - Console Command
	- `bin/magento pvpcookie:fibonacci:push {integer}`
 - Consumer Command
    - `bin/magento queue:consumers:start pvpcookie.fibonacci.calculate --multi-process`



