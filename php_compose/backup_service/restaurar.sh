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
RESPALDO_DIR="./respaldo"

echo
echo "=== INICIANDO RESTAURACIÓN ==="
echo

# 1) Detectar el primer archivo .tar.gz en RESPALDO_DIR
echo "[1/7] Buscando archivos .tar.gz en: $RESPALDO_DIR"
BACKUP_FILE="$(ls "${RESPALDO_DIR}"/*.tar.gz 2>/dev/null | head -n1 || true)"
if [[ -n "$BACKUP_FILE" ]]; then
  BNAME="$(basename "$BACKUP_FILE")"
  echo "[1/7] Se encontró respaldo: $BNAME"
else
  echo "[1/7] NO se encontró ningún .tar.gz en $RESPALDO_DIR"
fi

# 2) Detener servicios mysql_6 y backup_service
echo
echo "[2/7] Deteniendo servicios: $SERVICIO_MYSQL y $SERVICIO_BACKUP"
docker compose stop "$SERVICIO_MYSQL" "$SERVICIO_BACKUP" || true

# 3) Bajar contenedores y volúmenes nombrados (incluye db_data)
echo
echo "[3/7] Ejecutando 'docker compose down -v' para borrar contenedores y volúmenes"
docker compose down -v

# 4) Averiguar el nombre real del volumen db_data
echo
echo "[4/7] Obteniendo nombre real del volumen 'db_data'"
PROJECT_NAME="$(basename "$PWD" | tr '[:upper:]' '[:lower:]')"
VOLUME_NAME="${PROJECT_NAME}_db_data"
echo "[4/7] Volumen lógico: db_data → Nombre real en Docker: $VOLUME_NAME"

# 5) Crear el volumen vacío
echo
echo "[5/7] Creando volumen vacío: $VOLUME_NAME"
docker volume create "$VOLUME_NAME" >/dev/null

# 6) Si hay backup, extraerlo al volumen
if [[ -n "$BACKUP_FILE" ]]; then
  echo
  echo "[6/7] Iniciando extracción de $BNAME en el volumen $VOLUME_NAME..."

  #
  # Determinar la ruta correcta a “respaldo” en Windows vs Linux:
  #
  # En Git Bash, “pwd -W” devuelve C:/Users/... con barras '/'. En WSL, “pwd” devuelve /mnt/c/....
  # En Linux puro, “pwd” ya está en formato /home/usuario/...
  #
  # Detectamos si existe el comando “pwd -W” (para Git Bash). Si no, usamos “pwd”.
  #
  if command -v pwd &>/dev/null && pwd -W &>/dev/null; then
    # Estoy en Git Bash
    HOST_RESPALDO="$(pwd -W)/respaldo"
  else
    # Estoy en WSL o Linux nativo
    HOST_RESPALDO="$(pwd)/respaldo"
  fi

  echo "[6/7] Montando host $HOST_RESPALDO → contenedor:/respaldo"

  docker run --rm \
    -v "${VOLUME_NAME}":/var/lib/mysql \
    -v "${HOST_RESPALDO}":/respaldo \
    alpine:3.17 \
    sh -c "\
      echo '    • Listando /respaldo dentro del contenedor:'; \
      ls -l /respaldo; \
      echo '    • Limpiando /var/lib/mysql ...'; \
      rm -rf /var/lib/mysql/*; \
      echo '    • Ejecutando tar xzvf /respaldo/$BNAME -C /var/lib/mysql ...'; \
      tar xzvf /respaldo/$BNAME -C /var/lib/mysql; \
      echo '    • Ajustando permisos a 999:999 en /var/lib/mysql ...'; \
      chown -R 999:999 /var/lib/mysql; \
      echo '    • Extracción y permisos finalizados.'; \
    "

  echo "[6/7] Extracción completada."
else
  echo
  echo "[6/7] No había respaldo en $RESPALDO_DIR. El volumen quedó vacío."
  echo "[6/7] Al arrancar mysql_6, se ejecutarán los scripts en /docker-entrypoint-initdb.d/."
fi

# 7) Levantar todos los servicios de nuevo
echo
echo "[7/7] Levantando todos los servicios definidos en docker-compose.yml"
docker compose up -d

echo
echo "=== RESTAURACIÓN FINALIZADA ==="
echo

# 8) Mantener la consola abierta hasta que el usuario presione Enter
read -p "Presiona Enter para cerrar..." dummy
