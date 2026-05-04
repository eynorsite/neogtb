#!/usr/bin/env bash
# Veille sécurité neogtb.fr — non-intrusive
# - Vérifie headers, cert, DNS, fichiers sensibles, redirections
# - Auto-fix sur dérive de config nginx (restaure deploy/nginx-neogtb.conf)
# - Notifie Ulrich via WhatsApp UNIQUEMENT en cas d'anomalie

set -uo pipefail

DOMAIN="${DOMAIN:-www.neogtb.fr}"
APEX="${APEX:-neogtb.fr}"
ADMIN="${ADMIN:-admin.neogtb.fr}"
SSH_HOST="${SSH_HOST:-ubuntu@51.210.11.125}"

WATCH_DIR="$HOME/.openclaw/security-watch"
REPORT_DIR="$WATCH_DIR/reports"
mkdir -p "$REPORT_DIR"

TS=$(date +%Y%m%d-%H%M%S)
REPORT="$REPORT_DIR/$TS.json"
LOG="$WATCH_DIR/watch.log"

ISSUES=()
FIXES_APPLIED=()

log() { printf '[%s] %s\n' "$(date '+%H:%M:%S')" "$1" | tee -a "$LOG"; }

# ============================================================
# CHECKS
# ============================================================
log "🦞 Veille sécurité $DOMAIN — start"

# 1. Headers
HEADERS=$(curl -sI --max-time 15 "https://$DOMAIN/" 2>/dev/null)
for h in "Strict-Transport-Security" "Content-Security-Policy" "X-Frame-Options" "X-Content-Type-Options" "Referrer-Policy" "Permissions-Policy" "Cross-Origin-Opener-Policy"; do
  if ! grep -qi "^$h:" <<<"$HEADERS"; then
    ISSUES+=("Header manquant: $h")
  fi
done

# 2. HTTP→HTTPS redirect
HTTP_CODE=$(curl -sI -o /dev/null -w "%{http_code}" --max-time 10 "http://$DOMAIN/" 2>/dev/null)
[[ "$HTTP_CODE" != "301" && "$HTTP_CODE" != "308" ]] && ISSUES+=("HTTP→HTTPS pas en 301/308 (got $HTTP_CODE)")

# 3. Certificat expiry
CERT_END=$(echo | openssl s_client -servername "$DOMAIN" -connect "$DOMAIN:443" 2>/dev/null | openssl x509 -noout -enddate 2>/dev/null | cut -d= -f2)
if [[ -n "$CERT_END" ]]; then
  CERT_END_EPOCH=$(date -j -f "%b %d %T %Y %Z" "$CERT_END" +%s 2>/dev/null || date -d "$CERT_END" +%s 2>/dev/null)
  NOW_EPOCH=$(date +%s)
  DAYS_LEFT=$(( (CERT_END_EPOCH - NOW_EPOCH) / 86400 ))
  [[ $DAYS_LEFT -lt 14 ]] && ISSUES+=("Cert TLS expire dans $DAYS_LEFT jours")
else
  ISSUES+=("Impossible de lire le certificat TLS")
fi

# 4. Fichiers sensibles doivent renvoyer 404
for path in "/.env" "/.git/config" "/.DS_Store" "/composer.json" "/storage/logs/laravel.log"; do
  CODE=$(curl -s -o /dev/null -w "%{http_code}" --max-time 8 "https://$DOMAIN$path")
  [[ "$CODE" != "404" ]] && ISSUES+=("$path renvoie $CODE au lieu de 404")
done

# 5. Endpoints critiques up
for url in "https://$DOMAIN/" "https://$APEX/" "https://$ADMIN/" "https://$DOMAIN/.well-known/security.txt"; do
  CODE=$(curl -s -o /dev/null -w "%{http_code}" --max-time 10 "$url")
  [[ "$CODE" != "200" && "$CODE" != "301" ]] && ISSUES+=("$url renvoie $CODE")
done

# 6. DNS — DMARC/SPF présent
DMARC=$(dig +short "_dmarc.$APEX" TXT 2>/dev/null)
[[ -z "$DMARC" ]] && ISSUES+=("DMARC absent")
SPF=$(dig +short "$APEX" TXT 2>/dev/null | grep -i "v=spf1")
[[ -z "$SPF" ]] && ISSUES+=("SPF absent")

# 7. TLS protocol >= 1.2
TLS_PROTO=$(echo | openssl s_client -servername "$DOMAIN" -connect "$DOMAIN:443" 2>/dev/null | grep -E "^\s*Protocol\s*:" | awk -F: '{print $2}' | xargs)
[[ "$TLS_PROTO" != "TLSv1.3" && "$TLS_PROTO" != "TLSv1.2" ]] && ISSUES+=("TLS proto faible: $TLS_PROTO")

# ============================================================
# AUTO-FIX (sur dérive de config nginx)
# ============================================================
NGINX_DRIFT=false
for h in "Strict-Transport-Security" "Content-Security-Policy" "Cross-Origin-Opener-Policy"; do
  grep -qi "^$h:" <<<"$HEADERS" || NGINX_DRIFT=true
done

if [[ "$NGINX_DRIFT" == "true" ]]; then
  log "⚠️  Dérive headers détectée → restauration nginx"
  CONF_SRC="$(dirname "$0")/nginx-neogtb.conf"
  HARDEN_SRC="$(dirname "$0")/nginx-hardening.sh"
  if [[ -f "$CONF_SRC" && -f "$HARDEN_SRC" ]]; then
    if scp -o ConnectTimeout=10 -o BatchMode=yes "$CONF_SRC" "$HARDEN_SRC" "$SSH_HOST:/tmp/" 2>/dev/null \
       && ssh -o ConnectTimeout=10 -o BatchMode=yes "$SSH_HOST" 'bash /tmp/nginx-hardening.sh' >>"$LOG" 2>&1; then
      FIXES_APPLIED+=("Restauration config nginx (headers manquants)")
      log "✅ Restauration nginx OK"
    else
      ISSUES+=("Restauration nginx ÉCHOUÉE")
      log "❌ Restauration nginx ÉCHOUÉE"
    fi
  fi
fi

# ============================================================
# REPORT
# ============================================================
{
  printf '{\n'
  printf '  "ts": "%s",\n' "$TS"
  printf '  "domain": "%s",\n' "$DOMAIN"
  printf '  "issues_count": %d,\n' "${#ISSUES[@]}"
  printf '  "fixes_count": %d,\n' "${#FIXES_APPLIED[@]}"
  printf '  "issues": ['
  for i in "${!ISSUES[@]}"; do
    [[ $i -gt 0 ]] && printf ','
    printf '\n    "%s"' "${ISSUES[$i]//\"/\\\"}"
  done
  printf '\n  ],\n'
  printf '  "fixes": ['
  for i in "${!FIXES_APPLIED[@]}"; do
    [[ $i -gt 0 ]] && printf ','
    printf '\n    "%s"' "${FIXES_APPLIED[$i]//\"/\\\"}"
  done
  printf '\n  ],\n'
  printf '  "cert_days_left": %s,\n' "${DAYS_LEFT:-null}"
  printf '  "tls_proto": "%s"\n' "$TLS_PROTO"
  printf '}\n'
} > "$REPORT"

log "📝 Rapport → $REPORT (${#ISSUES[@]} issues, ${#FIXES_APPLIED[@]} fixes)"

# ============================================================
# NOTIFICATION (uniquement si anomalie ou fix)
# ============================================================
if [[ ${#ISSUES[@]} -gt 0 || ${#FIXES_APPLIED[@]} -gt 0 ]]; then
  MSG="🦞 Veille sécu neogtb.fr — ${#ISSUES[@]} issue(s), ${#FIXES_APPLIED[@]} fix(es)"
  for x in "${ISSUES[@]}";       do MSG+=$'\n'"❌ $x"; done
  for x in "${FIXES_APPLIED[@]}"; do MSG+=$'\n'"✅ $x"; done
  MSG+=$'\n'"📁 $REPORT"

  log "📤 Notification WhatsApp"
  /opt/homebrew/bin/openclaw message send \
    --channel whatsapp --target "+33650143252" \
    --message "$MSG" >> "$LOG" 2>&1 || log "⚠️  Notif WhatsApp KO"
else
  log "✅ Tout OK — pas de notification"
fi

log "🏁 Fin de veille"
