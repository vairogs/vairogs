<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Sitemap\Builder;

use InvalidArgumentException;
use Vairogs\Component\Sitemap\Contracts\Builder;

use function gettype;
use function sprintf;

final class Director
{
    public function __construct(
        private mixed $buffer,
    ) {
    }

    public function build(
        Builder $builder,
    ): mixed {
        if (($type = $builder->getType()) !== ($actual = gettype(value: $this->buffer))) {
            throw new InvalidArgumentException(message: sprintf('Director __constructor parameter must be %s, %s given', $type, $actual));
        }

        $builder->start(buffer: $this->buffer);
        $builder->build(buffer: $this->buffer);
        $builder->end(buffer: $this->buffer);

        return $this->buffer;
    }
}
