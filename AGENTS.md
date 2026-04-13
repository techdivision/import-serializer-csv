# AGENTS.md - import-serializer-csv

## Zweck & Verantwortung

Das `import-serializer-csv` Modul bietet eine **konkrete CSV-Serializer-Implementierung** für das Pacemaker Import-System. Es ist ein **Tier 1 Modul** und implementiert die Interfaces aus `import-serializer`.

**Hauptverantwortung:**
- CSV-Serialisierung und Deserialisierung
- Spezialisierte Serializer für verschiedene Entity-Typen
- Service Layer für CSV-Verarbeitung

## Architektur & Design Patterns

### Implementierungen
- **ProductCategoryCsvSerializer**: Spezialisiert für Produkt-Kategorien
- **ValueCsvSerializer**: Generischer CSV-Serializer für Werte
- **CategoryCsvSerializer**: Spezialisiert für Kategorien

### Verwendete Patterns
- **Service Layer**: Geschäftslogik für CSV-Verarbeitung
- **Strategy Pattern**: Verschiedene Serialisierungs-Strategien
- **Adapter Pattern**: Implementiert `SerializerInterface`

## Abhängigkeiten

### Externe Pakete
- **Keine** - Nur Service-Implementierungen

### TechDivision Dependencies
- **import-serializer** ^2.1 - Implementiert Serializer-Interfaces

### Abhängig von diesem Modul (2 Reverse Dependencies)
1. **import** - Core Framework nutzt CSV-Serializer
2. **import-cli-simple** - Transitiv über andere Module

## Wichtige Entry Points

### Serializer Klassen
```php
// Product Category CSV Serializer
ProductCategoryCsvSerializer::serialize($categories): string
ProductCategoryCsvSerializer::deserialize($csv): array

// Value CSV Serializer
ValueCsvSerializer::serialize($values): string
ValueCsvSerializer::deserialize($csv): array

// Category CSV Serializer
CategoryCsvSerializer::serialize($categories): string
CategoryCsvSerializer::deserialize($csv): array
```

### Verwendungsbeispiel
```php
// In Importern
$serializer = new ProductCategoryCsvSerializer();
$csv = $serializer->serialize($productCategories);
$categories = $serializer->deserialize($csv);
```

## Events & Extension Points

**Keine Events** - Tier 1 Implementierungs-Modul

## Hints für KI-Agenten

### Wichtig zu verstehen
1. **Tier 1 Modul**: Konkrete Implementierung von `import-serializer` Interfaces
2. **CSV-fokussiert**: Spezialisiert auf CSV-Format
3. **Service Layer**: Enthält Business Logic für CSV-Verarbeitung
4. **Spezialisierte Serializer**: Für verschiedene Entity-Typen

### Bei Änderungen
- **Implementierungs-Details**: Können geändert werden ohne Interface-Änderungen
- **CSV-Format**: Beachte Kompatibilität mit bestehenden CSV-Dateien
- **Encoding**: Beachte Character-Encoding (UTF-8, etc.)

### Implementierungs-Hinweise
- Nutze spezialisierte Serializer für Entity-Typen
- Beachte CSV-Escaping und Quoting
- Erwäge Performance bei großen CSV-Dateien

## Bekannte Einschränkungen

- **CSV-Only**: Nur CSV-Format unterstützt
- **Keine Validierung**: Validierung erfolgt in Importern
- **Keine Kompression**: CSV wird nicht komprimiert
- **Encoding-Annahmen**: Geht von UTF-8 aus

## Zusammenfassung

`import-serializer-csv` ist ein **Tier 1 Modul**, das CSV-Serialisierung für Import-Daten implementiert. Es bietet spezialisierte Serializer für verschiedene Entity-Typen und ist zentral für die CSV-basierte Import-Funktionalität.

**Für Agenten:** Verstehe dieses Modul als **CSV-Serialisierungs-Implementierung** mit Service Layer.
