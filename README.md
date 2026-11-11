# GrachtenGravers
Officiële repo van Jelle Romijn en Ridouan Rashid voor de opdracht 6.1 - Module - Het Utrechts Archief (2026-2027).

## Projectprototype
Dit project bevat een werkende prototype-webapplicatie voor de tentoonstelling "Ontmoet de Oudegracht". De ervaring combineert een historische video met een interactieve kaart en locatiegebonden informatie voor gebruik op een groot touchscreen.

## Starten
1. Open de map in een lokale PHP-omgeving.
2. Start bijvoorbeeld een lokale server vanuit deze map:
   php -S 127.0.0.1:8000
3. Open in de browser:
   http://127.0.0.1:8000/
4. Voor het minimal CMS-beheer van routepunten:
   http://127.0.0.1:8000/admin.php

## Functionaliteit
- Video speelt naast een interactieve kaart af
- Kaartmarkeringen volgen de route langs de Oudegracht
- Klikken op een punt springt naar het bijbehorende moment in de video
- Responsive layout met touchvriendelijke bediening
- Optie voor een 3D/gedraaide kaartweergave als extra visuele ervaring
- Minimal CMS om routepunten en teksten te beheren via data/locations.json

## Data-opslag
De routepunten worden opgeslagen in [data/locations.json](./data/locations.json). Het project is zo opgebouwd dat de inhoud vanuit een eenvoudig beheerscherm kan worden aangepast zonder de frontend te wijzigen.

## Opmerking
De briefing noemt het historische bronmateriaal en de route van de Gaardbrug tot de Bezembrug. Door de beperkte beschikbaarheid van originele media in deze repo is hiervoor een prototypische demonstratie met een lokale route- en kaartervaring opgezet, die direct kan worden uitgebreid met de echte film en archiefbronnen van Het Utrechts Archief.
