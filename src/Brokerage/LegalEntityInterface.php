<?php
namespace CFX\Brokerage;

interface LegalEntityInterface extends \CFX\JsonApi\ResourceInterface {
    

    // Getters
    public function getType();
    public function getName();
    public function getFinraAffiliated();
    public function getDocuments();


    // Setters
    public function setType($val);
    public function setName($val);
    public function setFinraAffiliated($val);
    public function setAddress(\CFX\Brokerage\Address $address);