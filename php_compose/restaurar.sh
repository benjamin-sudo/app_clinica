#!/usr/bin/env bash
set -euo pipefail

# -----------------------------
# INICIALIZAR LOG
LOGFILE="./restaurar.log"
: > "$LOGFILE"
exec > >(tee -a "$LOGFILE") 2>&1
# -----------------------------

SERVICIO_MYSQL="mysql_6"
SERVICIO_BACKUP="backup_service"
RESPALDO_DIR="./backup_service/respaldo"

echo; echo "=== INICIANDO RESTAURACIÓN ==="; echo

echo "[1/7] Buscando archivos .tar.gz en: $RESPALDO_DIR"
BACKUP_FILE="$(ls "${RESPALDO_DIR}"/*.tar.gz 2>/dev/null | head -n1 || true)"
if [[ -n "$BACKUP_FILE" ]]; then
  BNAME="$(basename "$BACKUP_FILE")"
  echo "[1/7] Se encontró respaldo: $BNAME"
else
  echo "[1/7] NO se encontró ningún .tar.gz en $RESPALDO_DIR"
fi

echo; echo "[2/7] Deteniendo servicios: $SERVICIO_MYSQL y $SERVICIO_BACKUP"
docker compose stop "$SERVICIO_MYSQL" "$SERVICIO_BACKUP" || true

echo; echo "[3/7] Ejecutando 'docker compose down -v' para borrar contenedores y volúmenes"
docker compose down -v

echo; echo "[4/7] Obteniendo nombre real del volumen 'db_data'"
PROJECT_NAME="$(basename "$PWD" | tr '[:upper:]' '[:lower:]')"
VOLUME_NAME="${PROJECT_NAME}_db_data"
echo "[4/7] Volumen lógico: db_data → Nombre real en Docker: $VOLUME_NAME"

echo; echo "[5/7] Creando volumen vacío: $VOLUME_NAME"
docker volume create "$VOLUME_NAME" >/dev/null

if [[ -n "$BACKUP_FILE" ]]; then
  echo; echo "[6/7] Iniciando extracción de $BNAME en el volumen $VOLUME_NAME..."
  if command -v pwd &>/dev/null && pwd -W &>/dev/null; then
    HOST_RESPALDO="$(pwd -W)/backup_service/respaldo"
  else
    HOST_RESPALDO="$(pwd)/backup_service/respaldo"
  fi
  echo "[6/7] Montando host $HOST_RESPALDO → contenedor:/respaldo"

  docker run --rm \
    -v "${VOLUME_NAME}":/var/lib/mysql \
    -v "${HOST_RESPALDO}":/respaldo \
    alpine:3.17 \
    sh -c "\
      echo '    Listando /respaldo dentro del contenedor:';\
      ls -l /respaldo; \
      echo '    Limpiando /var/lib/mysql ...'; rm -rf /var/lib/mysql/*; \
      echo '    Ejecutando tar xzvf /respaldo/$BNAME -C /var/lib/mysql ...';\
      tar xzvf /respaldo/$BNAME -C /var/lib/mysql; \
      echo '    Ajustando permisos a 999:999 en /var/lib/mysql ...';\
      chown -R 999:999 /var/lib/mysql; \
      echo '    Extracción y permisos finalizados.'; \
    "

  echo "[6/7] Extracción completada."
else
  echo; echo "[6/7] No había respaldo en $RESPALDO_DIR. El volumen quedó vacío."
  echo "[6/7] Al arrancar mysql_6, se ejecutarán los scripts en /docker-entrypoint-initdb.d/."
fi

echo; echo "[7/7] Levantando todos los servicios definidos en docker-compose.yml"
# Aquí llamamos CON override para que MySQL no intente --initialize:
docker compose -f docker-compose.yml -f docker-compose.restore.yml up -d

echo; echo "=== RESTAURACIÓN FINALIZADA ==="; echo
read -p "Presiona Enter para cerrar..." dummy
