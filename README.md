
# BIC4 Information Engineering ProjectThe films about the unknown
**Autoren:** 
> D. Bretschneider

> M. Ivkic

> D. Rappl


## Aufgabe
Die grundsätzliche Aufgabe hinter diesem Projekt ist es eine schon bestehende Website mit neuen Masken, Auflistungen und Tabellen in reinem VueJS auszustatten. 

Der Fokus in dieser LVA liegt auf Technologien wie JavaScript und beispielhaften Frameworks. Fuer die Uebung wird exemplarisch VueJS verwendet, da es verhaeltnismaessig schnell erlernbar ist und ein ueberschaubares Sprachparadigma hat. Mit VueJS wird gezeigt wie durch die Kombination des Frameworks und zwei weiteren kleinen Bibliotheken (axios und lodash), aeltere Technologien wie jQuery ersetzt werden können.

Um eine Schnittstelle zur Datenverarbeitung und Bereitstellung zu bieten, wird Serverseitig Laravel eingesetzt. Weil die Serverseite nicht zentrales Thema der Vorlesung liegt, werden hier von den Lektoren die noetigen Ressourcen zur Verfügung gestellt und eine Framework-Einführung in einer Vorlesungseinheit bereitgestellt. Zum Lehrstoff der Vorlesung gehören ebenfalls die Grundzüge von REST-Schnittstellen und Ihre Verwendung. Deshalb wird auch REST via Laravel vorgestellt.

## Inhalt unserer Website
Die Website ist dafür geschaffen Daten zu Filmen und den dazugehörigen Schauspielern zu verwalten. Sowohl Filme, als auch Aktoren, können erstellt, editiert oder gelöscht werden. Nach ihnen kann gesucht werden, außerdem wird der Gesamtdatensatz – um einen Überblick über die gesammelte Information zu erhalten – aufgelistet.

## Technologischer Hintergrund  
### Allgemein
Im Gegensatz zur anderen Version dieses Projekts haben wir uns hier rein am [SampleBlog](https://github.com/AVAtric/BIC4SampleBlogProject) orientiert. Die notwendigen Komponenten wie Tabellen o.ä. ähneln, also den Komponenten des Beispiels. Jedoch wurde jede Komponente auf unsere Bedürfnisse adaptiert. 

Das Backend ist PHP-lastig, konkret ist hier [Laravel](https://laravel.com/) in Verwendung. 

### Komponenten
Die folgenden Komponenten wurden für die Implementierung der gewünschten Funktionalität eingesetzt. Zentraler Aspekt beim Konstruieren der Komponenten war es, Wiederverwendung (Re-Use) zu ermöglichen, weswegen die Komponenten auch öfters, für verschiedene Zwecke, wiederverwendet wurden.

Die Komponenten sind im Projekt unter folgendem Pfad zu finden: ```/resources/js/components/base/```

#### DeleteModalComponent.vue

#### ErrorBoxComponent.vue

#### HeroComponent.vue

#### QueryMessage.vue

#### QueryMessageComponent.vue

#### SuccessBoxComponent.vue

#### TableElementComponent.vue

### Views 
Views können in unserem Projekt unter folgendem Pfad gefunden werden: ```/resources/views```.

Folgende Views sind im Projekt vorhanden und sind zur Anzeige und Verwaltung der Film und Schauspielerinformationen notwendig:

 * ```/resources/views/film```
     * ```/resources/views/film/create.blade.php```
     * ```/resources/views/film/edit.blade.php```
     * ```/resources/views/film/index.blade.php```
     * ```/resources/views/film/show.blade.php```
 * ```/resources/views/actor```
      * ```/resources/views/actor/create.blade.php```
      * ```/resources/views/actor/edit.blade.php```
      * ```/resources/views/actor/index.blade.php```
      * ```/resources/views/actor/search.blade.php```
      * ```/resources/views/actor/show.blade.php```

*   ```create``` steht für die Erstellung eines neuen Elements
*   ```edit``` steht für das Bearbeiten eines neuen Elements
*   ```index``` steht für die Anzeige des Gesamtdatensatzes ohne Suchfunktion. Die Anzahl der Einträge pro Seite kann festgelegt werden, standardmäßig liegt diese bei 10 Einträgen.
*   ```search``` erfüllt im Wesentlichen selbige Funktionalität, mit der Außnahme, dass hier nach Einträgen durch Tastatureingabe, gesucht werden kann.
*   ```show``` zeigt dem Benutzer einen Datensatz tabelarisch an.

### Routen  
Folgende Routen waren schon zu Beginn des Projekts gegeben. Die "Verkabelung" im Backend war also nicht Teil unserer Updates am Projekt: 
 * **GET** ```/actor``` &rarr; Lists all actors
 * **GET** ```/list/actor``` &rarr; Returns JSON of all actors
 * **GET** ```/list/film``` &rarr; Returns JSON of all film
 * **POST** ```/actor``` &rarr; Stores new actors
 * **GET** ```/actor/{slug}``` &rarr; Show actor
 * **PUT** ```/actor/{slug}``` &rarr; Update actor
 * **DELETE** ```/actor/{slug}``` &rarr; Delete actor
 * **GET** ```/actor/{slug}/edit``` &rarr; Edit actor
 * **GET** ```/search/actor``` &rarr; Search actors
 * **POST** ```/search/actor``` &rarr; Query actors
 * **GET** ```/film``` &rarr; Lists all films
 * **GET** ```/list/film``` &rarr; Returns JSON of all film
 * **POST** ```/film``` &rarr; Stores new film
 * **GET** ```/film/{slug}``` &rarr; Show film
 * **PUT** ```/film/{slug}``` &rarr; Update film
 * **DELETE** ```/film/{slug}``` &rarr; Delete film
 * **GET** ```/film/{slug}/edit``` &rarr; Edit film

#### CSS (SCSS)
In diesem Projekt wird [Bulma](https://bulma.io) – wie vorgesehen – für das Styling unser Website verwendet. 

Defaul-Style-Parameter können in  ```/resources/sass/_variables.scss```  gefunden und manipuliert werden.
Eigene Stylings sind in ```/resources/sass/_custom.scss``` zu finden.


### Installationsanleitung

#### Verwendete Software und Abhängigkeiten
* [GIT](https://github.com/)
* [PHP 7.3](https://www.php.net/releases/7_3_0.php)
* [Composer](https://getcomposer.org/)
* [https://nodejs.org/en/](Node.js)

Zum Programmieren wurde [PHPStorm](https://www.jetbrains.com/de-de/phpstorm/) in der Education Version verwendet.

#### Installation
Dieses Projekt kann als komprimierte .ZIP-Datei heruntergeladen und wieder entpackt werden.

 1. Um an Beispieldaten zu gelangen empfehlen wir folgende [SQLite-Datenbank](https://gitlab.hathor.at/fh-technikum/BIC4BaseProject/-/wikis/uploads/6175ab189c5bcd0b38283c658dfe56b7/database.zip). Die entpackte .sqlite-Datei muss im Ordner ``database`` gespeichert werden
 2. Nun ``composer install`` und ``npm install`` ausführen
 3. ``.env.example`` muss in ``.env`` unbenannt werden
 4. Um für Verschlüsselung zu sorgen, muss ein Schlüssel mittels ``php artisan key:generate`` generiert und anschließend mit ``php artisan migrate`` in die Applikation migriert werden.
 5. Ab nun kann das Projekt in PHPStorm geöffnet werden
 6. Um die Beispielwerte in die .sqlite-Datenbank zu spielen muss ``php artisan db:seed`` ausgeführt werden
 7. Der Code kann entweder mit ``npm run dev`` oder ``npm run watch`` kompiliert werden, der Unterschied liegt darin, dass ``npm run watch`` auf Änderungen reagiert und diese somit sofort darstellen kann, anstatt wieder einen Befehl im Terminal, oder der CMD, auszuführen. 
 8. Der Server kann mit ``php artisan serve`` oder über einen Basic-PHP-Server in PHPStorm egstartet werden.
 9. Das Ergebniss ist üblicherweise auf ``http://localhost:8000/public/index.php/home`` zu bestaunen.
