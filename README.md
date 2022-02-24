# GED Tree

A package to extract information from GEDCOM files.

## Installation

```
composer require pzoechner/ged-tree
```

## Usage

```php
$tree = Tree::load(__DIR__ . 'file.ged');
```

### Accessing Individuals and Families
The getters are returning Illumniate `LazyCollection`s.

#### Individuals
```php
$individuals = $tree->getIndividuals();
```

```php
$individual = $individuals->first();
$individual->id;            // '@I2@'
$individual->name->first;   // 'Julia'
$individual->name->last;    // 'Doe'
$individual->name->married; // 'Williams'
```

#### Families
```php
$families = $tree->getFamilies();
```

```php
$familiy = $families->first();
$familiy->id;               // '@F1@'
$familiy->pointers;         // ['@I2@', '@I3@']
```
