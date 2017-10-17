<?php
namespace CFX\Brokerage;

interface AuthzDatasourceInterface {
    function getAuthGrantsFor($type, $key);
}

