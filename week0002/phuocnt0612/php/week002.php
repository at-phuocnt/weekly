<?php

fwrite(STDOUT, 'Please input rows number: ');
fscanf(STDIN, "%d", $rows);

fwrite(STDOUT, 'Please input columns number: ');
fscanf(STDIN, "%d", $cols);

$data = go($rows, $cols);
ksort($data);

foreach ($data as $row) {
    ksort($row);
    foreach ($row as $value) {
        fwrite(STDOUT, $value . ' ');
    }
    fwrite(STDOUT, PHP_EOL);
}

function go($rows, $cols, $index = [], $printNo = 1, &$result = [])
{
    if (!$index) {
        $index = [
            'leftCol'   => 1,
            'rightCol'  => $cols,
            'topRow'    => 1,
            'bottomRow' => $rows,
        ];
    }

    goRight($printNo, $index, $result);
    if (isFinished($index)) {
        return $result;
    }

    goDown($printNo, $index, $result);
    if (isFinished($index)) {
        return $result;
    }

    goLeft($printNo, $index, $result);
    if (isFinished($index)) {
        return $result;
    }

    goUp($printNo, $index, $result);
    if (isFinished($index)) {
        return $result;
    }
    go(null, null, $index, $printNo, $result);

    return $result;
}

;

function goRight(&$printNo, &$index, &$result)
{
    for ($i = $index['leftCol']; $i <= $index['rightCol']; ++$i) {
        $result[$index['topRow']][$i] = $printNo;
        ++$printNo;
    }
    ++$index['topRow'];
}

function goDown(&$printNo, &$index, &$result)
{
    for ($i = $index['topRow']; $i <= $index['bottomRow']; ++$i) {
        $result[$i][$index['rightCol']] = $printNo;
        ++$printNo;
    }
    --$index['rightCol'];
}

function goLeft(&$printNo, &$index, &$result)
{
    for ($i = $index['rightCol']; $i >= $index['leftCol']; --$i) {
        $result[$index['bottomRow']][$i] = $printNo;
        ++$printNo;
    }
    --$index['bottomRow'];
}

function goUp(&$printNo, &$index, &$result)
{
    for ($i = $index['bottomRow']; $i >= $index['topRow']; --$i) {
        $result[$i][$index['leftCol']] = $printNo;
        ++$printNo;
    }
    ++$index['leftCol'];
}

function isFinished($index)
{
    if ($index['topRow'] > $index['bottomRow'] || $index['leftCol'] > $index['rightCol']) {
        return true;
    }
    return false;
}