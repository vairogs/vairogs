<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spaghetti\XLSXParser;

use FilesystemIterator as FI;
use RecursiveDirectoryIterator as RDI;
use RecursiveIteratorIterator as RII;
use Spaghetti\XLSXParser\Exception\InvalidArchiveException;
use ZipArchive;

use function file_exists;
use function is_dir;
use function rmdir;
use function sprintf;
use function sys_get_temp_dir;
use function tempnam;
use function unlink;

/**
 * @internal
 */
final class Archive
{
    private string $tmpPath;
    private ?ZipArchive $zip = null;

    public function __construct(
        private readonly string $archivePath,
    ) {
        $tmpDir = sys_get_temp_dir();

        if (is_dir(filename: '/dev/shm')) {
            $tmpDir = '/dev/shm';
        }

        $this->tmpPath = tempnam(directory: $tmpDir, prefix: 'spaghetti_xlsx_parser_archive');
        unlink(filename: $this->tmpPath);
    }

    public function __destruct()
    {
        $this->deleteTmp();
        $this->closeArchive();
    }

    public function extract(
        string $filePath,
    ): string {
        $tmpPath = sprintf('%s/%s', $this->tmpPath, $filePath);

        if (!file_exists(filename: $tmpPath)) {
            $this->getArchive()->extractTo(pathto: $this->tmpPath, files: $filePath);
        }

        return $tmpPath;
    }

    private function closeArchive(): void
    {
        $this->zip?->close();
        $this->zip = null;
    }

    private function deleteTmp(): void
    {
        if (!file_exists(filename: $this->tmpPath)) {
            return;
        }

        $files = new RII(iterator: new RDI(directory: $this->tmpPath, flags: FI::SKIP_DOTS), mode: RII::CHILD_FIRST, );

        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir(directory: $file->getRealPath());

                continue;
            }

            unlink(filename: $file->getRealPath());
        }

        rmdir(directory: $this->tmpPath);
    }

    private function getArchive(): ZipArchive
    {
        if (null === $this->zip) {
            $this->zip = new ZipArchive();
            $error = $this->zip->open(filename: $this->archivePath);

            if (true !== $error) {
                $this->zip = null;

                throw new InvalidArchiveException(code: $error);
            }
        }

        return $this->zip;
    }
}
