// Aufruf des Skripts
<script type="text/javascript">


// Dokument ist fertig geladen - Wir k�nnen die Funktion nun sicher zuordnen
$(document).ready(function(){ 
	
	// Die einfache Variante ("falsch sortiert")
	$("#id_table_ranglist_fail").tablesorter(); 
}); 


// Komplexere Variante mit korrekter Sortierung

// Zun�chst Komma Filter f�r Floats definieren
$.tablesorter.addParser({ 
	id: 'g_float', 
	is: function(s) { 
		return s.match(new RegExp(/^(\+|-)?[0-9]+,[0-9]+((E|e)(\+|-)?[0-9]+)?$/)); 
	}, 
	format: function(s) { 
		return $.tablesorter.formatFloat(s.replace(new RegExp(/\./),"")); 
	}, 
	type: "numeric" 
});


// Dokument ist fertig geladen - Wir k�nnen die Funktion nun sicher zuordnen
$(document).ready(function(){ 
	
	// Aufruf mit Plugin und korrekter Sortierung
	$("#id_table_ranglist_correct").tablesorter( {
		widgets: ['zebra'],
		headers: {
			3: { 
				sorter: "g_float", 
			},
			4: { 
				sorter: "g_float", 
			},
			5: { 
				sorter: "g_float", 
			} 
		}
	}); 
}); 

</script>
