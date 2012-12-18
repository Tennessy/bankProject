#!/bin/sed -rf

# Attention, ici on écrit directement un script sed (d'où la 
# première ligne de ce fichier).
# Lancer avec ./html2txt.sed < sample.html

# La solution proposée est un peu simpliste...
# Les lignes du fichiers HTML sont supposées faciles à traiter,
# ce qui est le cas pour le fichier sample.html.
# Dans l'idéal, il faudrait supprimer tous les retours à la
# ligne (qui ne sont pas significatifs en HTML) et traiter
# rigoureusement les balises, comme on le fait pour la balise <a>.

/^$/ d
# Attention, / est un caractère spécial pour sed, il faut
# le protéger : \/
/<\/?(html|head|title|body|div|ul)( [^>]*)?>/ d
# L'expression "( [^>]*)?" permet de matcher tout ce que la balise 
# pourrait contenir d'autre.
# Dans l'exemple sample.html, les balises ne contiennent jamais rien
# d'autre, on pourrait par exemple ici se contenter de "s/<h1>/= /g".
/<!DOCTYPE / d
/<meta [^>]*\/>/ d
s/<h1( [^>]*)?>/= /g
s/<\/h1>/ =\n/g
s/<h2( [^>]*)?>/== /g
s/<\/h2>/ ==\n/g
s/<h3( [^>]*)?>/=== /g
s/<\/h3>/ ===\n/g
/<p( [^>]*)?>/ d
s/<\/p>//g
s/<\/?b( [^>]*)?>/**/g
s/<\/?i( [^>]*)?>/\/\//g
s/<li( [^>]*)?>/- /g
/<\/li>/ d
s/<a href="([^"]*)"( [^>]*)?>([^<]*)<\/a>/\[\3 \1\]/g
