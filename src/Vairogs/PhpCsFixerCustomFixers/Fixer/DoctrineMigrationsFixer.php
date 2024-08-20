<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\PhpCsFixerCustomFixers\Fixer;

use Doctrine\Migrations\AbstractMigration;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;
use Vairogs\PhpCsFixerCustomFixers\PhpCsFixer\AbstractFixer;

use function class_exists;
use function explode;
use function implode;
use function in_array;
use function trim;

use const T_COMMENT;

/**
 * @internal
 */
final class DoctrineMigrationsFixer extends AbstractFixer
{
    public function getDocumentation(): string
    {
        return 'Unnecessary comments MUST BE removed from Doctrine migrations';
    }

    public function getSampleCode(): string
    {
        return <<<'SPEC'
            <?php declare(strict_types=1);

            namespace Doctrine\Migrations;

            use Doctrine\DBAL\Schema\Schema;
            use Doctrine\Migrations\AbstractMigration;

            /**
             * Auto-generated Migration: Please modify to your needs!
             */
            final class VersionTest extends AbstractMigration
            {
                public function getDescription()
                {
                    return '';
                }

                public function up(Schema $schema)
                {
                    // this up() migration is auto-generated, please modify it to your needs
                }

                public function down(Schema $schema)
                {
                    // this down() migration is auto-generated, please modify it to your needs
                }
            }
            SPEC;
    }

    public function isCandidate(
        Tokens $tokens,
    ): bool {
        return class_exists(AbstractMigration::class) && $this->extendsClass($tokens, AbstractMigration::class);
    }

    protected function applyFix(
        SplFileInfo $file,
        Tokens $tokens,
    ): void {
        $this->removeUselessComments($tokens);
    }

    private function removeUselessComments(
        Tokens $tokens,
    ): void {
        $blacklist = [
            'Auto-generated Migration: Please modify to your needs!',
            'this up() migration is auto-generated, please modify it to your needs',
            'this down() migration is auto-generated, please modify it to your needs',
        ];

        foreach ($this->getComments($tokens) as $position => $comment) {
            $lines = explode("\n", $comment->getContent());
            $changed = false;

            foreach ($lines as $index => $line) {
                if (in_array(trim($line, '/* '), $blacklist, true)) {
                    unset($lines[$index]);
                    $changed = true;
                }
            }

            if (false === $changed) {
                continue;
            }

            if (empty(trim(implode("\n", $lines), " /*\n"))) {
                $tokens->clearAt($position);
                $tokens->removeTrailingWhitespace($position);

                continue;
            }

            $tokens[$position] = new Token([T_COMMENT, implode("\n", $lines)]);
        }
    }
}
