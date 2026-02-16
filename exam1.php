<?php

$jsonData = file_get_contents('dataset.json');
$data = json_decode($jsonData, true);

$qualifiedPeople = [];

foreach ($data as $person) {
    $isMarried = isset($person['spouse']) && $person['spouse'] !== null;
    $hasChildren = isset($person['children']) && count($person['children']) > 0;
    $hasSiblings = false;

    foreach ($data as $otherPerson) {
        if (
            $person['id'] !== $otherPerson['id'] &&
            $person['last_name'] === $otherPerson['last_name']
        ) {
            $hasSiblings = true;
            break;
        }
    }

    if ($isMarried && $hasChildren && $hasSiblings) {
        $qualifiedPeople[] = $person;
    }
}

echo "\nMARRIED PEOPLE WITH CHILDREN AND SIBLINGS\n";
echo "Found " . count($qualifiedPeople) . " people matching criteria:\n\n";

foreach ($qualifiedPeople as $person) {

    echo "Name: " .
        $person['first_name'] . " " .
        $person['middle_name'] . " " .
        $person['last_name'] . "\n";

    echo "Spouse: " . $person['spouse']['name'] . "\n";
    echo "Number of Children: " . count($person['children']) . "\n";

    echo "Siblings:\n";
    foreach ($data as $otherPerson) {
        if (
            $person['id'] !== $otherPerson['id'] &&
            $person['last_name'] === $otherPerson['last_name']
        ) {
            echo " - " . $otherPerson['first_name'] . " " . $otherPerson['last_name'] . "\n";
        }
    }

    echo "\n";
}

?>