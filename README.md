# API REST de Gestión de Tareas

Servicio de gestión de tareas implementado como demostración práctica del desarrollo de APIs RESTful, validación de datos, pruebas automatizadas y empaquetado con Docker.

## 🛠️ Lenguaje y Framework Utilizado:
Se seleccionó **PHP y Laravel** por los siguientes motivos:
- **Facilidad y herramientas integradas:** Laravel cuenta con herramientas que facilitan grandemente la construcción de una API REST.
- **Integración sencilla con Swagger:** Gracias a su gestor de dependencias (Composer) y paquetes como `l5-swagger`, Laravel permite integrar y mantener documentación OpenAPI/Swagger directamente sobre el código de forma ágil y estandarizada.
- **Experiencia previa:** Es la tecnología con la que poseo mayor experiencia práctica, lo que me facilitó su desarrollo y me permitió crear una API bien estructurada y funcional.

---

## 📋 Endpoints de la API

| Método | Ruta | Descripción |
| :--- | :--- | :--- |
| **GET** | `/api/tasks` | Lista todas las tareas existentes |
| **GET** | `/api/tasks/{id}` | Obtiene una tarea específica por su ID |
| **POST** | `/api/tasks` | Crea una nueva tarea (`title`, `description`, `isCompleted`) |
| **PUT** | `/api/tasks/{id}` | Actualiza una tarea existente |
| **DELETE** | `/api/tasks/{id}` | Elimina una tarea |

---

## 🚀 Ejecución local

Para ejecutar la API directamente en un entorno local sin contenedores, sigue estos pasos según tu sistema operativo y terminal:

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/nmendez0698/tasks-api.git
   ```

2. **Dentro del proyecto, instala las dependencias de PHP:**
   ```bash
   composer install
   ```

3. **Configura el archivo de entorno:**
   * **Linux / macOS / Git Bash:**
     ```bash
     cp .env.example .env
     ```
   * **Windows (PowerShell):**
     ```powershell
     Copy-Item .env.example .env
     ```
   * **Windows (CMD):**
     ```cmd
     copy .env.example .env
     ```

   Luego genera la llave de la aplicación:
   ```bash
   php artisan key:generate
   ```

4. **Configura la base de datos (SQLite) y manejo de sesiones:**
   * Asegúrate de que en tu archivo `.env` el parámetro de base de datos use una ruta relativa para evitar conflictos entre local y Docker:
     ```env
     DB_CONNECTION=sqlite
     DB_DATABASE=database/database.sqlite
     ```
   * Como esta aplicación es una API REST y no requiere el uso de sesiones web, asegúrate de configurar el driver de sesión como `array` en tu `.env` para evitar buscar tablas innecesarias:
     ```env
     SESSION_DRIVER=array
     ```
   * **Crea el archivo de base de datos vacío según tu terminal:**
     * *Linux / macOS / Git Bash:* `touch database/database.sqlite`
     * *Windows (PowerShell):* `New-Item -ItemType File -Force database/database.sqlite`
     * *Windows (CMD):* `type nul > database/database.sqlite`

   * Ejecuta las migraciones:
     ```bash
     php artisan migrate
     ```

5. **Inicia el servidor de desarrollo:**
   ```bash
   php artisan serve
   ```
   La API estará disponible en `http://localhost:8000`.

6. **Ejecutar pruebas automatizadas en local:**
   ```bash
   php artisan test
   ```

---

## 🐳 Ejecución con Docker

El proyecto cuenta con un `Dockerfile` optimizado para incluir las dependencias de desarrollo y permitir la ejecución de pruebas.

1. **Construir la imagen de Docker** (desde la raíz del proyecto):
   ```bash
   docker build -t tasks-api .
   ```

2. **Ejecutar el contenedor** (mapeando el puerto 8000):
   ```bash
   docker run --rm --name tasks-api-container -p 8000:8000 -d tasks-api
   ```

---

## 📖 Documentación de API con Swagger

Puedes explorar y probar todos los endpoints de la API de forma interactiva accediendo a la siguiente ruta una vez que el servidor local o contenedor esté corriendo:

**`http://localhost:8000/api/documentation`**

---

## 🧪 Pruebas Automatizadas

El proyecto incluye pruebas automatizadas para los escenarios de creación exitosa de tarea con código `201`, validación fallida de título vacío con código `400` y tarea no encontrada con código `404`.

Para ejecutarlas dentro del entorno del contenedor, corre:
```bash
docker exec -it tasks-api-container php artisan test
```
---

## 📋 Pipeline de Integración Continua (CI)

El proyecto cuenta con un flujo automatizado en **GitHub Actions** (`.github/workflows/ci.yaml`) que se ejecuta en cada `push` o `pull_request` a las ramas principales, encargándose de:
* Configurar el entorno con **PHP 8.4**.
* Instalar dependencias mediante Composer.
* Configurar SQLite en memoria.
* Ejecutar la suite completa de pruebas automatizadas.