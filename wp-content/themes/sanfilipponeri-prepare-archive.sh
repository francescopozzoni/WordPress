#!/bin/bash
# Crea sanfilipponeri.zip da caricare su entrambi i siti (Aspetto > Temi > Aggiungi > Carica).
# Richiede che sul sito sia installato anche il tema padre Twenty Twenty-One.

cd "$(dirname "$0")" || exit 1
rm -f sanfilipponeri.zip
zip -r sanfilipponeri.zip sanfilipponeri/
