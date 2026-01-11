# Sistema de Torneo Tenis de Mesa (Grupos + Eliminación directa)

Aplicación PHP 8.2 + MySQL 8 con arquitectura MVC sencilla. Incluye autenticación, roles, gestión de torneos, grupos, resultados y llaves.

## Requisitos
- PHP 8.2+
- MySQL 8
- Servidor web (Apache/Nginx) apuntando a `public/`

## Instalación
1. Clona el repositorio y configura un virtual host apuntando a `public/`.
2. Crea la base de datos en MySQL.
3. Importa el schema y datos iniciales:

```bash
mysql -u root -p < database/migrations.sql
mysql -u root -p < database/seed.sql
```

4. Copia `.env.example` a `.env` y actualiza credenciales:

```bash
cp .env.example .env
```

Variables disponibles:

```
DB_HOST=127.0.0.1
DB_NAME=tournament
DB_USER=root
DB_PASS=
APP_URL=http://localhost
APP_KEY=base64:tu_clave
```

5. Inicia sesión con:
- **admin@example.com** / **admin123** (cambiar después de ingresar).

## Estructura
```
/app
  /Controllers
  /Core
  /Models
  /Services
  /Views
/public
  index.php
  /theme
/database
  migrations.sql
  seed.sql
```

## Uso
- Administra usuarios (solo ADMIN).
- Crea torneos, categorías, asociaciones y jugadores.
- Gestiona inscripciones por categoría.
- Genera grupos y carga resultados por sets.
- Recalcula standings y genera la llave eliminatoria.
- Edita resultados de partidos y el sistema propaga ganadores.

## Reportes
Usa la vista de llave o grupos y la opción de impresión del navegador.
