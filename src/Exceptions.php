<?php
namespace CFX\Brokerage;



// Authorization Exceptions

/**
 * A Brokerage Partner has attempted to access functionality that they are not allowed to access
 */
class UnauthorizedPartnerException extends \CFX\AuthzException { }

/**
 * The given OAuth Access Token does not permit access to the requested functionality
 */
class UnauthorizedOAuthException extends \CFX\AuthzException { }


