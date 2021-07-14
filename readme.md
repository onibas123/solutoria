# SOLUTORIA TEST
## TEST
- La aplicación consta de dos vistas, la primera y predeterminada permite la visualización de los indicadores economicos que provee la api https://mindicador.cl/, en la cual se listan y la información se renderiza en un graficó tipo evolutivo con fechas asociadas a la selección por parte del usuario. 
- La otra vista, es un CRUD que lista, agrega, actualiza y elimina registros históricos del indicador UF.

## Instalación
- PHP: 5.6 o superior.
- Apache: 2.4.46 
- MySQL - 5.7.15
- jQuery v2.1.4 "https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"
- Bootstrap v4.3.1 "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
- Script charts "https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"
- Fusion theme "https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"
## Usabilidad
	- Clona o descarga el proyecto de este repositorio y muevelo hacia tu directorio del servidor web.
    - El nombre de la carpeta es solutoria y esta contiene todo los archivos necesarios acorde al test descrito.
    - Los parámetros de conectividad hacia la base de datos se encuentran en application/config/database.php.
    - Posteriormente restaura la base de datos mediante el script "solutoria.sql" que se encuentra en la raíz del proyecto.
    - Una vez realizado los pasos anteriores, ve a tu browser y en la barra de direcciones digita "http://localhost/solutoria" (en caso de renombrar la carpeta, se debe considerar para acceder a ella por el navegador).
    - La interfaz de usuario muestra un nav con 2 opciones que son el gráfico y el crud.
## A considerar
    - A futuro para no estar editando el archivo application/config/database.php, se debiese considerar un archivo ".env".
    - En cuanto al rendimiento que mencioné, se puede mejorar y optimizar bastante si se consultan los indicadores por años hacia la api y se recorre el json resultante. Ya que por temas de tiempo prefería setearle día por día e ir consultando hacia la api.