<?php
namespace CFX\Brokerage;

interface ReleaseInterface {
    public function getBetaStartDate();
    public function getReleaseDate();
    public function getCurrentUserOptIn();
}
