<?php

require_once './utils/require.php';

// Get file contents and count rows
$input = file_get_contents('./inputs/02.txt');
$rows = count(explode("\n", $input));

// Test input with this holy jolly mighty grouping pattern
$pattern = "/((\d{1,2}-?){2}) (\w): (\w+)\n?/";
$matches = [];
if (!preg_match_all($pattern, $input, $matches)) {
    exit('REGEXP ERROR');
}

// Get parameters from matches
$limits = $matches[ADVENT_02_REGEXP_MATCH_GROUP_LIMITS];
$characters = $matches[ADVENT_02_REGEXP_MATCH_GROUP_CHARACTER];
$passwords = $matches[ADVENT_02_REGEXP_MATCH_GROUP_PASSWORD];

// Filter valid passwords
$validPasswords = array_filter(
    $passwords,
    function($password, $index) use ($limits, $characters)
    {
        $occurrences = substr_count($password, $characters[$index]);
        $limit = explode("-", $limits[$index]);

        return $occurrences >= $limit[0]
            && $occurrences <= $limit[1];
    },
    ARRAY_FILTER_USE_BOTH
);

// Output answer
echo "\n02A: There are " . count($validPasswords) . " valid passwords";
