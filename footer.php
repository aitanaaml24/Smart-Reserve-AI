    </div>

</main>

<footer class="pie-sistema">

    <div class="pie-contenido">

        <div>

            <strong>Smart Reserve AI</strong>

            <p>
                Sistema de gestión de reservaciones
                para restaurantes.
            </p>

        </div>

        <span>
            &copy; <?= date("Y") ?> Proyecto académico
        </span>

    </div>

</footer>

<script>

const botonMenu =
    document.getElementById("boton-menu-movil");

const navegacion =
    document.getElementById("navegacion-principal");

if (botonMenu && navegacion) {

    botonMenu.addEventListener("click", function () {

        navegacion.classList.toggle("mostrar");

        const abierto =
            navegacion.classList.contains("mostrar");

        botonMenu.setAttribute(
            "aria-expanded",
            abierto ? "true" : "false"
        );

        botonMenu.innerHTML = abierto
            ? '<i class="bi bi-x-lg"></i>'
            : '<i class="bi bi-list"></i>';

    });

}

</script>

</body>
</html>
