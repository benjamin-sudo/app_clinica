#!/bin/sh

# Cargar variables desde archivo externo
. /envs/.env.telegram

# Validar variables
if [ -z "$TELEGRAM_TOKEN" ] || [ -z "$TELEGRAM_CHAT_ID" ]; then
  echo "TELEGRAM_TOKEN o TELEGRAM_CHAT_ID no están definidos."
  exit 1
fi

# Recolección de datos
UPTIME=$(uptime)
DISK=$(df -h / | tail -1)
DOCKER=$(docker stats --no-stream --format "table {{.Name}}\t{{.CPUPerc}}\t{{.MemUsage}}" 2>/dev/null)
EXITED=$(docker ps -a --filter "status=exited" --format "table {{.Names}}\t{{.Status}}" 2>/dev/null)

# Construcción del mensaje (Markdown)
MSG="*Reporte del servidor (cada hora)*

*Uptime:*
\`$UPTIME\`

*Disco:*
\`$DISK\`

*Docker Stats:*
\`\`\`
$DOCKER
\`\`\`

*Contenedores detenidos:*
\`\`\`
$EXITED
\`\`\`"

# Enviar a Telegram
curl -s -X POST "https://api.telegram.org/bot${TELEGRAM_TOKEN}/sendMessage" \
  -d chat_id="${TELEGRAM_CHAT_ID}" \
  -d parse_mode="Markdown" \
  --data-urlencode "text=$MSG"
