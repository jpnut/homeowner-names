<?php

namespace App;

use App\Contracts\HomeownerNameParser as HomeownerNameParserContract;

class HomeownerNameParser implements HomeownerNameParserContract
{
    const TITLES = [
        'mr',
        'mrs',
        'ms',
        'mister',
        'dr',
        'prof',
    ];

    const CONJUNCTIONS = [
        'and',
        '&',
    ];

    public function parse(string $homeowners): array
    {
        $people = [];

        $segments = $this->segment($homeowners);

        for ($i = 0; $i < count($segments); $i++) {
            $segment = $segments[$i];

            $has_names = $segment['name_parts'] > 0;

            /**
             * If the current segment has no names, use the names from the next segment instead
             */
            $names = $has_names ? $segment['names'] : $segments[$i + 1]['names'];

            /**
             * The segment only contains a first name if there is more than 1 name
             */
            $has_first_name = count($names) > 1;

            /**
             * If we are taking the first name from the next segment, remove that first name from that segment so that
             * it is only used once
             */
            if (!$has_names && $has_first_name) {
                $segments[$i + 1]['names'] = array_slice($segments[$i + 1]['names'], 1);
            }

            $people[] = [
                'title'      => $segment['title'],
                'first_name' => $has_first_name ? $names[0] : null,
                'initial'    => $segment['initial'],
                'last_name'  => $has_first_name ? $names[1] : $names[0],
            ];
        }

        return $people;
    }

    private function segment(string $homeowners): array
    {
        $parts = explode(" ", $homeowners);

        $segments = [
            $this->createSegment(),
        ];
        $segment = 0;

        foreach ($parts as $part) {
            /**
             * Create a new segment for every conjunction
             */
            if ($this->isConjunction(strtolower($part))) {
                $segments[] = $this->createSegment();
                $segment++;

                continue;
            }

            if (empty($part)) {
                continue;
            }

            if ($this->isTitle(strtolower($part))) {
                $segments[$segment]['title'] = $part;

                continue;
            }

            if ($this->isInitial(strtolower($part))) {
                $segments[$segment]['initial'] = str_replace('.', '', $part);
                $segments[$segment]['name_parts']++;

                continue;
            }

            $segments[$segment]['names'][] = $part;
            $segments[$segment]['name_parts']++;
        }

        return $segments;
    }

    private function createSegment(): array
    {
        return [
            'title'      => null,
            'initial'    => null,
            'names'      => [],
            'name_parts' => 0,
        ];
    }

    private function isTitle(string $part): bool
    {
        return in_array($part, self::TITLES);
    }

    private function isConjunction(string $part): bool
    {
        return in_array($part, self::CONJUNCTIONS);
    }

    private function isInitial(string $part): bool
    {
        return strlen(str_replace('.', '', $part)) === 1;
    }
}
