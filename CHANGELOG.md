## [Unreleased]
### Added
- Symfony 6 support

## [2.0.1] - 2021-11-08
## Changed
- Renamed prefix bundle and extension names `Marfatech` to `MarfaTech`.
- Renamed root config `marfatech_enumer` to `marfa_tech_enumer`.
- Renamed service `marfatech_enumer.enum_registry` to `marfa_tech_enumer.enum_registry`.
- Renamed parameter `marfatech_enumer.source_directories` to `marfa_tech_enumer.source_directories`.
- Renamed parameter `marfatech_enumer.source_classes` to `marfa_tech_enumer.source_classes`.

## [2.0.0] - 2021-10-21
## Changed
- Updated `php` with pattern version `~7.4||~8.0`.
- Updated composer name `wakeapp/enumer-bundle` to `marfatech/enumer-bundle`.
- Updated composer name `wakeapp/enumer` to `marfatech/enumer`.
- Updated `marfatech/enumer` with pattern version `^2.0`.
- [BC BREAK] Refactoring namespace to `MarfaTech`.
- [BC BREAK] Renamed root config `wakeapp_enumer` to `marfatech_enumer`.
- [BC BREAK] Renamed service `wakeapp_enumer.enum_registry` to `wakeapp_enumer.enum_registry`.
- [BC BREAK] Renamed parameter `wakeapp_enumer.source_directories` to `marfatech_enumer.source_directories`.
- [BC BREAK] Renamed parameter `wakeapp_enumer.source_classes` to `marfatech_enumer.source_classes`.

## [1.2.1] - 2021-03-02
### Added
- Support PHP ~8.0.

## [1.2.0] - 2020-09-17
### Added
- Added support Symfony ~5.0

## [1.1.1] - 2020-09-04
### Fixed
- Fixed `required` annotation

## [1.1.0] - 2019-05-17
### Added
- Added possibility for register classes without `EnumerInterface` implementation.
- Added configuration `wakeapp_enumer.source_classes`.
- Added `EnumRegistryService::hasEnum` method.
### Fixed
- Fixed deprecation `symfony/config` since 4.2

## [1.0.0] - 2018-11-16
## Added
- Added `EnumRegistryService` and appropriated service `wakeapp_enumer.enum_registry`.
- Added `LICENSE` file and information about license in every file.
### Changed
- Enum building executed at the container compiling instead runtime.
- Removed redundant class comments.
- Changed bundle configuration: removed `wakeapp_enumer.enum_class` and added `wakeapp_enumer.source_directories`.
### Removed
- Removed `EnumerFactory` and appropriated service `wakeapp_enumer.enumer`.
- Removed `EnumerAwareTrait` and added `EnumRegistryAwareTrait` instead.
### Fixed
- Fixed `PSR-2` code style.

## [0.1.3] - 2018-10-18
### Fixed
- Method `EnumerFactory::create()` to static.
- Add return type Enumer.

## [0.1.2] - 2018-10-05
### Fixed
- Fix trait namespace.

## [0.1.1] - 2018-10-05
### Fixed
- Fix bug namespace.

## [0.1.0] - 2018-10-04
### Added
- First release of this bundle.
