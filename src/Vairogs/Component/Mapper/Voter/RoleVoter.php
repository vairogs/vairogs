<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Mapper\Voter;

use Override;
use ReflectionException;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\AuthenticatedVoter;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Vairogs\Component\Functions\Iteration;
use Vairogs\Component\Mapper\Contracts\MapperInterface;

use function array_key_exists;
use function in_array;
use function property_exists;

#[Autoconfigure(lazy: true)]
class RoleVoter extends Voter
{
    public function __construct(
        private readonly MapperInterface $mapper,
    ) {
    }

    /**
     * @throws ReflectionException
     */
    #[Override]
    protected function supports(
        string $attribute,
        mixed $subject,
    ): bool {
        if (property_exists($this->mapper, 'supportRole') && array_key_exists($subject, $this->mapper->supportRole)) {
            return $this->mapper->supportRole[$subject];
        }

        $reflection = $this->mapper->loadReflection($subject);

        return $this->mapper->saveItem($this->mapper->supportRole, $this->mapper->isResource($reflection->getName()) && [] !== $reflection->getAttributes(IsGranted::class), $subject);
    }

    /**
     * @throws ReflectionException
     */
    #[Override]
    protected function voteOnAttribute(
        string $attribute,
        mixed $subject,
        TokenInterface $token,
    ): bool {
        if (property_exists($this->mapper, 'allowedRole') && array_key_exists($subject, $this->mapper->allowedRole)) {
            return $this->mapper->allowedRole[$subject];
        }

        $reflection = $this->mapper->loadReflection($subject);
        $allowedRoles = [];
        foreach ($reflection->getAttributes(IsGranted::class) as $item) {
            $allowedRoles[] = $item->newInstance()->attribute;
        }

        if (in_array(AuthenticatedVoter::PUBLIC_ACCESS, $allowedRoles, true)) {
            $result = true;
        } else {
            $result = (new class {
                use Iteration\_HaveCommonElements;
            })->haveCommonElements($token->getUser()?->getRoles() ?? [], $allowedRoles);
        }

        return $this->mapper->saveItem($this->mapper->allowedRole, $result, $subject);
    }
}
