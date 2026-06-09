# kml

KML output built on top of the XML writer by composition.

`kml` is a tiny convenience package for generating KML documents with the XML writer underneath.

## Features

- Write KML placemarks from associative arrays.
- Reuse the XML streaming writer while hard-coding the KML root and record element names.
- Keep the public API intentionally small.

## Usage

```php
use JLSalinas\DataStreams\Kml\KmlWriter;

$writer = new KmlWriter(__DIR__ . '/places.kml');
$writer->write(['name' => 'Madrid', 'description' => 'Capital of Spain']);
$writer->close();
```

## Notes

- The writer expects associative arrays.
- Every record is emitted as a `Placemark`.
- The root element is `kml`.
