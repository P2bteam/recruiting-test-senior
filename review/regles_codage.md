# Règles de codage pour My DSO Manager

## Conventions

- Niveau de code : PHP7.4
- Utilisation de [PSR-2](https://www.php-fig.org/psr/psr-2/) SAUF utilisation de tabulation de taille 4
- Utilisation de [PSR Naming Conventions](https://www.php-fig.org/bylaws/psr-naming-conventions/) pour le nommage (Interface, Classes, Traits, ...)
- Préfixer les tableaux par tab `$tabClients`
- Préfixer les objets par obj `$objCsv`
- Utiliser `isset()` lorsque l'on accède à un indice d'un tableau défini dynamiquement
- Ne pas utiliser la variable $_SESSION pour des raisons de sécurité et tout stocker dans un cookie navigateur

## Requêtes SQL :

- Espaces dans les requêtes SQL `FIELD = '1'`
- Privilégier les `JOIN` aux sous-requêtes `IN (SELECT ID_XXX)`. S'il n'est pas possible de faire avec un `JOIN`, limiter à une sous-requête (ne pas les chaîner)
- Utiliser un bloc

```php
$querySql = "SELECT *
	FROM ".$GLOBALS["table_acheteurs"]."
	WHERE ID_CLIENT = '".HelperDatabase::protegerSQL($id_client)."'";
$result = BD::execute($querySql);
if (BD::rowCount($result) > 0) {
	while ($row = BD::fetch($result)) {
		...
	}
}
```

## Opérateurs

- Ne pas effectuer d'imbrication ternaire `($x ? ($y ? true : false) : false)`

## phpDoc

- Tout nouveau code doit avoir une phpDoc
- La description de la méthode est facultative pour les getters/setters si elle est triviale

## Objets

- Un setter doit être fluent