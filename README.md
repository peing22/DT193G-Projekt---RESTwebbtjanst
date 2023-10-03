# DT193G Projekt - Laravel REST-webbtjänst
Detta repo innehåller en REST-webbtjänst skapad med backendramverket Laravel.

REST-webbtjänsten hanterar data om ett företags olika produkter och har implementerad CRUD-funktionalitet som möjliggör utläsning, tillägg, ändring och radering av data från en tabell i en databas. Varje produkt i tabellen relaterar till en specifik produktkategori i en annan tabell i databasen. Det är även möjligt att läsa ut, lägga till och radera data från tabellen som lagrar produktkategorier. Nedan redogörs mer ingående för respektive tabell.

Data presenteras i JSON-format.

För att kunna hantera data i REST-webbtjänsten krävs autentisering. Det innebär att en användare måste registrera ett konto eller logga in med befintliga kontouppgifter för att kunna nyttja REST-webbtjänstens alla delar.

## Tabellen "categories"
Utöver de kolumner som ingår vid migrering, innehåller tabellen även kolumnen *name* (textsträng). Ett värde för denna kolumn måste anges när en kategori ska läggas till.

## Tabellen "products"
Utöver de kolumner som ingår vid migrering, innehåller tabellen även kolumnerna *category_id* (bigInteger), *name* (string och max 64 tecken), *description* (longText), *image* (string och max 2048kb), *price* (integer) och *quantity* (integer). Ett värde måste anges för kolumnerna *name* och *quantity* när en produkt ska läggas till, för övriga kolumner är det valfritt att ange värden. 

I kolumnen *image* lagras den fullständiga sökvägen till uppladdade bildfiler.

## Routes
  GET|HEAD  api/category
  POST      api/category
  PUT       api/category/{categoryId}/product/{productId}
  DELETE    api/category/{id}
  POST      api/login
  POST      api/logout
  GET|HEAD  api/product
  GET|HEAD  api/product/search/name/{name}
  GET|HEAD  api/product/{id}
  POST      api/product/{id}
  PUT       api/product/{id}
  DELETE    api/product/{id}
  GET|HEAD  api/productsbycat/{id}
  POST      api/register