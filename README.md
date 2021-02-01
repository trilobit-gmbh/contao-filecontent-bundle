Das contao-filecontent-bundle erweitert das Download(s)-Element von Contao um die Möglichkeit, auch Inhalte von hiermit verlinkten PDF-Dokumenten in den Suchindex aufzunehmen.

Hierzu steht ein neues Inhaltselement vom Type "Datei-Inhalte Leser / Downloads" zu Verfügung. Diesem kann man wie beim Download(s)-Element die gewünschten Dokumente zuordnen. Ist die Seite mit dem Modul für den Crawler erreichbar werden die Verknüpften Dokumente ausgelesen und in den Suchindex übernommen.
Sucht man nun einen Begriff und die Fundstelle ist das (PDF)Dokument, wird bei einem Klick auf das Ergebnis dieses File zurückgegeben (je nach Einstellung im Inhaltselement).

Das Bundle kann via Hook auch um eigene, individuelle Konverter ergänzt werden (z.B. für Text-Files, CSV, ...)
