<?php

declare(strict_types=1);

use JLSalinas\DataStreams\Core\ConsoleWriter;

it('formats arrays as json', function (): void {
    $stream = fopen('php://temp', 'wb+');
    $writer = new ConsoleWriter($stream);

    $writer->write(['name' => 'Ada']);

    rewind($stream);
    expect(stream_get_contents($stream))->toBe('{"name":"Ada"}' . PHP_EOL);
});
