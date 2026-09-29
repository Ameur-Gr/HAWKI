#!/usr/bin/env bash
set -e

replace() {
    local file="$1"
    shift

    python3 - "$file" "$@" <<'PY'
import sys
from pathlib import Path

file = Path(sys.argv[1])
text = file.read_text()

for pair in sys.argv[2:]:
    old, new = pair.split("\t", 1)
    text = text.replace(old, new)

file.write_text(text)
PY
}

# English general translations
replace resources/language/en_US.json \
  $'HAWKI may make mistakes\tBlablador may make mistakes' \
  $'Guidelines for Using HAWKI\tGuidelines for Using Blablador' \
  $'If HAWKI detects\tIf Blablador detects' \
  $'using HAWKI\tusing Blablador' \
  $'from HAWKI\tfrom Blablador' \
  $'About HAWKI\tAbout Blablador' \
  $'HAWKI Knowledge\tBlablador Knowledge' \
  $'developed specifically for HAWKI\tdeveloped specifically for Blablador' \
  $'use the HAWKI language models\tuse the Blablador language models' \
  $'not supported by HAWKI\tnot supported by Blablador'

# German general translations
replace resources/language/de_DE.json \
  $'HAWKI kann Fehler machen\tBlablador kann Fehler machen' \
  $'HAWKI-Wissen\tBlablador-Wissen' \
  $'Sprachmodelle von HAWKI\tSprachmodelle von Blablador' \
  $'von HAWKI\tvon Blablador' \
  $'Über HAWKI\tÜber Blablador'

# English chat translations
replace resources/language/chat_en_US.json \
  $'use the AI with @hawki\tuse the AI with @blablador' \
  $'Talk to HAWKI\tTalk to Blablador' \
  $'Stop talking to HAWKI\tStop talking to Blablador' \
  $'HAWKI Tools\tBlablador Tools' \
  $'Tools provided by HAWKI itself\tTools provided by Blablador' \
  $'HAWKI Knowledge\tBlablador Knowledge' \
  $'developed specifically for HAWKI\tdeveloped specifically for Blablador'

# German chat translations
replace resources/language/chat_de_DE.json \
  $'@hawki\t@blablador' \
  $'Mit HAWKI sprechen\tMit Blablador sprechen' \
  $'Nicht mehr mit HAWKI sprechen\tNicht mehr mit Blablador sprechen' \
  $'HAWKI Tools\tBlablador Tools' \
  $'von HAWKI selbst\tvon Blablador' \
  $'HAWKI-Wissen\tBlablador-Wissen' \
  $'speziell für HAWKI entwickelt\tspeziell für Blablador entwickelt'

# Login page
replace resources/views/partials/login/infoPanel.blade.php \
  $'HAWKI 2.0\tBlablador' \
  $'We have further improved HAWKI for you!\tWelcome to Blablador!'

# Update page
replace resources/views/layouts/update-page.blade.php \
  $'HAWKI IS UPDATING!\tBlablador IS UPDATING!' \
  $'Welcome to HAWKI\tWelcome to Blablador' \
  $'updating HAWKI\tupdating Blablador'

# Group chat hardcoded message
replace public/js/groupchat_functions.js \
  $'You can not remove HAWKI from the Room!\tYou can not remove Blablador from the Room!'

echo "✓ Blablador rebranding applied."
