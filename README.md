# Custom Post Type Jobs

A custom post type for job offers

## Supports

* Title
* Editor
* Custom taxonomy `job-category`

## Custom Fields

* Job starting date

## Language Support

* english
* german

## Hooks

### Actions

* `job-meta-table-before` - Before the post meta table
* `job-meta-table-before` - First row in the post meta table
* `job-meta-table-before` - Last row in the post meta table
* `job-meta-table-before` - After the post meta table

### Filters

* `save-job-meta` - Filter the meta data

## Changelog

### v0.4

* Enhancement: Passing $post_id to `save-job-meta`

### v0.3

* Enhancement: Security
* Enhancement: Function comments cleanup

### v0.2

* Added: Job offer starting date

### v0.1

* Initial release

