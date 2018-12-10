<?php
namespace CFX\Brokerage;

interface AclEntryInterface {
    public function getPermissions();
    public function getActor();
    public function getTarget();

    public function setPermissions($bitmask);
    public function hasPermissions($bitmask);
    public function setActor(?\CFX\JsonApi\ResourceInterface $r);
    public function setTarget(?\CFX\JsonApi\ResourceInterface $r);
}

