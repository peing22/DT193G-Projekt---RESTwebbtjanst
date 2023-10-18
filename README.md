# DT193G Projekt - Laravel REST-webbtjänst
Detta repo innehåller en REST-webbtjänst skapad med backendramverket Laravel.

REST-webbtjänsten hanterar data om ett företags olika produkter och har implementerad CRUD-funktionalitet som möjliggör utläsning, tillägg, ändring och radering av data från en tabell i en databas. Varje produkt relaterar till en specifik kategori i en annan tabell i databasen. Det är även möjligt att läsa ut, lägga till, ändra och radera data från tabellen som lagrar kategorier. Nedan redogörs mer ingående för respektive tabell.

För att kunna hantera data i REST-webbtjänsten krävs autentisering. Det innebär att en användare måste logga in med befintliga kontouppgifter för att kunna nyttja REST-webbtjänstens CRUD-funktionalitet. Väl inloggad är det även möjligt att registrera nya användarkonton.

Data presenteras i JSON-format.

## Tabellen "categories"
Utöver de kolumner som ingår vid migrering, innehåller tabellen även kolumnen *name* (textsträng). Ett värde för denna kolumn måste anges när en kategori ska läggas till.

## Tabellen "products"
Utöver de kolumner som ingår vid migrering, innehåller tabellen även kolumnerna *category_id* (bigInteger), *name* (string), *description* (longText), *image* (string), *price* (integer) och *quantity* (integer). Ett värde måste anges för kolumnerna *category_id*, *name* och *quantity* när en produkt ska läggas till, för övriga kolumner är det valfritt att ange värden.

I kolumnen *image* lagras den fullständiga sökvägen till uppladdade bildfiler.

## Routes
Följande routes finns tillgängliga:

* `POST` `api/register` registrerar konto.  
Värden för *name*, *email* och *password* (minst åtta tecken) måste anges.

`POST` `api/login` loggar in användare och returnerar API-token.  
Värden för *email* och *password* måste anges.

`POST` `api/logout` loggar ut användare genom att radera API-token.

`GET` `api/category` läser ut samtliga kategorier.

`POST` `api/category` skapar och lägger till en kategori.  
Värde för *name* måste anges.

`PUT` `api/category/{id}` uppdaterar en kategori utifrån id.  
Värde för *name* måste anges.

`DELETE` `api/category/{id}` raderar en kategori utifrån id.

`GET` `api/product` läser ut samtliga produkter.

`GET` `api/product/search/name/{name}` läser ut en produkt vid sökning på namn.  
Värde för *name* måste anges.

`POST` `api/product/{id}` skapar och lägger till en produkt knuten till ett kategori-id.  
Värde för *category_id*, *name* och *quantity* måste anges.

`PUT` `api/productquantity/{id}` uppdaterar en produkts värde för kolumnen *quantity* utifrån id.  
Värde för *quantity* måste anges.

`PUT` `api/product/{id}` uppdaterar en produkt utifrån id.  
Värde för *category_id*, *name* och *quantity* måste anges.

`DELETE` `api/product/{id}` raderar en produkt utifrån id.