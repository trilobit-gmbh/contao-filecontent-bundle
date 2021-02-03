Mit dem contao-filecontent-bundle können in der Basisversion die Inhalte von PDF-Dokumenten in den Suchindex aufgenommen werden.

Analog dem Downloads-Inhaltselement steht ein neues Inhaltselement vom Type "Datei-Inhalte Leser / Downloads" zu Verfügung. Diesem kann man wie beim Download(s)-Element auch die gewünschten Dokumente zuordnen.

Das neue Inhaltselement stellt zwei Listen (und die jeweiligen Detailseiten) zur Verfügung:
- Liste der verknüpften Dokumente als Download-Liste (analog dem Downloads-Inhaltselement) sowie
- eine Liste mit Links auf die "Detailseite" des Dokuments.
Die Übersicht ist vom Suchindex ausgeschlossen. Dies kann jedoch bei Bedarf im Template selbst einfach angepasst werden. Auch ob die Listen angezeigt werden lässt sich einfach anpassen. Die Links auf die jeweiligen Detailseiten der Dokumente sollten jedoch bei Bedarf nur ausgeblendet und nicht entfernt werden (denn dann kann der Contao-Crawler diese Seiten nicht mehr erreichen und damit auch nicht in den Suchindex übernehmen).

Ist die Seite mit diesem Inhlatselement für den Contao-Crawler erreichbar, werden die Verknüpften Dokumente ausgelesen und in der Inhalt in den Suchindex übernommen.
Wird nach einen Begriff gesucht, der einem PDF Dokument zugeordnet ist, wird bei Klick auf das Suchergebnis dieses File zurückgegeben (je nach Einstellung im Inhaltselement).

Das Bundle kann via Hook auch um eigene, weitere individuelle Konverter ergänzt werden (z.B. für Text-Files, CSV, ...)
