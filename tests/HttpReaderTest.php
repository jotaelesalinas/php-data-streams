<?php

declare(strict_types=1);

use JLSalinas\DataStreams\Http\HttpLinesReader;
use JLSalinas\DataStreams\Http\HttpPagesReader;

it('trims blank lines', function (): void {
    expect(iterator_to_array(new HttpLinesReader(['a', ' ', 'b'])))->toBe(['a', 'b']);
});

it('flattens pages', function (): void {
    expect(iterator_to_array(new HttpPagesReader([['a', 'b'], ['c']])))->toBe(['a', 'b', 'c']);
});
