<script setup>
import axios from "axios";
import { ref } from "vue";

const props = defineProps({
    products: Array,
    movements: Array,
});

const products = ref(props.products);

const mostrarHistorial = ref(false);

const actualizarStock = async (id, stock) => {
    if (stock < 0) return;

    const producto = products.value.find((p) => p.id === id);

    if (producto) {
        producto.stock = stock;
        producto.status = stock <= 0 ? "Agotado" : "Disponible";
    }

    try {
        await axios.put(`/inventario/${id}`, {
            stock: stock,
        });
    } catch (error) {
        console.log(error);
    }
};

const cerrarVentas = async () => {
    try {
        await axios.post("/cierre-ventas");

        alert("✅ Ventas cerradas correctamente");

        location.reload();
    } catch (error) {
        console.log(error);
    }
};
</script>

<template>
    <div class="contenedor">
        <h1 class="titulo">Inventario</h1>

        <button class="cierre" @click="cerrarVentas"> Cerrar ventas</button>

        <div class="gridProductos">
            <div class="card" v-for="product in products" :key="product.id">
                <h2>
                    {{ product.name }}
                </h2>

                <p class="stock">
                    📦 Stock disponible:
                    <strong>
                        {{ product.stock }}
                    </strong>
                </p>

                <p class="minimo">
                    ⚠ Stock mínimo:
                    <strong>
                        {{ product.minimum_stock }}
                    </strong>
                </p>

                <span
                    class="estado"
                    :class="{
                        disponible: product.stock > 0,
                        agotado: product.stock <= 0,
                    }"
                >
                    {{ product.stock > 0 ? "Disponible" : "Agotado" }}
                </span>

                <div class="acciones">
                    <button
                        class="menos"
                        @click="actualizarStock(product.id, product.stock - 1)"
                    >
                        -
                    </button>

                    <button
                        class="mas"
                        @click="actualizarStock(product.id, product.stock + 1)"
                    >
                        +
                    </button>
                </div>

                <p
                    v-if="
                        product.stock <= product.minimum_stock &&
                        product.stock > 0
                    "
                    class="alerta"
                >
                    ⚠ Poco stock disponible
                </p>
            </div>
        </div>

        <button
            class="botonHistorial"
            @click="mostrarHistorial = !mostrarHistorial"
        >
            📜
            {{ mostrarHistorial ? "Ocultar historial" : "Ver historial" }}
        </button>

        <div v-if="mostrarHistorial" class="historial">
            <h2 class="tituloHistorial">📜 HISTORIAL DE MOVIMIENTOS</h2>

            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="move in movements" :key="move.id">
                        <td>
                            {{ move.product?.name }}
                        </td>

                        <td>
                            {{ move.quantity }}
                        </td>

                        <td>
                            <span class="salida">
                                {{ move.type }}
                            </span>
                        </td>

                        <td>
                            {{ new Date(move.created_at).toLocaleString() }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>
.contenedor {
    padding: 40px;
    background: #f5f5f5;
    min-height: 100vh;
}

.titulo {
    text-align: center;
    font-size: 45px;
    margin-bottom: 20px;
    color: #333;
}

.cierre {
    background: #ff6b35;
    color: white;
    border: none;
    padding: 15px 25px;
    border-radius: 15px;
    cursor: pointer;
    font-size: 17px;
    font-weight: bold;
    display: block;
    margin: 0 auto 40px auto;
    transition: 0.3s;
}

.cierre:hover {
    transform: scale(1.05);
}

.gridProductos {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 25px;
}

.card {
    background: white;
    border-radius: 25px;
    padding: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
    text-align: center;
}

.card:hover {
    transform: translateY(-5px);
}

.card h2 {
    color: #ff6b35;
    margin-bottom: 20px;
    font-size: 25px;
}

.stock,
.minimo {
    font-size: 18px;
    margin: 12px 0;
}

.estado {
    display: inline-block;
    margin-top: 15px;
    padding: 10px 20px;
    border-radius: 12px;
    color: white;
    font-weight: bold;
    font-size: 16px;
}

.disponible {
    background: green;
}

.agotado {
    background: red;
}

.acciones {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 25px;
}

.mas,
.menos {
    border: none;
    width: 55px;
    height: 55px;
    border-radius: 15px;
    color: white;
    font-size: 24px;
    cursor: pointer;
    transition: 0.3s;
}

.mas {
    background: green;
}

.menos {
    background: red;
}

.mas:hover,
.menos:hover {
    transform: scale(1.1);
}

.alerta {
    margin-top: 20px;
    color: #ff5722;
    font-weight: bold;
    font-size: 17px;
}

.botonHistorial {
    background: #ff6b35;
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 15px;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
    display: block;
    margin: 40px auto;
    transition: 0.3s;
}

.botonHistorial:hover {
    transform: scale(1.05);
}

.historial {
    background: white;
    padding: 30px;
    border-radius: 25px;
    margin-top: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.tituloHistorial {
    text-align: center;
    font-size: 32px;
    margin-bottom: 30px;
    color: #ff6b35;
    font-weight: bold;
}

table {
    width: 100%;
    border-collapse: collapse;
    overflow: hidden;
    border-radius: 15px;
}

thead {
    background: #ff6b35;
    color: white;
}

th {
    padding: 18px;
    font-size: 18px;
}

td {
    padding: 16px;
    text-align: center;
    border-bottom: 1px solid #eee;
    font-size: 16px;
}

tr:hover {
    background: #fff5f2;
}

.salida {
    background: #ffe3db;
    color: #ff5722;
    padding: 6px 14px;
    border-radius: 10px;
    font-weight: bold;
}
</style>
