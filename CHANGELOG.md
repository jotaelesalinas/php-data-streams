# Changelog

## v2.0.0 - Unreleased

### Breaking changes

- The package is being relaunched as `jotaelesalinas/php-data-streams`.
- The namespace is moving from `JLSalinas\RWGen` to `JLSalinas\DataStreams`.
- The repository is being restructured into a monorepo with subpackages under `packages/`.

### Added

- `core` reader and writer contracts.
- CSV and JSON Lines implementations under the new namespace.
- Initial PHPUnit coverage for the new stream contracts.
