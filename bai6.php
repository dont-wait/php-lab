<?php
function isPrime($n) {
    if ($n < 2) {
        return false;
    }

    if ($n === 2) {
        return true;
    }

    if ($n % 2 === 0) {
        return false;
    }

    $limit = floor(sqrt($n));
    for ($i = 3; $i <= $limit; $i += 2) {
        if ($n % $i === 0) {
            return false;
        }
    }

    return true;
}

for ($x = 1; $x <= 100; $x++) {
    if (isPrime($x)) {
        echo "$x là số nguyên tố<br>";
    }
}
?>
