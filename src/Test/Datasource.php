<?php
namespace CFX\Brokerage\Test;

class Datasource implements \CFX\Brokerage\DatasourceInterface, \CFX\Brokerage\AuthzDatasourceInterface {
    private $testData = [];
    private $testGrants = [];

    public function setTestData($key, $data) {
        if (!array_key_exists($key, $this->testData)) $this->testData[$key] = [];
        $this->testData[$key][] = $data;
        return $this;
    }
    protected function getTestData($key) {
        if (!array_key_exists($key, $this->testData)) $this->testData[$key] = [];
        if (count($this->testData[$key]) == 0) throw \RuntimeException("Programmer: You need to set test data for `$key` using the `setTestData` method of your test datasource.");
        
        $data = array_pop($this->testData[$key]);

        if ($data instanceof \Exception) throw $data;

        return $data;
    }



    public function setAuthGrantsFor($type, $key, $grants) {
        $this->testGrants[$type][$key] = $grants;
        return $this;
    }

    public function getAuthGrantsFor($type, $key) {
        if (!array_key_exists($type, $this->testGrants) || !array_key_exists($key, $this->testGrants[$type])) return null;
        $grants = $this->testGrants[$type][$key];
        $this->testGrants[$type][$key] = null;
        return $grants;
    }

    public function getAllOAuthScopes() {
        return [
            [ "id" => 1, "name" => "View my basic personal info", "desc" => "Allows requesting services to view your name and email", "key" => "userinfo.basic.readonly" ],
            [ "id" => 2, "name" => "View my extended personal info", "desc" => "Allows requesting services to view your addresses, phone, etc.", "key" => "userinfo.extended.readonly" ],
            [ "id" => 3, "name" => "Manage my personal info (basic and extended)", "desc" => "Allows requesting services to view and edit your basic and extended info, including your name, email address, postal addresses, phone number, etc.", "key" => "userinfo" ],
            [ "id" => 4, "name" => "View my legal entities (including my social security number)", "desc" => "Allows requesting services to view any legal entities you manage, like your personal SSN, your LLCs, Trusts, etc.", "key" => "legalentities.readonly" ],
            [ "id" => 5, "name" => "Manage my legal entities (including SSN)", "desc" => "Allows requesting services to add, change, or remove legal entities from your account", "key" => "legalentities" ],
            [ "id" => 6, "name" => "View my (non-sensitive) bank information", "desc" => "Allows requesting services to view which bank accounts you have linked, including basic information about them (but not your account numbers)", "key" => "bankaccounts.readonly" ],
            [ "id" => 7, "name" => "Manage my bank information (create, update, delete accounts)", "desc" => "Allows requesting services to add, remove, or change your bank accounts", "key" => "bankaccounts" ],
            [ "id" => 8, "name" => "View my holdings", "desc" => "Allows requesting services to view the holdings in your portfolio", "key" => "holdings.readonly" ],
            [ "id" => 9, "name" => "Create holdings records for me (includes managing created holdin", "desc" => "Allows requesting services to create holdings in your portfolio and manage the holdings they've created (but not other ones they haven't). Note that this does *not* give permission to purchase assets.", "key" => "holdings.managecreated" ],
            [ "id" => 10, "name" => "Manage all holdings", "desc" => "Allows requesting services to manage all of your holdings, regardless of whether or not they created them", "key" => "holdings" ],
            [ "id" => 11, "name" => "Manage my bids and listings", "desc" => "Allows requesting services to bid on listings on your behalf, or submit orders to sell your holdings", "key" => "intents" ],
        ];
    }




    // Assets

    public function getAssets($raw=false) {
        return $this->getTestData('assets-collection');
    }
    public function getAssetById($symbol, $raw=false) {
        return $this->getTestData('asset-id-'.$symbol);
    }



    // Asset Intents

    public function getAssetIntents($raw=false) {
        return $this->getTestData('assetIntents-collection');
    }

    public function getAssetIntentById($id, $raw=false) {
        return $this->getTestData('asset-intent-id-'.$id);
    }
    public function getAssetIntentsByApiKey(\CFX\Brokerage\ApiKeyInterface $apiKey, $raw=false) {
        return $this->getTestData('asset-intent-apikey-'.$apiKey->getId());
    }
    public function saveAssetIntent(\CFX\Brokerage\AssetIntentInterface &$intent) {
        $intent = $this->getTestData('saved-asset-intent');
        return $this;
    }
    public function findDuplicateAssetIntent(\CFX\Brokerage\AssetIntentInterface $intent, $raw=false) {
        return $this->getTestData('duplicate-asset-intent-id-'.$intent->getId());
    }

    

    // OrderIntents

    public function getOrderIntentById($id, $raw=false) {
        return $this->getTestData('order-intent-id-'.$id);
    }
    public function getOrderIntentByOldId($id, $raw=false) {
        return $this->getTestData('order-intent-old-id-'.$id);
    }
    public function findDuplicateOrderIntent(\CFX\Brokerage\OrderIntentInterface $intent, $raw=false) {
        return $this->getTestData('duplicate-order-intent-id-'.$intent->getId());
    }
    public function saveOrderIntent(\CFX\Brokerage\OrderIntentInterface &$intent) {
        $intent = $this->getTestData('saved-order-intent');
        return $this;
    }
    public function deleteOrderIntentById($id) {
        return $this->getTestData('deleted-order-intent-id-'.$id);
    }
    public function deleteOrderIntent(\CFX\Brokerage\OrderIntentInterface $intent) {
        return $this->getTestData('deleted-order-intent-id-'.$intent->getId());
    }

    

    // SiteUser

    public function getSiteUserById($id, $raw=false) {
        return $this->getTestData('site-user-id-'.$id);
    }
    public function findDuplicateSiteUser(\CFX\Brokerage\SiteUserInterface $user) {
        return $this->getTestData('duplicate-site-user-id-'.$user->getId());
    }
    public function saveSiteUser(\CFX\Brokerage\SiteUserInterface &$user) {
        $user = $this->getTestData('saved-site-user');
        return $this;
    }



    // Orders
    public function getOrderById($id, $raw=false) {
        return $this->getTestData('order-id-'.$id);
    }


    


    // Other

    public function getPartnerById($id, $raw=false) {
        return $this->getTestData('partner-id-'.$id);
    }

    public function getApiKeyById($id, $raw=false) {
        return $this->getTestData('api-key-id-'.$id);
    }

    public function getOAuthTokenById($id, $raw=false) {
        return $this->getTestData('oauth-token-id-'.$id);
    }
    public function getOAuthTokensByApiKey($apiKey, $raw=false) {
        if ($apiKey instanceof \CFX\Brokerage\ApiKeyInterface) $apiKey = $apiKey->getId();
        return $this->getTestData('oauth-tokens-apikey-'.$apiKey);
    }
    public function getOAuthTokensByUserId($userId, $raw=false) {
        return $this->getTestData('oauth-tokens-user-id-'.$userId);
    }
    public function saveOAuthToken(\CFX\Brokerage\OAuthTokenInterface &$oauthToken) {
        $oauthToken = $this->getTestData('saved-oauth-token');
        return $this;
    }
}

