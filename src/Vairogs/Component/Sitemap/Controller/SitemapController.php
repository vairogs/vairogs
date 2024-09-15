<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Sitemap\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Vairogs\Component\Sitemap\Contracts\ProviderInterface;

#[Route(path: '/sitemap.xml', defaults: ['_format' => 'xml'], methods: [Request::METHOD_GET])]
class SitemapController extends AbstractController
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly ?ProviderInterface $provider = null,
    ) {
    }

    public function __invoke(
        Request $request,
    ): Response {
        dd($request);
    }
}
