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

## 🐳 Ejecución con Docker

El proyecto cuenta con un `Dockerfile` funcional para su construcción y ejecución local en contenedores. 

1. **Construir la imagen de Docker** (desde la raíz del proyecto donde se encuentra el Dockerfile):
   ```bash
   docker build -t tasks-api .
   ```

2. **Ejecutar el contenedor** (mapeando el puerto correspondiente):
   ```bash
   docker run --rm --name task-api-container -p 8000:8000 -d tasks-api
   ```

---

## 📖 Documentación de API con Swagger

Puedes explorar y probar todos los endpoints de la API de forma interactiva accediendo a la siguiente ruta una vez que el contenedor esté corriendo:

**`http://localhost:8000/api/documentation`**

---

## 🧪 Pruebas Automatizadas

El proyecto incluye pruebas automatizadas para los escenarios de creación exitosa de tarea con código `201`, validación fallida de título vacío con código `400` y tarea no encontrada con código `404`.

Para ejecutarlas dentro del entorno del contenedor, corre:
```bash
docker exec -it task-api-container php artisan test
```