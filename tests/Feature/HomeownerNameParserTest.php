<?php

namespace Tests\Feature;

use App\HomeownerNameParser;
use Tests\TestCase;

class HomeownerNameParserTest extends TestCase
{
    /**
     * @param  string  $homeowner
     * @param  array  $expected
     *
     * @dataProvider homeownerProvider
     */
    public function testHomeownerNameParser(string $homeowner, array $expected): void
    {
        $parser = app(HomeownerNameParser::class);

        $this->assertEquals($expected, $parser->parse($homeowner));
    }

    public function homeownerProvider(): array
    {
        return [
            [
                'Mr John Smith',
                [
                    [
                        'title'      => 'Mr',
                        'first_name' => 'John',
                        'initial'    => null,
                        'last_name'  => 'Smith',
                    ],
                ]
            ],
            [
                'Mrs Jane Smith',
                [
                    [
                        'title'      => 'Mrs',
                        'first_name' => 'Jane',
                        'initial'    => null,
                        'last_name'  => 'Smith',
                    ],
                ]
            ],
            [
                'Mister John Doe',
                [
                    [
                        'title'      => 'Mister',
                        'first_name' => 'John',
                        'initial'    => null,
                        'last_name'  => 'Doe',
                    ],
                ]
            ],
            [
                'Mr Bob Lawblaw',
                [
                    [
                        'title'      => 'Mr',
                        'first_name' => 'Bob',
                        'initial'    => null,
                        'last_name'  => 'Lawblaw',
                    ],
                ]
            ],
            [
                'Mr and Mrs Smith',
                [
                    [
                        'title'      => 'Mr',
                        'first_name' => null,
                        'initial'    => null,
                        'last_name'  => 'Smith',
                    ],
                    [
                        'title'      => 'Mrs',
                        'first_name' => null,
                        'initial'    => null,
                        'last_name'  => 'Smith',
                    ],
                ]
            ],
            [
                'Mr Craig Charles',
                [
                    [
                        'title'      => 'Mr',
                        'first_name' => 'Craig',
                        'initial'    => null,
                        'last_name'  => 'Charles',
                    ],
                ]
            ],
            [
                'Mr M Mackie',
                [
                    [
                        'title'      => 'Mr',
                        'first_name' => null,
                        'initial'    => 'M',
                        'last_name'  => 'Mackie',
                    ],
                ]
            ],
            [
                'Mrs Jane McMaster',
                [
                    [
                        'title'      => 'Mrs',
                        'first_name' => 'Jane',
                        'initial'    => null,
                        'last_name'  => 'McMaster',
                    ],
                ]
            ],
            [
                'Mr Tom Staff and Mr John Doe',
                [
                    [
                        'title'      => 'Mr',
                        'first_name' => 'Tom',
                        'initial'    => null,
                        'last_name'  => 'Staff',
                    ],
                    [
                        'title'      => 'Mr',
                        'first_name' => 'John',
                        'initial'    => null,
                        'last_name'  => 'Doe',
                    ],
                ]
            ],
            [
                'Mr Tom Staff and Mr J. Doe',
                [
                    [
                        'title'      => 'Mr',
                        'first_name' => 'Tom',
                        'initial'    => null,
                        'last_name'  => 'Staff',
                    ],
                    [
                        'title'      => 'Mr',
                        'first_name' => null,
                        'initial'    => 'J',
                        'last_name'  => 'Doe',
                    ],
                ]
            ],
            [
                'Mr T. Staff and Mr J Doe',
                [
                    [
                        'title'      => 'Mr',
                        'first_name' => null,
                        'initial'    => 'T',
                        'last_name'  => 'Staff',
                    ],
                    [
                        'title'      => 'Mr',
                        'first_name' => null,
                        'initial'    => 'J',
                        'last_name'  => 'Doe',
                    ],
                ]
            ],
            [
                'Dr P Gunn',
                [
                    [
                        'title'      => 'Dr',
                        'first_name' => null,
                        'initial'    => 'P',
                        'last_name'  => 'Gunn',
                    ],
                ]
            ],
            [
                'Dr & Mrs Joe Bloggs',
                [
                    [
                        'title'      => 'Dr',
                        'first_name' => 'Joe',
                        'initial'    => null,
                        'last_name'  => 'Bloggs',
                    ],
                    [
                        'title'      => 'Mrs',
                        'first_name' => null,
                        'initial'    => null,
                        'last_name'  => 'Bloggs',
                    ],
                ]
            ],
            [
                'Ms Claire Robbo',
                [
                    [
                        'title'      => 'Ms',
                        'first_name' => 'Claire',
                        'initial'    => null,
                        'last_name'  => 'Robbo',
                    ],
                ]
            ],
            [
                'Prof Alex Brogan',
                [
                    [
                        'title'      => 'Prof',
                        'first_name' => 'Alex',
                        'initial'    => null,
                        'last_name'  => 'Brogan',
                    ],
                ]
            ],
            [
                'Mrs Faye Hughes-Eastwood',
                [
                    [
                        'title'      => 'Mrs',
                        'first_name' => 'Faye',
                        'initial'    => null,
                        'last_name'  => 'Hughes-Eastwood',
                    ],
                ]
            ],
            [
                'Mr F. Fredrickson',
                [
                    [
                        'title'      => 'Mr',
                        'first_name' => null,
                        'initial'    => 'F',
                        'last_name'  => 'Fredrickson',
                    ],
                ]
            ],
        ];
    }
}
