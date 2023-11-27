<div class="contenedor olvide">

<?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu Password</p>

        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>

        <form action="/olvide" class="formulario" method="POST" novalidate>
            <div class="campo">
                <label for="email">Email</label>
                <input 
                type="email"
                id="email"
                placeholder="Tu email"
                name="email"
                />
            </div>

            <input type="submit" class="boton" value="Enviar" />

        </form>

        <div class="acciones">
            <a href="/crear">¿Aún no tienes una cuenta? Obtener una</a>

            <a href="/">¿Ya tienes cuenta? Inicia sesión</a>
        </div>

    </div><!-- fin contenedor-sm -->
</div>