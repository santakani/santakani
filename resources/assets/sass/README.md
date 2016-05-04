# SASS Folder Structure

## app.scss

This is the main control file. It imports all other SASS files and compile to one
single CSS in `public/css/app.css`.

## editor.scss

Generate content only style for WYSIWYG editor (TinyMCE).

## base

Contain variables, mixins, functions and helpers.

## component

Contain styles for small elements, like button, gallery.

## layout

Contain styles for layout sections, like navbar, header, footer, grid, sidebar.

## page

Contain styles for specific pages.

## vendor

Contain styles for third-party libraries, like Bootstrap, Select2, TinyMCE.
