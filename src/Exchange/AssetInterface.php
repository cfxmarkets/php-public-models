<?php
namespace CFX\Exchange;

/**
 * AssetInterface
 *
 * An interface describing a modern CFX Brokerage Asset object
 */
interface AssetInterface extends \CFX\JsonApi\ResourceInterface {
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


