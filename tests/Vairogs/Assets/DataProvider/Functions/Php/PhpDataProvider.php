<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Assets\DataProvider\Functions\Php;

use Vairogs\Assets\Model\Functions\Php\ParentTestClass;

class PhpDataProvider
{
    public static function provideBindMethod(): array
    {
        $testObject = new class {
            private string $value = 'test';

            private function getValue(): string
            {
                return $this->value;
            }
        };

        return [
            'bind to private method' => [
                fn () => $this->getValue(),
                $testObject,
                'test',
            ],
        ];
    }

    public static function provideGetMethod(): array
    {
        $testObject = new class {
            private string $initialized = 'test';
            private string $uninitialized;
            public string $public = 'public test';
            protected string $protected = 'protected test';
        };

        return [
            'test initialized property' => [
                $testObject,
                'initialized',
                false,
                'test',
                false,
            ],
            'test uninitialized property without throw' => [
                $testObject,
                'uninitialized',
                false,
                null,
                false,
            ],
            'test uninitialized property with throw' => [
                $testObject,
                'uninitialized',
                true,
                null,
                true,
            ],
            'test public property' => [
                $testObject,
                'public',
                false,
                'public test',
                false,
            ],
            'test protected property' => [
                $testObject,
                'protected',
                false,
                'protected test',
                false,
            ],
            'test non-existent property' => [
                $testObject,
                'nonexistent',
                false,
                null,
                true,
            ],
        ];
    }

    public static function provideGetNonStaticMethod(): array
    {
        return [
            'non-static public property' => [new class {
                public string $property = 'public';
            }, 'property', 'public', false],
            'non-static protected property' => [new class {
                protected string $property = 'protected';
            }, 'property', 'protected', false],
            'non-static private property' => [new class {
                private string $property = 'private';
            }, 'property', 'private', false],
            'uninitialized non-static property' => [new class {
                public ?string $property = null;
            }, 'property', null, false],
            'static property' => [new class {
                public static string $property = 'static';
            }, 'property', null, true],
            'non-existent property' => [new class {
            }, 'property', null, true],
        ];
    }

    public static function provideGetStaticMethod(): array
    {
        $testClass1 = new class {
            public static string $property = 'public';
        };
        $testClass2 = new class {
            protected static string $property = 'protected';
        };
        $testClass3 = new class {
            private static string $property = 'private';
        };
        $testClass4 = new class {
            public static ?string $uninitializedProperty = null;
        };
        $testClass5 = new class {
            public string $property = 'non-static';
        };
        $testClass6 = new class {
        };
        $testClass7 = new class extends ParentTestClass {
        };

        return [
            'public static property' => [
                $testClass1,
                'property',
                'public',
                false,
            ],
            'protected static property' => [
                $testClass2,
                'property',
                'protected',
                false,
            ],
            'private static property' => [
                $testClass3,
                'property',
                'private',
                false,
            ],
            'uninitialized public static property' => [
                $testClass4,
                'uninitializedProperty',
                null,
                false,
            ],
            'non-static property' => [
                $testClass5,
                'property',
                null,
                true,
            ],
            'non-existent property' => [
                $testClass6,
                'property',
                null,
                true,
            ],
            'inherited static property' => [
                $testClass7,
                'inheritedStaticProperty',
                'inherited value',
                false,
            ],
        ];
    }

    public static function provideReturnMethod(): array
    {
        $testObject = new class {
            private string $value = 'test';

            public function getValue(): string
            {
                return $this->value;
            }

            public function addValue(
                string $suffix,
            ): string {
                return $this->value . $suffix;
            }
        };

        return [
            'simple return' => [
                fn () => $testObject->getValue(),
                $testObject,
                [],
                'test',
            ],
            'return with arguments' => [
                fn (string $suffix) => $testObject->addValue($suffix),
                $testObject,
                ['_suffix'],
                'test_suffix',
            ],
        ];
    }

    public static function provideSetMethod(): array
    {
        return [
            'set public property' => [new class {
                public string $property = '';
            }, 'property', 'test value', false],
            'set protected property' => [new class {
                protected string $property = '';
            }, 'property', 'test value', false],
            'set private property' => [new class {
                private string $property = '';
            }, 'property', 'test value', false],
            'set non-existent property' => [new class {
            }, 'property', 'test value', true],
        ];
    }

    public static function provideSetNonStaticMethod(): array
    {
        return [
            'set non-static public property' => [new class {
                public string $property = '';
            }, 'property', 'test value', false],
            'set non-static protected property' => [new class {
                protected string $property = '';
            }, 'property', 'test value', false],
            'set non-static private property' => [new class {
                private string $property = '';
            }, 'property', 'test value', false],
            'set static property' => [new class {
                public static string $property = '';
            }, 'property', 'test value', true],
            'set non-existent property' => [new class {
            }, 'property', 'test value', true],
        ];
    }

    public static function provideSetStaticMethod(): array
    {
        $testClass1 = new class {
            public static string $property = '';
        };
        $testClass2 = new class {
            protected static string $property = '';
        };
        $testClass3 = new class {
            private static string $property = '';
        };
        $testClass4 = new class {
            public string $property = '';
        };
        $testClass5 = new class {
        };

        return [
            'set static public property' => [
                $testClass1,
                'property',
                'test value',
                false,
            ],
            'set static protected property' => [
                $testClass2,
                'property',
                'test value',
                false,
            ],
            'set static private property' => [
                $testClass3,
                'property',
                'test value',
                false,
            ],
            'set non-static property' => [
                $testClass4,
                'property',
                'test value',
                true,
            ],
            'set non-existent property' => [
                $testClass5,
                'property',
                'test value',
                true,
            ],
        ];
    }
}
