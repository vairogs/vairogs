<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Component\Functions\Local;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

use function explode;
use function preg_match;
use function trim;

trait _CurlUA
{
    public function getCurlUserAgent(): string
    {
        $process = new Process(['curl', '--version']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output = trim(explode("\n", $process->getOutput(), 2)[0]);

        if (preg_match('/curl\s([\d.]+(?:-DEV)?)/', $output, $matches)) {
            return 'curl/' . $matches[1];
        }

        return $output;
    }
}
