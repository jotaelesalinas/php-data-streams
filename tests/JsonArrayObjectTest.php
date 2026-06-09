<?php

declare(strict_types=1);

use JLSalinas\DataStreams\Json\JsonArrayReader;
use JLSalinas\DataStreams\Json\JsonArrayWriter;
use JLSalinas\DataStreams\Json\JsonObjectReader;
use JLSalinas\DataStreams\Json\JsonObjectWriter;
use JLSalinas\DataStreams\Json\JsonReader;

it('round trips json arrays', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'jsona');
    $writer = new JsonArrayWriter($file);

    $writer->write(['name' => 'Ada']);
    $writer->write(['name' => 'Bob']);
    $writer->close();

    expect(iterator_to_array(new JsonArrayReader($file)))->toBe([
        ['name' => 'Ada'],
        ['name' => 'Bob'],
    ]);

    expect(iterator_to_array(new JsonReader($file)))->toBe([
        ['name' => 'Ada'],
        ['name' => 'Bob'],
    ]);
});

it('round trips json objects', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'jsono');
    $writer = new JsonObjectWriter($file);

    $writer->write(['name', 'Ada']);
    $writer->write(['age', 37]);
    $writer->close();

    expect(iterator_to_array(new JsonObjectReader($file)))->toBe([
        'name' => 'Ada',
        'age' => 37,
    ]);

    expect(iterator_to_array(new JsonReader($file)))->toBe([
        'name' => 'Ada',
        'age' => 37,
    ]);
});

it('reads json arrays without line breaks and with nested values', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'jsona');
    $payload = [
        'first, value',
        ['nested' => ['a' => 1, 'b' => [2, 3]]],
        ['quote' => 'He said "hi" and left'],
        str_repeat('x', 6000),
    ];

    file_put_contents($file, json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));

    expect(iterator_to_array(new JsonArrayReader($file)))->toBe($payload);
    expect(iterator_to_array(new JsonReader($file)))->toBe($payload);
});

it('reads json objects without line breaks and with nested values', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'jsono');
    $payload = [
        'first,key' => 'value:with:colons',
        'nested' => ['a' => 1, 'b' => [2, 3]],
        'quote' => 'He said "hi" and left',
        'large' => str_repeat('y', 6000),
    ];

    file_put_contents($file, json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));

    expect(iterator_to_array(new JsonObjectReader($file)))->toBe($payload);
    expect(iterator_to_array(new JsonReader($file)))->toBe($payload);
});

it('rejects invalid json arrays', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'jsona');
    file_put_contents($file, '[1, 2');

    iterator_to_array(new JsonArrayReader($file));
})->throws(RuntimeException::class);

it('rejects invalid json objects', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'jsono');
    file_put_contents($file, '{"a": 1');

    iterator_to_array(new JsonObjectReader($file));
})->throws(RuntimeException::class);
