#!/usr/bin/env bash
# Briefing de session NeoGTB : signale que l'équipe d'agents est prête + état du dépôt.
# Branché sur le hook SessionStart (voir .claude/settings.json).
# Le chemin du projet est résolu via $CLAUDE_PROJECT_DIR, avec repli sur le chemin réel.

set -uo pipefail
DIR="${CLAUDE_PROJECT_DIR:-/Users/calmoulrich/ProjetsWeb/neogtb}"
cd "$DIR" 2>/dev/null || true

echo "╔══════════════════════════════════════════════════════════╗"
echo "║   🎯  ÉQUIPE NEOGTB — BRIEFING DE SESSION                 ║"
echo "╚══════════════════════════════════════════════════════════╝"
echo "  🧭 Stratégie  🔍 Critique  💡 Créatif  ⚙️ Technique  💎 Qualité"
echo "  Statut équipe : 🟢 5 agents prêts à bosser"
echo "  Garde-fous actifs : R1 zéro invention · R2 données fiables · R3 vérif"
echo "  ────────────────────────────────────────────────────────"

if git rev-parse --is-inside-work-tree >/dev/null 2>&1; then
  echo "  Branche : $(git branch --show-current 2>/dev/null)"
  echo "  Derniers commits :"
  git log --oneline -3 2>/dev/null | sed 's/^/    /'
  MOD="$(git status --short 2>/dev/null | head -10)"
  if [ -n "$MOD" ]; then
    echo "  Fichiers modifiés :"
    echo "$MOD" | sed 's/^/    /'
  else
    echo "  Arbre de travail : propre ✅"
  fi
else
  echo "  ⚠️  $DIR n'est pas un dépôt git"
fi
