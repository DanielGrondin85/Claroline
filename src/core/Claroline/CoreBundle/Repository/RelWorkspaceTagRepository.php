<?php
namespace Claroline\CoreBundle\Repository;

use Claroline\CoreBundle\Entity\User;
use Claroline\CoreBundle\Entity\Workspace\AbstractWorkspace;
use Claroline\CoreBundle\Entity\Workspace\WorkspaceTag;
use Doctrine\ORM\EntityRepository;

class RelWorkspaceTagRepository extends EntityRepository
{
    public function findByWorkspaceAndUser(AbstractWorkspace $workspace, User $user)
    {
        $dql = "
            SELECT rwt, t
            FROM Claroline\CoreBundle\Entity\Workspace\RelWorkspaceTag rwt
            JOIN rwt.workspace w
            JOIN rwt.tag t
            JOIN t.user u
            WHERE u.id = :userId
            AND w.id = :workspaceId
        ";
        $query = $this->_em->createQuery($dql);
        $query->setParameter('userId', $user->getId());
        $query->setParameter('workspaceId', $workspace->getId());

        return $query->getResult();
    }

    public function findAdminByWorkspace(AbstractWorkspace $workspace)
    {
        $dql = "
            SELECT rwt, t
            FROM Claroline\CoreBundle\Entity\Workspace\RelWorkspaceTag rwt
            JOIN rwt.workspace w
            JOIN rwt.tag t
            WHERE t.user IS NULL
            AND w.id = :workspaceId
        ";
        $query = $this->_em->createQuery($dql);
        $query->setParameter('workspaceId', $workspace->getId());

        return $query->getResult();
    }

    public function findOneByWorkspaceAndTagAndUser(AbstractWorkspace $workspace, WorkspaceTag $tag, User $user)
    {
        $dql = "
            SELECT rwt
            FROM Claroline\CoreBundle\Entity\Workspace\RelWorkspaceTag rwt
            JOIN rwt.workspace w
            JOIN rwt.tag t
            JOIN t.user u
            WHERE u.id = :userId
            AND w.id = :workspaceId
            AND t.id = :tagId
        ";
        $query = $this->_em->createQuery($dql);
        $query->setParameter('userId', $user->getId());
        $query->setParameter('workspaceId', $workspace->getId());
        $query->setParameter('tagId', $tag->getId());

        return $query->getOneOrNullResult();
    }

    public function findOneAdminByWorkspaceAndTag(AbstractWorkspace $workspace, WorkspaceTag $tag)
    {
        $dql = "
            SELECT rwt
            FROM Claroline\CoreBundle\Entity\Workspace\RelWorkspaceTag rwt
            JOIN rwt.workspace w
            JOIN rwt.tag t
            WHERE t.user IS NULL
            AND w.id = :workspaceId
            AND t.id = :tagId
        ";
        $query = $this->_em->createQuery($dql);
        $query->setParameter('workspaceId', $workspace->getId());
        $query->setParameter('tagId', $tag->getId());

        return $query->getOneOrNullResult();
    }

    public function findAllByWorkspaceAndUser(AbstractWorkspace $workspace, User $user)
    {
        $dql = "
            SELECT rwt, t
            FROM Claroline\CoreBundle\Entity\Workspace\RelWorkspaceTag rwt
            JOIN rwt.workspace w
            JOIN rwt.tag t
            WHERE w.id = :workspaceId
            AND (t.user = :user
            OR t.user IS NULL)
        ";
        $query = $this->_em->createQuery($dql);
        $query->setParameter('workspaceId', $workspace->getId());
        $query->setParameter('user', $user);

        return $query->getResult();
    }
}