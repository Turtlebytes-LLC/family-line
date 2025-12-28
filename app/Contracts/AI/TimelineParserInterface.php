<?php

namespace App\Contracts\AI;

interface TimelineParserInterface
{
    /**
     * Parse a natural language description into timeline entry data.
     *
     * @param string $text The natural language description
     * @return array{
     *     title: string,
     *     event_type: string,
     *     event_date: ?string,
     *     event_end_date: ?string,
     *     location: ?string,
     *     content: ?string,
     *     people_involved: array,
     *     missing_fields: array,
     *     confidence: float
     * }
     */
    public function parse(string $text): array;

    /**
     * Ask follow-up questions for missing information.
     *
     * @param array $currentData Current parsed data
     * @param array $missingFields Fields that need more information
     * @return array{question: string, field: string, suggestions: array}
     */
    public function askFollowUp(array $currentData, array $missingFields): array;
}
