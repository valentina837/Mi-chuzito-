<h1>Inventario</h1>

<a href="/inventario/create">
    Agregar Inventario
</a>

<br><br>

<table border="1">

    <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Nivel mínimo</th>
        <th>Estado</th>
    </tr>

    @foreach($inventarios as $inventario)

    <tr>

        <td>
            {{ $inventario->producto->name }}
        </td>

        <td>
            {{ $inventario->cantidad }}
        </td>

        <td>
            {{ $inventario->nivel_minimo }}
        </td>

        <td>
            {{ $inventario->estado }}
        </td>

    </tr>

    @endforeach

</table>