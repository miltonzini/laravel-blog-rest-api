# Blog Rest API - Laravel 11

Este proyecto es una rest api para un **Sistema de administración de blog** desarrollado en **Laravel 11**. 
La idea de este repositorio es mostrar y ensayar el desarrollo de una api completa con autenticación, autorización, roles de usuario, etc.

## Índice
- [Instalación](#-instalación)
- [Documentación de API](#-documentación-de-api)
  - [Autenticación](#autenticación)
  - [Endpoints](#endpoints)

## 📦 Instalación
- proximamente!

## 📚 Documentación de API

La API utiliza Laravel Sanctum para la autenticación basada en tokens. Todos los endpoints están bajo el prefijo `/api/v1`.

### Autenticación

Para acceder a los endpoints protegidos, debes incluir el token de autenticación en el encabezado de la solicitud:

```
Authorization: Bearer {tu_token}
```

#### Endpoints de Autenticación

| Método | URI | Descripción | Protegido |
|--------|-----|-------------|-----------|
| POST | `/api/v1/register` | Registrar un nuevo usuario | No |
| POST | `/api/v1/login` | Iniciar sesión y obtener token | No |
| POST | `/api/v1/logout` | Cerrar sesión (elimina tokens) | Sí |

##### Registro de Usuario

```
POST /api/v1/register
```

**Parámetros de solicitud:**

```json
{
  "name": "string, requerido, máx:255",
  "email": "string, requerido, email, único",
  "password": "string, requerido",
  "password_confirmation": "string, requerido, debe coincidir con password"
}
```

**Respuesta exitosa:**

```json
{
  "user": {
    "id": "integer",
    "name": "string",
    "email": "string",
    "created_at": "timestamp",
    "updated_at": "timestamp"
  },
  "token": "string"
}
```

##### Inicio de Sesión

```
POST /api/v1/login
```

**Parámetros de solicitud:**

```json
{
  "email": "string, requerido, email, debe existir",
  "password": "string, requerido"
}
```

**Respuesta exitosa:**

```json
{
  "user": {
    "id": "integer",
    "name": "string",
    "email": "string",
    "created_at": "timestamp",
    "updated_at": "timestamp"
  },
  "token": "string"
}
```

**Respuesta de error:**

```json
{
  "message": "The provided credentials are incorrect"
}
```

##### Cierre de Sesión

```
POST /api/v1/logout
```

**Cabeceras requeridas:**
- `Authorization: Bearer {token}`

**Respuesta exitosa:**

```json
{
  "message": "Yoy are logged out"
}
```

### Endpoints

#### Posts

| Método | URI | Descripción | Protegido |
|--------|-----|-------------|-----------|
| GET | `/api/v1/posts` | Listar todos los posts (paginado) | No |
| POST | `/api/v1/posts` | Crear un nuevo post | Sí |
| GET | `/api/v1/posts/{post}` | Ver un post específico | No |
| PUT/PATCH | `/api/v1/posts/{post}` | Actualizar un post | Sí* |
| DELETE | `/api/v1/posts/{post}` | Eliminar un post | Sí* |

\* Requiere ser el propietario del post

##### Listar Posts

```
GET /api/v1/posts
```

**Parámetros de consulta (query):**
- `page`: Número de página (por defecto: 1)
- `per_page`: Cantidad de elementos por página (por defecto: 20)

**Respuesta:**
```json
{
  "current_page": 1,
  "data": [
    {
      "id": "integer",
      "title": "string",
      "body": "string",
      "user_id": "integer",
      "created_at": "timestamp",
      "updated_at": "timestamp"
    },
    // ... más posts
  ],
  "first_page_url": "string",
  "from": "integer",
  "last_page": "integer",
  "last_page_url": "string",
  "links": [
    {
      "url": "string|null",
      "label": "string",
      "active": "boolean"
    }
    // ... más links
  ],
  "next_page_url": "string|null",
  "path": "string",
  "per_page": 20,
  "prev_page_url": "string|null",
  "to": "integer",
  "total": "integer"
}
```

##### Crear Post

```
POST /api/v1/posts
```

**Cabeceras requeridas:**
- `Authorization: Bearer {token}`

**Parámetros de solicitud:**

```json
{
  "title": "string, requerido, máx:255",
  "body": "string, requerido"
}
```

**Respuesta:**
El objeto post creado.

##### Ver Post

```
GET /api/v1/posts/{post}
```

**Respuesta:**
El objeto post solicitado.

##### Actualizar Post

```
PUT/PATCH /api/v1/posts/{post}
```

**Cabeceras requeridas:**
- `Authorization: Bearer {token}`

**Restricciones:**
- El usuario debe ser el propietario del post

**Parámetros de solicitud:**

```json
{
  "title": "string, requerido, máx:255",
  "body": "string, requerido"
}
```

**Respuesta exitosa:**
El objeto post actualizado.

**Respuesta de error (403):**
```json
{
  "message": "You do not own this post."
}
```

##### Eliminar Post

```
DELETE /api/v1/posts/{post}
```

**Cabeceras requeridas:**
- `Authorization: Bearer {token}`

**Restricciones:**
- El usuario debe ser el propietario del post

**Respuesta exitosa:**
```json
{
  "message": "The post was deleted"
}
```

**Respuesta de error (403):**
```json
{
  "message": "You do not own this post."
}
```