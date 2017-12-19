PHP Public Models
=======================================================================

This library represents the current set of CFX's public PHP data models. This README will focus on the (very little) general business information surrounding the classes this library provides. For an in-depth discussion of each Resource class's business logic, see the [API Docs](https://apis.cfxtrading.com/cfx-brokerage-api.v2.json). (You can view that document more easily by pasting its contents into the editor at http://editor.swagger.io.) For an in-depth discussion of CFX's data model _implementation_, see [php-jsonapi-objects](https://github.com/cfxmarkets/php-public-models) and [php-persistence](https://github.com/cfxmarkets/php-persistence).


## Installation

This library can be installed using the standard composer process:

```bash
composer require cfxmarkets/php-public-models
```


## Overview

Currently, there are two primary data domains that CFX operates in: The Brokerage Domain and the Exchange Domain.

The Brokerage Domain encapsulates objects and operations related to the CFX brokerage house. This includes Users, LegalEntities, OrderIntents, Orders, Addresses, BankAccounts, Assets, AssetIntents, DealRooms, TenderRooms, Tenders, and others. In short, any data that concerns a brokerage will be found in the Brokerage Domain.

The Exchange Domain encapsulates objects and operations related to the CFX exchange. This includes Brokerages, Orders, Assets, and Transactions. (Most of these are currently unimplemented at the time of this writing.)



## Usage

Most of the important information in this library exists at the class level. That is, what you'll really want to learn about is 1) what classes exist; and 2) how you can use them. You can get this information most easily by simply browsing the classes themselves. However, if you haven't already, you may want to take a minute and familiarize yourself with the style in which this library was meant to be used, detailed in the following paragraphs and examples.

-------------------------------------------------------------------------------------------

In general, the classes in this library rely on getters and setters to manipulate their data. They also include a few common update and persistence operations, namely `updateFromData`, `updateFromResource`, `save`, `initialize`, and `refresh`. You can use these methods (and a few others) on all of CFX's public model classes because these are part of the underlying `ResourceInterface` on which our resource objects are based.

Thus, following is a common example of how you might end up using these objects. Assume `$cfx` is the CFX Brokerage Client from the [`php-brokerage-sdk`](https://github.com/cfxmarkets/php-brokerage-sdk) library.

```php
$user = $cfx->users->get("id=abc123");

$name = $user->getName();
$street1 = $user->getAddress()->getStreet1();
$street2 = $user->getAddress()->getStreet2();
$city = $user->getAddress()->getCity();
$state = $user->getAddress()->getState();
$country = $user->getAddress()->getCountry();
$zip = $user->getAddress()->getZip();

$orderIntent = $cfx->orderIntents->create()
    ->setType('sell')
    ->setPriceHigh(2.50)
    ->setPriceLow(2.10)
    ->setAsset($cfx->assets->get("id=INVT001"))
    ->setAssetOwner($user->getPersonEntity())
    ->setBankAccount($user->getBankAccounts()[0])
;

// (This is future functionality not implemented at the time of this writing)
if ($user->isAtLeast('financial-advisor')) {
    $orderIntent->setReferralKey($user->getId());
}

$orderIntent->save();

....
```

Notice here that the majority of these calls are simple getters and setters. The one call that is not (`User::isAtLeast`) is not yet implemented, but is a good example of what sorts of functionality might be introduced by non-setter/getter methods.

Beyond that, there's not too much more to point out. From here, you should study up on the [API Docs](https://apis.cfxtrading.com/cfx-brokerage-api.v2.json), as mentioned, and start writing code!


## Note About API Documentation

We're hoping to launch a site (developers.cfxtrading.com) soon that will allow us to provide more comprehensive API documentation and other resources for developers. While this site is not live yet, you can still generate good API documentation for this library by cloning the library, installing [Sami](https://github.com/FriendsOfPHP/Sami), and running `sami.phar update sami.config.php`.

