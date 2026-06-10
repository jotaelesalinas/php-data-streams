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

- `JLSalinas\DataStreams\Core\Reader` and `JLSalinas\DataStreams\Core\Writer` added as the common contracts for all packages.
- `Csv\CsvReader` and `Csv\CsvWriter` added for streaming CSV and TSV input/output.
- `Json\JsonLinesReader`, `Json\JsonArrayReader`, `Json\JsonObjectReader`, `Json\JsonLinesWriter`, `Json\JsonArrayWriter`, `Json\JsonObjectWriter`, and `Json\JsonIncrementalParser` added for JSON streaming.
- `Xml\XmlReader` and `Xml\XmlWriter` added for record-oriented XML streaming.
- `Kml\KmlWriter` added as a KML writer built on top of `Xml\XmlWriter`.
- `Pdo\PdoReader`, `Http\HttpLinesReader`, `Http\HttpPagesReader`, `Excel\XlsxReader`, and `Excel\XlsxSheetLister` added for PDO, HTTP, and XLSX sources.
- Pest coverage added for CSV, JSON, XML, KML, HTTP, PDO, XLSX, and large-file memory behavior.

## v0.5

### Changed

- `Kml\KmlWriter` output was updated for the demo dataset and the bundled demo file was refreshed.

## v0.4.4

### Fixed

- `GeneratorAggregateHack` now stores the active generator in an instance property instead of a static local variable, fixing cross-instance state leakage when multiple writer instances were used in the same process.

### Changed

- `HtmlTable` markup handling was updated together with the generator state fix.

## v0.4.3

### Changed

- `Kml\KmlWriter` output handling was updated and the writer classes were cleaned up accordingly.

## v0.4.2

### Fixed

- `Csv\CsvWriter` and `Kml\KmlWriter` received correctness fixes in their output path.
- `GeneratorAggregateHack` cleanup reduced generator lifecycle issues in writer implementations.

## v0.4.1

### Changed

- `Console` output became configurable so writes can be rendered with different serializers.

## v0.4

### Added

- `ConsoleJson`, `ConsoleJsonPretty`, and `ConsoleVarDump` added as dedicated console writer variants.

### Changed

- `Console` formatting modes were moved into dedicated writer classes.
- The writer inheritance model was updated alongside the `Console` writer split.

## v0.3.0

### Added

- `league/csv` support added in the package dependencies.

### Changed

- `Csv\CsvReader` switched to `league/csv` for CSV parsing.
- The writer stack was updated alongside the CSV reader change.

## v0.2.0

### Added

- `ConsoleJson`, `ConsoleJsonPretty`, and `ConsoleVarDump` added to write console output in JSON, pretty JSON, and `var_dump` formats.
- README expanded with the new console output variants and writer usage.

### Changed

- `Console` formatting is no longer multiplexed in a single class.

## v0.1.1

### Fixed

- `Csv\CsvReader` empty-input handling was fixed.

## v0.1

### Added

- Initial CSV and writer support added for the original `rwgen` code base.
