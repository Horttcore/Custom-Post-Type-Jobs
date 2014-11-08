# Custom Post Type Jobs

A custom post type for job offers

## Supports

* Title
* Editor
* Custom taxonomy `job-category`
* Widget to display jobs

## Custom Fields

* Job starting date

## Language Support

* english
* german

## Hooks

### Actions

#### Meta Box

* `custom-post-type-jobs-meta-box-table-before` - Before the post meta table
* `custom-post-type-jobs-meta-box-table-first-row-before` - First row in the post meta table
* `custom-post-type-jobs-meta-box-table-last-row-after` - Last row in the post meta table
* `custom-post-type-jobs-meta-box-table-after` - After the post meta table

#### Widget

* `custom-post-type-jobs-widget-form-before` - Before widget form
* `custom-post-type-jobs-widget-form-after` - After widget form

* `custom-post-type-jobs-widget-output` - Widget output
* `custom-post-type-jobs-widget-loop-output` - Widget job output in loop

### Filters

#### Meta Box

* `custom-post-type-jobs-save-meta` - Filter the meta data

#### Widget

* `custom-post-type-jobs-widget-form-save` - Save widget
* `custom-post-type-jobs-widget-query` - Save widget

## Changelog

### v0.5

* Added: Widget
* Changed: Renamed actions and filters
* Enhancement: Rewritten plugin base

### v0.4

* Enhancement: Passing $post_id to `save-job-meta`

### v0.3

* Enhancement: Security
* Enhancement: Function comments cleanup

### v0.2

* Added: Job offer starting date

### v0.1

* Initial release

