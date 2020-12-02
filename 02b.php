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
$positions = $matches[ADVENT_02_REGEXP_MATCH_GROUP_POSITIONS];
$characters = $matches[ADVENT_02_REGEXP_MATCH_GROUP_CHARACTER];
$passwords = $matches[ADVENT_02_REGEXP_MATCH_GROUP_PASSWORD];

// Filter valid passwords
$validPasswords = array_filter(
    $passwords,
    function($password, $index) use ($positions, $characters)
    {
        $currentPositions = explode("-", $positions[$index]);
        $currentCharacter = $characters[$index];

        $earlierMatch = $password[$currentPositions[0] - 1];
        $latterMatch = $password[$currentPositions[1] - 1];

        return $earlierMatch !== $latterMatch && 
            ($earlierMatch === $currentCharacter
                || $latterMatch === $currentCharacter);
    },
    ARRAY_FILTER_USE_BOTH
);

// Output answer
echo "\n02B: There are " . count($validPasswords) . " valid passwords";
