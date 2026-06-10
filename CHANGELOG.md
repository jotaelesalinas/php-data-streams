# Changelog

All notable changes to `php-data-streams` will be documented in this file.

The project follows Keep a Changelog and SemVer.

## Unreleased

## v2.0.0

### Breaking changes

- Package renamed to `jotaelesalinas/php-data-streams`.
- Namespace changed from `JLSalinas\RWGen` to `JLSalinas\DataStreams`.
- Repository restructured into a monorepo with subpackages under `packages/`.

### Added

- `JLSalinas\DataStreams\Core\Reader` and `Writer` added as the common contracts for all packages.
- `Csv\CsvReader::getIterator()` and `Csv\CsvWriter::write()` added under the new namespace for streaming CSV and TSV input/output.
- `Json\JsonReader::getIterator()` added to autodetect JSON Lines, top-level arrays, and top-level objects from the first non-whitespace byte.
- `Json\JsonIncrementalParser::readArray()` and `readObject()` added to stream nested JSON arrays and objects without loading the full file into memory.
- `Xml\XmlReader::getIterator()` and `Xml\XmlWriter::write()` added for record-oriented XML streaming.
- `Kml\KmlWriter::write()` added as a KML writer built on top of `Xml\XmlWriter`.
- `Pdo\PdoReader::getIterator()`, `Http\HttpLinesReader::getIterator()`, `Http\HttpPagesReader::getIterator()`, `Excel\XlsxReader::getIterator()` and `Excel\XlsxSheetLister::listSheets()` added for PDO, HTTP, and XLSX sources.
- Pest coverage added for CSV, JSON, XML, KML, HTTP, PDO, XLSX, and large-file memory behavior.

## v0.5.1

### Changed

- Travis CI and package metadata updated.

## v0.5

### Changed

- `src/Writers/Kml.php` updated the generated KML output used by the demo dataset and refreshed the bundled demo output file.

## v0.4.4

### Fixed

- `GeneratorAggregateHack::send()` now stores the active generator in an instance property instead of a static local variable, fixing cross-instance state leakage when multiple writer instances were used in the same process.

### Changed

- `src/Writers/HtmlTable.php` markup handling updated together with the generator state fix.

## v0.4.3

### Changed

- `src/Writers/Kml.php` updated its output handling and the writer classes were cleaned up accordingly.

## v0.4.2

### Fixed

- `src/Writers/Csv.php` and `src/Writers/Kml.php` received correctness fixes in their output path.
- `src/GeneratorAggregateHack.php` cleanup reduced generator lifecycle issues in writer implementations.

## v0.4.1

### Changed

- `src/Writers/Console.php` added configurable formatting output so console writes can be rendered with different serializers.

## v0.4

### Added

- `src/Writers/ConsoleJson.php`, `ConsoleJsonPretty.php`, and `ConsoleVarDump.php` added as dedicated console writer variants.

### Changed

- `src/Writers/Console.php` stopped carrying all formatting modes internally, moving them into dedicated writer classes.
- `src/Writers/Kml.php` and the writer inheritance model were updated alongside the console writer split.

## v0.3.1

### Changed

- Composer and Travis updated for the release line.

## v0.3.0

### Added

- `league/csv` support added in the package dependencies.

### Changed

- `src/Readers/Csv.php` switched to `league/csv` for CSV parsing.
- `src/Writers/Kml.php` and the writer stack were updated alongside the CSV reader change.

## v0.2.5

### Changed

- README and Travis updated for the 5.6-compatible branch.

## v0.2.4

### Changed

- Tests and CI cleaned up.

## v0.2.3

### Changed

- Lower PHP compatibility removed from Travis settings.

## v0.2.2

### Changed

- PHPUnit and README updated for the package structure.

## v0.2.1

### Changed

- Project metadata and README fixed.

## v0.2.0

### Added

- `src/Writers/ConsoleJson.php`, `ConsoleJsonPretty.php`, and `ConsoleVarDump.php` added to write console output in JSON, pretty JSON, and `var_dump` formats.
- README expanded with the new console output variants and writer usage.

### Changed

- `src/Writers/Console.php` no longer multiplexes JSON, pretty JSON, and `var_dump` formatting in a single class.

## v0.1.1

### Fixed

- `src/Readers/Csv.php::getIterator()` fixed empty-input handling so reading an empty CSV file no longer fails.

## v0.1

### Added

- Initial CSV and writer support added for the original `rwgen` code base.
