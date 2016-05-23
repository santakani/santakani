# Data Sources

Here are some data source files could be imported into database in some way.

## `countries.json`

Contains 240+ countries and areas. We need to filter some islands and other low
population areas.

Fetched from <https://github.com/mledoze/countries> with own Chinese translation.

Format:

- `name`
    - `common` - common name in english
    - `official` - official name in english
    - `native` - list of all native names
        - key: three-letter ISO 639-3 language code
        - value: name object
            + key: official - official name translation
            + key: common - common name translation
- country code top-level domain (`tld`)
- code ISO 3166-1 alpha-2 (`cca2`)
- code ISO 3166-1 numeric (`ccn3`)
- code ISO 3166-1 alpha-3 (`cca3`)
- code International Olympic Committee (`cioc`)
- ISO 4217 currency code(s) (`currency`)
- calling code(s) (`callingCode`)
- capital city (`capital`)
- alternative spellings (`altSpellings`)
- region
- subregion
- list of official languages (`languages`)
- key: three-letter ISO 639-3 language code
- value: name of the language in english
- list of name translations (`translations`)
- key: three-letter ISO 639-3 language code
- value: name object
    + key: official - official name translation
    + key: common - common name translation
- latitude and longitude (`latlng`)
- name of residents (`demonym`)
- landlocked status (`landlocked`)
- land borders (`borders`)
- land area in km² (`area`)

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

