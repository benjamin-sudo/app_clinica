#!/bin/sh

TELEGRAM_TOKEN="${TELEGRAM_TOKEN}"
CHAT_ID="${TELEGRAM_CHAT_ID}"

if [ -z "$TELEGRAM_TOKEN" ] || [ -z "$CHAT_ID" ]; then
  echo "TELEGRAM_TOKEN o CHAT_ID no están definidos."
  exit 1
fi

UPTIME=$(uptime)
DISK=$(df -h / | tail -1)
DOCKER=$(docker stats --no-stream --format "table {{.Name}}\t{{.CPUPerc}}\t{{.MemUsage}}" 2>/dev/null)
EXITED=$(docker ps -a --filter "status=exited" --format "table {{.Names}}\t{{.Status}}" 2>/dev/null)

MSG="Reporte del servidor (cada hora)

Uptime: $UPTIME
Disco: $DISK

Docker Stats:
\`\`\`
$DOCKER
\`\`\`

Contenedores detenidos:
\`\`\`
$EXITED
\`\`\`
"

curl -s -X POST "https://api.telegram.org/bot${TELEGRAM_TOKEN}/sendMessage" \
  -d chat_id="${CHAT_ID}" \
  -d parse_mode="Markdown" \
  --data-urlencode "text=$MSG"
