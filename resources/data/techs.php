<?php
    return [
        'pulsantrieb' => [
            'key'         => 'pulsantrieb',
            'name'        => 'Pulsantrieb',
            'image'       => '/img/game/research/pulsantrieb.jpg',
            'description' => 'Chemische Raketen, Ionenantriebe sowie auch auf Kernspaltung oder Kernfusion basierende Antriebe werden Pulsantriebe genannt.<br /><br />Diese Technologie ist rellativ einfach und platzsparend. Deshalb findet man diese Art Antrieb hauptsächlich bei Jägern und kleinen Transportern, da dort meistens kein Platz für ein Antimaterieantrieb vorhanden ist.',
            'level'       => 0,
            'aluminium'    => 2500,
            'titan'       => 2750,
            'wasserstoff' => 4000,
            'needs'       => [$this->planet->buildings->forschungszentrum => 1]
        ],

        'antimaterieantrieb' => [
            'key'         => 'antimaterieantrieb',
            'name'        => 'Antimaterieantrieb',
            'image'       => '/img/game/research/antimaterieantrieb.jpg',
            'description' => 'Chemische oder elektrische Antriebe wie der Ionenantrieb sind für interstellare oder gar intergalaktische Distanzen ungeeignet.<br /><br />Unter dem Aufwand gewaltiger Energiemengen, die durch eine Materie-Antimaterie-Reaktion entsteht, ist es möglich ein sogenanntes Fenster in den Hyperraum zu öffnen, welcher eine Abkürzung durch das reguläre Raum-Zeit-Kontinuum darstellt und so das Maximum der Lichtgeschwindigkeit im Normalraum umgeht.<br /><br />Die Leistungsfähigkeit solcher Antriebe ist im Prinzip nur durch die Energiemenge begrenzt, die der Reaktor freisetzen kann.',
            'level'       => 0,
            'aluminium'    => 8250,
            'wasserstoff' => 7500,
            'antimaterie' => 5500,
            'needs'       => [$this->planet->buildings->forschungszentrum => 4]
        ],

        'projektilwaffen' => [
            'key'         => 'projektilwaffen',
            'name'        => 'Projektilwaffen',
            'image'       => '/img/game/research/projektilwaffen.jpg',
            'description' => 'Projektilwaffen sind die älteste aller Waffengattungen. Eine Treibladung beschleunigt ein Projektil, welches beim Auftreffen auf ein Objekt Schaden anrichtet.<br /><br />Die Weiterentwicklung dieser Technologie beinhaltet die Anwendung von Magnetfeldern oder Spulen um ein Projektil auf Geschwindigkeit zu bringen.<br /><br />Solche Waffen werden auch als Railguns oder Gauss-Geschütze bezeichnet und bieten den Vorteil einer wesentlich höheren Aufschlaggeschwindigkeit und damit verbunden, eines größeren Schadens am beschossenem Objekt.',
            'level'       => 0,
            'aluminium'    => 3000,
            'silizium'    => 1000,
            'wasserstoff' => 1700,
            'needs'       => [$this->planet->buildings->forschungszentrum => 1]
        ],

        'laserwaffen' => [
            'key'         => 'laserwaffen',
            'name'        => 'Laserwaffen',
            'image'       => '/img/game/research/laserwaffen.jpg',
            'description' => 'Das Licht wurde schon in der Antike vom Erdforscher Archimedes als Waffe genutzt. Auch wenn sich die Technologie weiter entwickelt hat, ist das Grundprinzip fast das Gleiche.<br /><br />Hochenergetische Lichtstrahlen werden heute mittels spezieller Kristalle konzentriert und gebündelt.<br /><br />Dadurch entsteht eine sehr große Hitzeentwicklung, der aktuelle Panzerungen nur schwer wiederstehen können.',
            'level'       => 0,
            'titan'       => 9000,
            'silizium'    => 4500,
            'wasserstoff' => 7750,
            'needs'       => [$this->planet->buildings->forschungszentrum => 2]
        ],

        'plasmawaffen' => [
            'key'         => 'plasmawaffen',
            'name'        => 'Plasmawaffen',
            'image'       => '/img/game/research/plasmawaffen.jpg',
            'description' => 'Grundlage für Plasmawaffen ist die Fusion von Deuterium und Tritium, welches ein Plasma von mehreren Millionen Grad erzeugt.<br /><br />Dieses Plasma wird im nächsten Schritt durch Magnetfelder aus dem Reaktor abgeführt, stabilisiert und mit Hilfe von Beschleunigern abgefeuert.<br /><br />Ein Objekt was von einem derartigem "Plasmaball" getroffen wird, verdampft innerhalb von wenigen Millisekunden.',
            'level'       => 0,
            'aluminium'   => 15000,
            'titan'       => 14750,
            'wasserstoff' => 12500,
            'antimaterie' => 7500,
            'needs'       => [$this->planet->buildings->forschungszentrum => 4]
        ],

        'phasenwaffen' => [
            'key'         => 'phasenwaffen',
            'name'        => 'Phasenwaffen',
            'image'       => '/img/game/research/phasenwaffen.jpg',
            'description' => 'Diese Technologie basiert auf der Phasenverschiebung von Objekte. Wird ein Objekt aus der Phase verschoben, wird es für den Betrachter unsichtbar, solange es nicht wieder in die Ursprungsphase zurückversetzt wird.<br /><br />Hier wird dieser letzte Schritt einfach ausgelassen und das anvisierte Objekt verbleibt in der verschobenen Phase.<br /><br />Dadurch können in Sekundenbruchteilen ganze Sektionen von Raumschiffen und Verteidungsanlagen einfach aufgelöst werden, was in der Regel zur sofortigen Zerstörung führt.',
            'level'       => 0,
            'aluminium'   => 16000,
            'titan'       => 10000,
            'wasserstoff' => 16500,
            'antimaterie' => 12000,
            'needs'       => [$this->planet->buildings->forschungszentrum => 8]
        ],

        'strukturelle_integritaet' => [
            'key'         => 'strukturelle_integritaet',
            'name'        => 'Strukturelle Integrität',
            'image'       => '/img/game/research/strukturelle_integritaet.jpg',
            'description' => '',
            'level'       => 0,
            'aluminium'   => 5000,
            'titan'       => 3500,
            'wasserstoff' => 4000,
            'needs'       => [$this->planet->buildings->forschungszentrum => 1]
        ],

        'mikroarchitektur' => [
            'key'         => 'mikroarchitektur',
            'name'        => 'Mikroarchitektur',
            'image'       => '/img/game/research/mikroarchitektur.jpg',
            'description' => '',
            'level'       => 0,
            'aluminium'   => 3500,
            'silizium'    => 2350,
            'wasserstoff' => 850,
            'needs'       => [$this->planet->buildings->forschungszentrum => 2]
        ],

        'orbitalkonstruktion' => [
            'key'         => 'orbitalkonstruktion',
            'name'        => 'Orbitalkonstruktion',
            'image'       => '/img/game/research/orbitalkonstruktion.jpg',
            'description' => '',
            'level'       => 0,
            'titan'       => 12500,
            'silizium'    => 5500,
            'wasserstoff' => 10000,
            'needs'       => [
                $this->planet->buildings->forschungszentrum => 5,
                $this->research->strukturelle_integritaet => 5,
                $this->research->mikroarchitektur => 2
            ]
        ],

        'lagererweiterung' => [
            'key'         => 'lagererweiterung',
            'name'        => 'Lagererweiterung',
            'image'       => '/img/game/research/lagererweiterung.jpg',
            'description' => '',
            'level'       => 0,
            'titan'       => 3500,
            'silizium'    => 2500,
            'wasserstoff' => 5000,
            'needs'       => [$this->research->strukturelle_integritaet => 2]
        ],

        'schiffskapazitaet' => [
            'key'         => 'schiffskapazitaet',
            'name'        => 'Schiffskapazität',
            'image'       => '/img/game/research/schiffskapazitaet.jpg',
            'description' => '',
            'level'       => 0,
            'aluminium'   => 15000,
            'titan'       => 12500,
            'silizium'    => 6000,
            'wasserstoff' => 10500,
            'needs'       => [
                $this->research->strukturelle_integritaet => 2,
                $this->research->orbitalkonstruktion => 4
            ]
        ],

        'rumpfstatik' => [
            'key'         => 'rumpfstatik',
            'name'        => 'Rumpfstatik',
            'image'       => '/img/game/research/rumpfstatik.jpg',
            'description' => '',
            'level'       => 0,
            'titan'       => 40000,
            'silizium'    => 12500,
            'arsen'       => 5500,
            'wasserstoff' => 35000,
            'needs'       => [
                $this->planet->buildings->forschungszentrum => 10,
                $this->research->schiffskapazitaet => 10
            ]
        ],

        'werftarchitektur' => [
            'key'         => 'werftarchitektur',
            'name'        => 'Werftarchitektur',
            'image'       => '/img/game/research/werftarchitektur.jpg',
            'description' => '',
            'level'       => 0,
            'aluminium'   => 12500,
            'silizium'    => 15000,
            'wasserstoff' => 5750,
            'antimaterie' => 7500,
            'needs'       => [
                $this->planet->buildings->forschungszentrum => 10,
                $this->research->strukturelle_integritaet => 4,
                $this->research->mikroarchitektur => 5,
            ]
        ],

        'schildtechnologie' => [
            'key'         => 'schildtechnologie',
            'name'        => 'Schildtechnologie',
            'image'       => '/img/game/research/schildtechnologie.jpg',
            'description' => '',
            'level'       => 0,
            'titan'       => 75000,
            'arsen'       => 35000,
            'wasserstoff' => 80000,
            'antimaterie' => 50000,
            'needs'       => [
                $this->planet->buildings->forschungszentrum => 3,
                $this->research->strukturelle_integritaet => 3,
            ]
        ],

        'kommunikation' => [
            'key'         => 'kommunikation',
            'name'        => 'Kommunikation',
            'image'       => '/img/game/research/kommunikation.jpg',
            'description' => '',
            'level'       => 0,
            'aluminium'   => 5000,
            'silizium'    => 2500,
            'wasserstoff' => 6000,
            'needs'       => [
                $this->planet->buildings->forschungszentrum => 1,
                $this->planet->buildings->sternenbasis => 10,
            ]
        ],

        'imperiale_verwaltung' => [
            'key'         => 'imperiale_verwaltung',
            'name'        => 'Imperiale Verwaltung',
            'image'       => '/img/game/research/imperiale_verwaltung.jpg',
            'description' => '',
            'level'       => 0,
            'aluminium'   => 13500,
            'silizium'    => 6500,
            'wasserstoff' => 3500,
            'antimaterie' => 11000,
            'needs'       => [$this->planet->buildings->forschungszentrum => 5]
        ],

        'spionage' => [
            'key'         => 'spionage',
            'name'        => 'Spionage',
            'image'       => '/img/game/research/spionage.jpg',
            'description' => '',
            'level'       => 0,
            'aluminium'   => 2000,
            'wasserstoff' => 1500,
            'antimaterie' => 500,
            'needs'       => [$this->planet->buildings->forschungszentrum => 1]
        ],

        'recycling' => [
            'key'         => 'recycling',
            'name'        => 'Recycling',
            'image'       => '/img/game/research/recycling.jpg',
            'description' => '',
            'level'       => 0,
            'aluminium'   => 4500,
            'titan'       => 3250,
            'silizium'    => 2250,
            'wasserstoff' => 2000,
            'needs'       => [
                $this->planet->buildings->forschungszentrum => 3,
                $this->planet->buildings->lager => 5,
                $this->research->lagererweiterung => 2,
                $this->research->mikroarchitektur => 3
            ]
        ],

        'geologie' => [
            'key'         => 'geologie',
            'name'        => 'Geologie',
            'image'       => '/img/game/research/geologie.jpg',
            'description' => 'Geologie beinhaltet haupsächlich die Forschungsgebiete der Mineralienkunde sowie der Kartografierung des Planeten. Speziell ausgebildete Geologenteams suchen nach neuen Vorkommen natürlicher Ressourcen und tragen diese auf die Planetenkarten ein. Dadurch wird es ermöglicht, die Effektivität der Aluminiumminen, Titanfertigungen sowie der Siliziumminen zu steigern. Jede Forschungsstufe erhöht den Stundenbetrag dieser drei Minen um 5%.',
            'level'       => 0,
            'aluminium'   => 7500,
            'silizium'    => 3750,
            'wasserstoff' => 5750,
            'needs'       => [
                $this->planet->buildings->forschungszentrum => 1,
                $this->planet->buildings->aluminiummine => 10,
                $this->planet->buildings->siliziummine => 10,
            ]
        ],

        'speziallegierungen' => [
            'key'         => 'speziallegierungen',
            'name'        => 'Speziallegierungen',
            'image'       => '/img/game/research/speziallegierungen.jpg',
            'description' => '',
            'level'       => 0,
            'titan'       => 10000,
            'silizium'    => 2000,
            'wasserstoff' => 11000,
            'needs'       => [
                $this->planet->buildings->forschungszentrum => 4,
                $this->planet->buildings->titanfertigung => 10,
            ]
        ],

        'materiestabilisierung' => [
            'key'         => 'materiestabilisierung',
            'name'        => 'Materiestabilisierung',
            'image'       => '/img/game/research/materiestabilisierung.jpg',
            'description' => '',
            'level'       => 0,
            'aluminium'   => 8000,
            'wasserstoff' => 12500,
            'antimaterie' => 7500,
            'needs'       => [
                $this->planet->buildings->forschungszentrum => 1,
                $this->planet->buildings->wasserstofffabrik => 10,
                $this->planet->buildings->antimateriefabrik => 10,
            ]
        ]
    ];