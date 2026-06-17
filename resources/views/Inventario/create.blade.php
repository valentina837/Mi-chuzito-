<h1>Registrar Inventario</h1>

<form action="/inventario" method="POST">

    @csrf

    <label>Producto</label>

    <select name="producto_id">

        @foreach($productos as $producto)

        <option value="{{ $producto->id }}">
            {{ $producto->name }}
        </option>

        @endforeach

    </select>

    <br><br>

    <label>Cantidad</label>

    <input type="number" name="cantidad">

    <br><br>

    <label>Nivel mínimo</label>

    <input type="number" name="nivel_minimo">

    <br><br>

    <button type="submit">
        Guardar
    </button>

</form>