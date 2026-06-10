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

- `core` reader and writer contracts added.
- CSV and JSON Lines implementations added under the new namespace.
- XML and KML streaming packages added.
- PDO, HTTP, and XLSX-oriented packages added.
- Initial Pest coverage added for the stream contracts.

## v0.5.1

### Changed

- Travis CI and package metadata updated.

## v0.5

### Changed

- KML writer output refined.

## v0.4.4

### Changed

- HTML table writer and generator handling fixed.

## v0.4.3

### Changed

- KML writer behavior and writer classes cleaned up.

## v0.4.2

### Changed

- CSV and KML writer fixes applied.
- Generator-hack cleanup applied.

## v0.4.1

### Changed

- Console writer formatting improved.

## v0.4

### Added

- Separate console writers for JSON, pretty JSON, and var dump output added.

### Changed

- KML writer and writer inheritance model refined.

## v0.3.1

### Changed

- Composer and Travis updated for the release line.

## v0.3.0

### Added

- Support for `league/csv` added.

### Changed

- Writer and generator handling updated for the CSV dependency.

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

- JSON Lines support added.
- Relaunch documentation for the package layout added.

### Changed

- Package layout updated for the monorepo split.

## v0.1.1

### Fixed

- CSV reader and writer edge cases fixed.

## v0.1

### Added

- Initial CSV and writer support added for the original `rwgen` code base.
