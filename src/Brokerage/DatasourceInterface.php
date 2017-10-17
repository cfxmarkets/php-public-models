<?php
namespace CFX\Brokerage;

/**
 * DatasourceInterface
 *
 * An interface that defines CFX's declarative brokerage datasource object. This interface
 * allows for the abstraction of data persistence transactions and may aid in caching.
 */
interface DatasourceInterface {
    public function getAssets($raw=false);
    public function getAssetById($symbol, $raw=false);

    public function getAssetIntentById($id, $raw=false);
    public function getAssetIntentsByApiKey(ApiKeyInterface $apiKey, $raw=false);
    public function saveAssetIntent(AssetIntentInterface &$intent);
    public function findDuplicateAssetIntent(AssetIntentInterface $intent, $raw=false);

    public function getOrderIntentById($id, $raw=false);
    public function getOrderIntentByOldId($id, $raw=false);
    public function findDuplicateOrderIntent(OrderIntentInterface $intent, $raw=false);
    public function saveOrderIntent(OrderIntentInterface &$intent);
    public function deleteOrderIntentById($id);
    public function deleteOrderIntent(OrderIntentInterface $intent);

    public function getSiteUserById($id, $raw=false);
    public function findDuplicateSiteUser(SiteUserInterface $user);
    public function saveSiteUser(SiteUserInterface &$user);

    public function getPartnerById($id, $raw=false);

    public function getApiKeyById($id, $raw=false);

    public function getOAuthTokenById($id, $raw=false);
    public function getOAuthTokensByApiKey($apiKey, $raw=false);
    public function getOAuthTokensByUserId($userId, $raw=false);
    public function saveOAuthToken(OAuthTokenInterface &$oauthToken);
}

