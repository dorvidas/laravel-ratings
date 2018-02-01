# Changelog

All notable changes to `laravel-permission` will be documented in this file

## 1.1.0 - 2018-02-01
- Add ability to prefix tables by changing config `database_prefix`.
- Add `rating_aggregates` table which stores aggregates (count, average).
- Add event `Dorvidas\Ratings\Events\RatingCreatedEvent` when rating is created.
- Add listener `Dorvidas\Ratings\Events\RecalculateRatingAggregatesListener` which updates rating aggregates.