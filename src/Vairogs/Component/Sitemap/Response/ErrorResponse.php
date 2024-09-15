<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Sitemap\Response;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Vairogs\Component\Functions\Web;

readonly class ErrorResponse
{
    private Response $response;

    public function __construct(
        private ConstraintViolationListInterface $violations,
    ) {
        $this->response = new Response();
        $this->response->headers->set('Content-Type', Web::XML);
        $this->response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function getResponse(): Response
    {
        $buffer = '<?xml version="1.0" encoding="UTF-8"?>
<errors>
';

        foreach ($this->violations as $violation) {
            /* @var ConstraintViolation $violation */
            $buffer .= "\t" . '<error>' .
                "\n\t\t" . '<property_path>' . $violation->getPropertyPath() . '</property_path>' .
                "\n\t\t" . '<message>' . $violation->getMessage() . '</message>' .
                "\n\t" . '</error>' . "\n";
        }

        $buffer .= '</errors>';

        $this->response->setContent($buffer);

        return $this->response;
    }
}
