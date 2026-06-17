<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";

const estadoClase = (estado) => {
    if (estado === "asignado") {
        return "bg-yellow-100 text-yellow-700";
    }

    if (estado === "en_camino") {
        return "bg-blue-100 text-blue-700";
    }

    if (estado === "entregado") {
        return "bg-green-100 text-green-700";
    }

    return "";
};
defineProps({
    logisticas: Array,
});

// Cambiar estado
const cambiarEstado = (id, estado) => {
    router.put(`/logistica/estado/${id}`, {
        estado,
    });
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Logística" />

        <div class="p-8 bg-gray-100 min-h-screen">
            <!-- Título -->
            <div class="mb-8">
                <h1 class="text-5xl font-bold text-orange-500">
                    Gestión de Entregas
                </h1>

                <p class="text-gray-600 mt-2">
                    Optimización y seguimiento de rutas de reparto.
                </p>
            </div>

            <!-- Tarjetas resumen -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Pendientes -->
                <div
                    class="bg-white rounded-2xl shadow-lg p-6 border-l-8 border-yellow-400"
                >
                    <h2 class="text-xl font-bold text-yellow-500">
                        Pendientes
                    </h2>

                    <p class="text-4xl font-bold mt-3">
                        {{
                            logisticas.filter((i) => i.estado === "asignado")
                                .length
                        }}
                    </p>
                </div>

                <!-- En camino -->
                <div
                    class="bg-white rounded-2xl shadow-lg p-6 border-l-8 border-blue-500"
                >
                    <h2 class="text-xl font-bold text-blue-500">En camino</h2>

                    <p class="text-4xl font-bold mt-3">
                        {{
                            logisticas.filter((i) => i.estado === "en_camino")
                                .length
                        }}
                    </p>
                </div>

                <!-- Entregados -->
                <div
                    class="bg-white rounded-2xl shadow-lg p-6 border-l-8 border-green-500"
                >
                    <h2 class="text-xl font-bold text-green-500">Entregados</h2>

                    <p class="text-4xl font-bold mt-3">
                        {{
                            logisticas.filter((i) => i.estado === "entregado")
                                .length
                        }}
                    </p>
                </div>
            </div>

            <!-- Tabla -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <table class="w-full border-collapse">
                    <thead class="bg-orange-500 text-white">
                        <tr>
                            <th class="p-5">Pedido</th>

                            <th class="p-5">Repartidor</th>

                            <th class="p-5">Teléfono</th>

                            <th class="p-5">Ubicación</th>

                            <th class="p-5">Cliente</th>

                            <th class="p-5">Ruta sugerida</th>

                            <th class="p-5">Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="item in logisticas"
                            :key="item.id"
                            class="border-b hover:bg-orange-50 transition"
                        >
                            <!-- Pedido -->
                            <td class="p-5 text-center font-bold">
                                #{{ item.pedido_id }}
                            </td>

                            <!-- Repartidor -->
                            <td class="p-5 text-center">
                                {{ item.repartidor_nombre }}
                            </td>

                            <!-- Teléfono -->
                            <td class="p-5 text-center">
                                {{ item.repartidor_telefono }}
                            </td>

                            <!-- Ubicación -->
                            <td class="p-5 text-center">
                                📍 {{ item.ubicacion_repartidor }}
                            </td>

                            <!-- Cliente -->
                            <td class="p-5 text-center">
                                {{ item.ubicacion_cliente }}
                            </td>

                            <!-- Ruta -->
                            <td
                                class="p-5 text-center font-semibold text-gray-700"
                            >
                                {{ item.ruta_sugerida }}
                            </td>

                            <!-- Estado -->
                            <td class="p-5 text-center">
                                <select
                                    :value="item.estado"
                                    @change="
                                        cambiarEstado(
                                            item.id,
                                            $event.target.value,
                                        )
                                    "
                                    class="border rounded-xl px-4 py-2 shadow-sm"
                                >
                                    <option value="asignado">Pendiente</option>

                                    <option value="en_camino">En camino</option>

                                    <option value="entregado">Entregado</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
