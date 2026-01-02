# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [Current Version]

### Added
- Initial release
- Support for custom paths in resource routes (`Route::resource()`)
- Support for custom paths in singleton resource routes (`Route::singleton()`)
- Global path configuration via `Route::resourcePaths()` and `Route::singletonPaths()`
- Per-resource path customization via `paths()` method
- Support for `Route::resources()` macro to register multiple resources with shared paths
- Automatic service provider registration
- Laravel 10.x, 11.x, and 12.x compatibility

### Changed
- N/A

### Deprecated
- N/A

### Removed
- N/A

### Fixed
- N/A

### Security
- N/A
