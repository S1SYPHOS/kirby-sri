<?php

namespace Kirby\Plugins\SRI;

use c;

// Helper function generating base64-encoded SRI hashes
function sri_checksum($input)
{
    $algorithm = c::get('plugin.kirby-sri.algorithm', 'sha512');
    $hash = hash($algorithm, $input, true);
    $hash_base64 = base64_encode($hash);

    return "$algorithm-$hash_base64";
}
