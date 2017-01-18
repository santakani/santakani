# SVG Sprite Source

SVG files in this directory will be compiled into one single SVG. We can embed
it in web pages and refer all icons by id. See https://css-tricks.com/svg-sprites-use-better-icon-fonts/

The largest benefit of SVG sprites is that you can use CSS to define SVG styles.
This is what icon fonts cannot do. You can still set icon size based on font size.

If source file is `home.svg`, then you can use it in HTML as:

```xml
<svg style="width: .75em; height: .75em">
  <use xlink:href="svg/sprites.svg#home"/>
</svg>
```
