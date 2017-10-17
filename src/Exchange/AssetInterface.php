<?php
namespace CFX;

/**
 * AssetInterface
 *
 * An interface describing a modern CFX Brokerage Asset object
 */
interface AssetInterface extends BaseResourceInterface {
    /**
     * Translate $oldObj into the resource on which this method is defined.
     */
    static function fromV1(FactoryInterface $f, $oldObj);

    // Getters

    public function getIssuer();
    public function getName();
    public function getType();
    public function getStatusCode();
    public function getStatusText();
    public function getDescription();


    // Setters

    public function setIssuer($val);
    public function setName($val);
    public function setType($val);
    public function setStatusCode($val);
    public function setStatusText($val);
    public function setDescription($val);
}


