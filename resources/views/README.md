# Blade Templates

The `resources/views` folder contains Laravel Blade templates.

## File and Folder Names

All files and folders use kebab-case names. Extension of Blade templates is `.blade.php`,
while extension of normal PHP templates is `.php`. Extension determines which
template engine will be used.

Example:
- templates/image-preview.blade.php

## Structure

1. **auth**: pages, modals and emails related to user register/login.
  1. **emails**: email templates for login, register, or password reset.
  2. **passwords**: password reset pages.
2. **components**: small parts of UI.
  1. **buttons**
  2. **inputs**
  3. **modals**
3. **errors**: error pages like 404, 403, 503.
4. **layouts**: page layouts to be inherited.
  1. **app**: parts of app layout.
5. **pages**: pages for different routes.
  1. **index.blade.php**: home page.
  2. **city**
  3. **designer**
  4. **image**
  5. **place**
  6. **setting**
  7. **story**
  8. **tag**
  9. **user**
6. **scripts**: generate JavaScript code.
7. **templates**: view templates for front-end MVC.
8. **vendor**: views from vendor packages.
