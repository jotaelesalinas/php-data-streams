# Changelog

All notable changes to `php-data-streams` will be documented in this file.

The project follows Keep a Changelog and SemVer.

## Unreleased

## v2.0.0

### Breaking changes

- The package is being relaunched as `jotaelesalinas/php-data-streams`.
- The namespace is moving from `JLSalinas\RWGen` to `JLSalinas\DataStreams`.
- The repository is being restructured into a monorepo with subpackages under `packages/`.

### Added

- `core` reader and writer contracts.
- CSV and JSON Lines implementations under the new namespace.
- XML and KML streaming packages.
- PDO, HTTP, and XLSX-oriented packages.
- Initial Pest coverage for the new stream contracts.

## v0.5.1

### Changed

- Travis CI cleanup and package metadata adjustments.

## v0.5

### Changed

- KML writer cleanup and output refinements.

## v0.4.4

### Changed

- HTML table writer cleanup and generator handling fixes.

## v0.4.3

### Changed

- KML writer behavior and writer class cleanup.

## v0.4.2

### Changed

- CSV and KML writer fixes plus generator-hack cleanup.

## v0.4.1

### Changed

- Console writer formatting improvements.

## v0.4

### Added

- Separate console writers for JSON, pretty JSON, and var dump output.

### Changed

- The KML writer and writer inheritance model were refined.

## v0.3.1

### Changed

- Composer and Travis updates for the release line.

## v0.3.0

### Added

- Support for `league/csv`.

### Changed

- Writer and generator handling were updated to support the CSV dependency.

## v0.2.5

### Changed

- README and Travis updates for the 5.6-compatible branch.

## v0.2.4

### Changed

- Test and CI cleanup.

## v0.2.3

### Changed

- Lower PHP compatibility was removed from Travis settings.

## v0.2.2

### Changed

- PHPUnit and README updates for the current package structure.

## v0.2.1

### Changed

- Project metadata and small README fixes.

## v0.2.0

### Added

- JSON Lines support.
- The first relaunch documentation for the new package layout.

### Changed

- The tree started moving toward the current package split.

## v0.1.1

### Fixed

- CSV reader and writer edge cases.

## v0.1

### Added

- Initial CSV and writer support for the original `rwgen` code base.
