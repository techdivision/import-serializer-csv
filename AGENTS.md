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

## Häufige Use Cases

### CSV-Serialisierungs-Beispiele
```csv
// Product-Categories CSV
product_id,category_path,category_name
1,"Catalog/Women/Shirts","Women Shirts"
2,"Catalog/Men/Pants","Men Pants"

// CSV-Deserialisierung
$serializer = new ProductCategoryCsvSerializer();
$categories = $serializer->deserialize($csvContent);
// Gibt Array von Category-Objects zurück
```

### Szenarien
1. **CSV Import**: Externe Systems als CSV → Product-Categories konvertieren
2. **CSV Export**: Interne Data als CSV → Externe System
3. **Batch-Transformation**: Tausende Rows mit Serializer verarbeiten

## Performance-Überlegungen

- **CSV-Parse**: ~0.1-0.2ms pro Zeile durchschnittlich
- **10.000 Rows**: ~1-2 Sekunden Parse-Zeit
- **100.000 Rows**: ~10-20 Sekunden (wird merklich!)
- **Escape-Overhead**: Spezielle Zeichen (Kommas, Quotes) kosten extra ~5-10%
- **Optimal für**: < 50.000 Rows pro Batch, UTF-8 Encoding
- **Memory**: CSV wird vollständig in Memory geladen - ~1-2MB pro 10k Rows

## Verwandte Module

- **import-serializer**: Definiert Interfaces die dieses Modul implementiert
- **import**: Core Framework nutzt CSV-Serializer
- **import-serializer-csv** ← **diese Datei** (CSV Implementation!)

## Troubleshooting & FAQ

**Q: CSV-Spalten werden falsch geparst**
- A: Escaping-Probleme! Kommas in Values müssen quoted sein: `"value, with comma"`

**Q: Character-Encoding-Probleme (Umlaute, Akzente)**
- A: Serializer erwartet UTF-8. Konvertiere Input: `iconv('ISO-8859-1', 'UTF-8', $csv)`

**Q: Performance bei großen CSVs sehr schlecht**
- A: Memory-Issue? Nutze Streaming-Parsing statt vollständiges In-Memory Laden.

**Q: Spezialzeichen werden als "?" dargestellt**
- A: Encoding-Problem! Prüfe: `file -i input.csv` sollte `UTF-8` sein, nicht `ISO-8859-1`.

## Bekannte Einschränkungen

- **CSV-Only**: Nur CSV-Format unterstützt
- **Keine Validierung**: Validierung erfolgt in Importern
- **Keine Kompression**: CSV wird nicht komprimiert
- **Encoding-Annahmen**: Geht von UTF-8 aus

## Zusammenfassung

`import-serializer-csv` ist ein **Tier 1 Modul**, das CSV-Serialisierung für Import-Daten implementiert. Es bietet spezialisierte Serializer für verschiedene Entity-Typen und ist zentral für die CSV-basierte Import-Funktionalität.

**Für Agenten:** Verstehe dieses Modul als **CSV-Serialisierungs-Implementierung** mit Service Layer.
