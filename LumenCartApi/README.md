# Cart Service (Servicio de Carrito de Compras)

Microservicio de gestión de carrito de compras construido con Laravel Lumen.

## Puerto

**Puerto**: `8009`

## Descripción

Este microservicio gestiona el carrito de compras de los usuarios, permitiendo:
- Agregar items al carrito
- Actualizar cantidades
- Eliminar items
- Vaciar el carrito completo
- Procesar checkout

## Endpoints Disponibles

### 1. GET /cart/{user_id} - Obtener carrito
### 2. POST /cart/items - Agregar item
### 3. PUT /cart/items/{id} - Actualizar cantidad
### 4. DELETE /cart/items/{id} - Eliminar item
### 5. DELETE /cart/{user_id}/clear - Vaciar carrito
### 6. POST /cart/{user_id}/checkout - Procesar checkout

## Instalación y Uso

Ver documentación completa en el archivo.
