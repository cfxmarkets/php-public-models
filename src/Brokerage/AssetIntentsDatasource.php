<?php
namespace CFX\Brokerage;

class AssetIntentsDatasource extends \CFX\AbstractSqlDatasource {
    public function create(array $data=null) {
        return new AssetIntent($this->context, $data);
    }

    public function get($q=null, $raw=false) {
        $q = $this->parseDSL($q);
        $query = $this->newSqlQuery([
            'query' => 'SELECT `id`, `name`, `symbol`, `description`, `assetType`, `financeType`, `exemptionType`, `edgarNum`, `cusipNum`, `sharesOutstanding`, `offerAmount`, `dateOpened`, `dateClosed`, `initialSharePrice`, `holdingPeriod`, `comments`, `status`, `partnerId`, `assetId` FROM `asset_submissions`',
            'where' => $q->getWhere(),
            'params' => $q->getParams(),
        ]);

        $data = $this->executeQuery($query);
        $data = $this->convertToJsonApi('asset-intents', $data);

        return $raw ?
            ($q->requestingCollection ? $data : $data[0]) :
            $this->inflateData($data, $q->requestingCollection())
        ;
    }
}

