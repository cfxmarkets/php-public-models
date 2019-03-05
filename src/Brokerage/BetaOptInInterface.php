<?php
namespace CFX\Brokerage;

interface BetaOptInInterface {
    public function getOptIn();
    public function getUpdatedOn();
    public function getUser();
    public function getRelease();

    public function setOptIn($val);
}

