# Duacode

Este proyecto es un sistema de gestión de jugadores y equipos deportivos, desarrollado utilizando PHP, MySQL y jQuery. Permite la gestión de equipos, jugadores, y su asignación a equipos, así como la edición de datos y la asignación de capitanes.

## Descripción

El sistema permite agregar, editar y eliminar jugadores. Cada equipo tiene capitanes asignados, y los jugadores pueden ser editados en cuanto a su nombre, número y equipo. Además, se verifica que no se repitan números de jugadores dentro de un mismo equipo.

### Funcionalidades principales:

- **Ver equipos**: Muestra todos los equipos y los jugadores asociados a cada equipo.
- **Agregar jugadores**: Permite agregar nuevos jugadores a los equipos.
- **Editar jugadores**: Los jugadores pueden ser editados para cambiar su nombre, número o equipo.
- **Eliminar jugadores**: Permite eliminar jugadores de un equipo.
- **Capitán del equipo**: Se pueden asignar o cambiar los capitanes.

## Tecnologías utilizadas

- PHP
- MySQL
- jQuery
- Bootstrap (para el diseño de la interfaz)
- AJAX (para las actualizaciones sin recargar la página)

## Estructura del Proyecto

├── assets/
│   ├── css/               # Archivos de estilo (CSS)
│   ├── js/                # Archivos de script (JavaScript y jQuery)
│   
├── class/
│   ├── player/            # Lógica relacionada con los jugadores
│   │   ├── PlayerModel.php
│   │   ├── PlayerView.php
│   │   └── PlayerController.php
│   ├── team/              # Lógica relacionada con los equipos
│   │   ├── TeamModel.php
│   │   ├── TeamView.php
│   │   └── TeamController.php
├── inc/
│   └── functions.php      # Funciones de utilidad para el sistema
├── resources/
│   └── navbar.php      # Navbar
├── index.php              # Página principal del sistema
├── autoload.php              # Para cargar los archivos necesarios
├── config.php              # Inicializar las instancias del proyecto
└── README.md              # Este archivo

