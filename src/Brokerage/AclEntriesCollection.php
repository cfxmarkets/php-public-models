<?php
namespace CFX\Brokerage;

class AclEntriesCollection extends \CFX\JsonApi\ResourceCollection
{
    /**
     * Searches all available AclEntries in collection for one that matches the given actor and target and then checks permissions
     *
     * @param string $actorType
     * @param string $actorId
     * @param string $targetType
     * @param string $targetId
     * @param int $permissions A bitmask defining the permissions to check
     */
    public function actorHasPermissionsOnTarget(string $actorType, string $actorId, string $targetType, string $targetId, int $permissions)
    {
        foreach($this->elements as $k => $v) {
            if (
                $v->getActor()->getResourceType() === $actorType &&
                $v->getActor()->getId() === $actorId &&
                $v->getTarget()->getResourceType() === $targetType &&
                $v->getTarget()->getId() === $targetId &&
                $v->hasPermissions($permissions)
            ) {
                return true;
            }
        }

        return false;
    }
}
