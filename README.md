# Confesiones anonimas (www.confesiones.cf)

**Conectar confesiones a la base de datos**

- Entras a la carpeta 'core'
- Abres el archivo 'server.php'
- Allí vas a ingreasar los datos MySQL de tu servidor

***PD: Recuerda que el panel administrativo es independiente de la web asi que deberas hacer conexión del panel a la base de datos, es el mismo proceso.***

**Advertencias y notas**
1. Recuerda que esto es un proyecto realizado desde cero, tambien deberas tener en cuenta que soy un aprendiz asi que puede tener vulnerabilidades el sitio web donde puedan hacerte SQL Inject, asi que revisa antes de hacer publico el sitio, trate de hacer todas las validaciones posibles (no son las mejores validaciones pero cumplen su función).
2. Este sitio web es totalmente open-source asi que puedes mejorar y distribuirlo, no tengo problemas con nada solo que respeten los creditos es todo.
3. El panel administrativo su CSS no es mio, uso boostrap asi que no tomo todo el credito pero si de las funciones y el resto de cosas.

**Cosas por hacer**
- Al momento de publicar una confesion, cada confesion genera una id aleatoria que es con la que se va identificar para hacer futuras funciones, pero falta que esa id verifique que no este ya registrada asi que no olviden hacer esa validacion.
- La web es casi completamente responsive, solo les toca acomodar un poco el navbar por que se pone algo loco, pero eso se arregla facilmente.
- Hacer validacion la cual solo pueda hacer una publicacion cada X tiempo para evitar mega spam.
- Hacer el ajax/javascript/jquery de scroll infinito en las publicaciones ya que actualmente carga todo lo de la base de datos. (Si lo hacen les agradeceria que me manden actualizado para asi subirlo).
- Configurar bien el archivo .htaccess


Todos los derechos reservados - Realizado por Sorac
- Mi twitch -> https://www.twitch.tv/elsorac_
- Mi canal de youtube -> https://www.youtube.com/c/sorac
- Mi servidor discord -> https://discord.gg/V4gq2p6MfR
