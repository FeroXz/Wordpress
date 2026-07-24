# Wissenswerk – WordPress-Theme

Ein modernes, responsives WordPress-Theme mit drei spezialisierten Bereichen:

- 📚 **Wissenssammlung** – strukturierte, durchsuchbare Wissensartikel (Custom Post Type `wissen`)
- 🖼️ **Galerie** – Bilder und Eindrücke in eleganter Rasteransicht (Custom Post Type `galerie`)
- 📣 **Neuigkeiten** – Aktuelles und Ankündigungen im Zeitstrahl-Stil (Custom Post Type `neuigkeiten`)

## Highlights

- **Modernes Design** mit CSS-Variablen, sanften Übergängen, Grid-Layouts und großzügiger Typografie (Inter & Merriweather).
- **Dark-Mode** – automatisch nach Systemeinstellung, manuell umschaltbar (Auswahl wird gespeichert).
- **Vollständig responsiv** inkl. Off-Canvas-Mobilmenü.
- **Block-Editor-Unterstützung** über `theme.json` (Farbpalette, Schriftgrößen, Wide-/Full-Alignments, Editor-Styles).
- **Barrierefrei**: Skip-Link, sichtbarer Fokus, `prefers-reduced-motion`, ARIA-Attribute.
- **Eigene Taxonomien** je Bereich plus bereichsübergreifende Schlagworte.
- **Übersetzungsbereit** (Text-Domain `wissenswerk`), Deutsch als Standardsprache.

## Installation

1. Den Ordner `wissenswerk/` nach `wp-content/themes/` kopieren.
2. Im Backend unter **Design → Themes** „Wissenswerk“ aktivieren.
3. Die Permalinks werden bei Aktivierung automatisch neu geschrieben. Falls
   die Bereichs-URLs nicht sofort greifen, einmal unter **Einstellungen →
   Permalinks** speichern.

## Nutzung

### Inhalte anlegen
Nach der Aktivierung erscheinen im Admin-Menü drei neue Einträge:
**Wissenssammlung**, **Galerie** und **Neuigkeiten**. Beiträge dort anlegen und
jeweils ein Beitragsbild setzen (fehlt es, wird ein farbiger Platzhalter erzeugt).

### Bereiche ordnen
- Wissensartikel → **Themengebiete** (`wissen_thema`)
- Galerie-Einträge → **Alben** (`galerie_album`)
- Neuigkeiten → **Rubriken** (`neuigkeiten_rubrik`)
- Alle Bereiche → gemeinsame **Schlagworte** (`wissenswerk_tag`)

### Landingpage bearbeiten
Die komplette Startseite ist über **Design → Customizer → Landingpage**
anpassbar – ohne Code:

- **Hero:** Eyebrow, Überschrift, Untertitel, zwei Buttons (Text + Link),
  Hintergrundstil (Dämmerung/Marke). Überschrift & Untertitel mit Live-Vorschau.
- **Bereichs-Kacheln:** ein-/ausblenden, Titel und Text je Kachel.
- **Abschnitte** (Wissenssammlung, Galerie, Neuigkeiten): je Abschnitt
  ein-/ausblenden, eigene Überschrift und Anzahl der angezeigten Beiträge.

**Bildzentriertes Design – alle Bilder austauschbar:**
- **Titelbild (Hero):** großes Hintergrundbild + einstellbare Verdunkelung
  für lesbaren Text.
- **Bereichs-Kacheln:** je Kachel ein eigenes Hintergrundbild.
- **Showcase-Bildmosaik:** dynamisches Raster aus sechs Bildern mit optionalen
  Bildunterschriften, ein-/ausblendbar.

Solange nichts hochgeladen wurde, zeigen alle Bildflächen ansprechende
**Platzhalter** (`assets/images/placeholder-*.svg`). Jedes Bild wird im
Customizer per Klick auf **„Bild auswählen"** durch ein eigenes Foto ersetzt.

Zusätzlich: Wird unter **Einstellungen → Lesen** eine statische Seite als
Startseite gesetzt, erscheint deren Block-Inhalt unterhalb der Abschnitte –
so lässt sich die Landingpage auch mit dem Block-Editor ergänzen.

### Seitenvorlagen (bearbeitbare Seiten)
Zwei Vorlagen kombinieren einen frei im Block-Editor bearbeitbaren
Einleitungstext mit einem automatisch erzeugten, gestalteten Bereich:

- **Galerie-Seite** (`page-galerie.php`): filterbares Masonry-Bildraster aller
  Galerie-Einträge mit Album-Filter und Lightbox (Tastatur- und Wischnavigation).
- **Wissens-Wiki** (`page-wissen-wiki.php`): Wiki-Layout mit fixierter
  Themen-Seitenleiste, Suche und nach Themengebieten gegliederten Artikeln
  (aktiver Abschnitt wird beim Scrollen hervorgehoben).

**So anlegen:** **Seiten → Erstellen** → Titel und optional Einleitungstext
eingeben → rechts unter **Seiteneigenschaften → Vorlage** „Galerie-Seite" bzw.
„Wissens-Wiki" wählen → veröffentlichen. Die Seite kann anschließend als
Menüpunkt oder als statische Startseite verwendet werden.

### Weitere Vorlagen

**Für Beiträge** (im Editor rechts unter **Beitrag → Vorlage** wählbar,
verfügbar für Beiträge, Wissensartikel, Galerie und Neuigkeiten):

- **Cover (großes Titelbild)**: Beitragsbild als bildschirmfüllendes Cover
  mit Titel-Overlay, darunter schmaler Lesetext.
- **Steckbrief (Profil)**: Foto-Karte mit Fakten-Box (Datum, Autor,
  Lesezeit) links, Inhalt rechts – ideal für Tier-, Personen- oder
  Produktprofile.

**Für Seiten:**

- **Volle Breite**: Inhalt nutzt die gesamte Container-Breite; „Weite
  Breite"/„Volle Breite"-Blöcke brechen zusätzlich aus.
- **Leere Leinwand (ohne Titel)**: Nur der Block-Inhalt, ohne Titel –
  zum freien Gestalten eigener Landingpages im Editor.

### Menü
Unter **Design → Menüs** ein Menü an der Position „Hauptmenü“ zuweisen. Ohne
zugewiesenes Menü verlinkt der Header automatisch auf Start und die drei Bereiche.

## Dateistruktur

```
wissenswerk/
├── style.css              Theme-Header
├── theme.json             Block-Editor-Einstellungen
├── functions.php          Setup, Assets, Widgets, Menüs
├── header.php / footer.php Grundgerüst
├── front-page.php         Startseite mit allen drei Bereichen
├── page-galerie.php       Vorlage: Galerie-Seite (Filter + Lightbox)
├── page-wissen-wiki.php   Vorlage: Wissens-Wiki (Sidebar + Suche)
├── page-fullwidth.php     Vorlage: Volle Breite
├── page-canvas.php        Vorlage: Leere Leinwand (ohne Titel)
├── single-cover.php       Beitragsvorlage: Cover (großes Titelbild)
├── single-steckbrief.php  Beitragsvorlage: Steckbrief (Profil)
├── index.php              Fallback-Template
├── archive-{wissen,galerie,neuigkeiten}.php
├── single-{wissen,galerie,neuigkeiten}.php
├── taxonomy.php           Themengebiete / Alben / Rubriken
├── single.php / page.php / search.php / 404.php
├── searchform.php / sidebar.php / comments.php
├── inc/
│   ├── post-types.php     Custom Post Types
│   ├── taxonomies.php     Taxonomien
│   ├── template-tags.php  Wiederverwendbare Template-Funktionen
│   └── customizer.php     Customizer-Optionen
└── assets/
    ├── css/main.css       Gesamtes Design
    ├── js/main.js         Menü, Dark-Mode, Galerie, Lightbox, Wiki, Reveal
    └── js/customize-preview.js  Live-Vorschau im Customizer
```

## Reptilien-Manager-Integration

Das Theme ist auf das Plugin [Reptilien Manager](https://github.com/FeroXz/wpplugin)
abgestimmt (das Plugin übernimmt seinerseits automatisch die
Theme-Farbvariablen inklusive Dark-Mode):

- **`archive-rm_animal.php`** – Tierübersicht (`/reptilien`) im Theme-Design
  mit Arten-Filter und Karten inkl. Geschlechts-, Alters- und Morph-Badges.
- **`single-rm_animal.php`** – Tierprofil mit Art-Chips, Badges,
  Vor-/Zurück-Navigation und „Weitere Tiere dieser Art".
- **Startseite:** optionaler Abschnitt „Unsere Tiere"
  (Customizer → Landingpage → Abschnitt: Unsere Tiere).
- Die Beitragsvorlage **Cover** steht auch für Tiere zur Verfügung;
  das Fallback-Menü verlinkt automatisch auf „Tiere".

Alle Integrationen sind abgesichert: Ohne aktives Plugin erscheinen weder
Abschnitt, Menüpunkt noch Customizer-Optionen.

## Anforderungen

- WordPress 6.0+
- PHP 7.4+

## Lizenz

GPL v2 oder später.
