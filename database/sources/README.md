# Data Sources

Here are some data source files could be imported into database in some way.

## `cities15000.txt`

Contain 23499 cities with more than 15000 population. This is almost the big city
list we will need in our database.

Downloaded from [GeoNames](http://download.geonames.org/export/dump/) on May 21,
2016.

Every row is a city record, columns separated by tabs.

1.  *GeoNames ID*
2.  *Name*
3.  ASCII name
4.  *Alternative names*, translations and aliases
5.  *latitude*
6.  *longitude*
7.  feature class
8.  feature code
9.  *country code*
10. CC2
11. admin1 code
12. admin2 code
13. admin3 code
14. admin4 code
15. population
16. elevation
17. gtopo30
18. *Timezone*
19. modification date

*Italic fields* are what we need to import. Alternative names can be imported as
content and be modified in future.

See <http://stackoverflow.com/questions/5286943>

