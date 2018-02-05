### Utilizando algún framework:

cree las clases que le parezca conveniente tener, en relación a las tablas expuestas, para poder administrar (altas, bajas y modificaciones) los usuarios, sus favoritos, y sus pagos, teniendo en cuenta lo siguiente:
* a) Los usuarios no pueden tener un nombre de usuario vacío (campo “usuario” de la tabla Usuarios), y la edad debe ser mayor a 18.
* b) No deben poder crearse registros muertos (codigousuario inexistente en la tabla Usuarios) en la tabla Favoritos, teniendo en cuenta el control de sus dos campos.
* c) Mismo punto que para la tabla UsuariosPagos
* d) El importe de los Pagos debe ser mayor a cero, y la fecha no puede ser anterior al día de hoy.
Las clases deben contar con todas las validaciones mencionadas, de manera que un programador que no tenga acceso a la documentación igualmente pueda instanciar y utilizar los objetos de estas clases correctamente

Se valorará si se implementa interfaz de usuario.

