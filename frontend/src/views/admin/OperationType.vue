<script setup>
import { getOperationTypesRequest } from "@/api/operationType";
import { ref, onMounted, watch } from "vue";
import { useRouter } from "vue-router";
import { toast } from "vue-sonner";
import CardData from "@/components/cards/CardData.vue";
import Search from "@/components/inputs/Search.vue";
import ButtonAdd from "@/components/buttons/ButtonAdd.vue";
import DataTable from "@/components/tables/DataTable.vue";

const router = useRouter();
const items = ref([]);
const itemsDisplay = ref([]);
const searchQuery = ref("");
const load = ref(true);
const columns = ref([
  { key: "id", label: "ID" },
  { key: "name", label: "Nombre" },
  { key: "description", label: "Descripción" },
]);
const options = ref([{ id: "update", name: "Actualizar", icon: "fa-plus" }]);

async function loadData() {
  load.value = true;
  try {
    const res = await getOperationTypesRequest();
    items.value = res.data;
    itemsDisplay.value = items.value.data;
    load.value = false;
  } catch (error) {
    toast.error("Error al cargar datos");
  }
}

watch(searchQuery, () => {
  searchItems();
});

function searchItems() {
  const filteredItems = items.value.data.filter(
    (item) =>
      item.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      item.description.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
  itemsDisplay.value = filteredItems;
}

async function action(action) {
  if (action.action === "update") {
    router.push({ path: "/update/operations-type", query: { id: action.id } });
  }
}

onMounted(() => {
  loadData();
});
</script>

<template>
  <card-data title="Tipos de operaciones" icon="fa-clipboard-list">
    <template v-slot:filters>
      <div class="pb-4">
        <Search v-model="searchQuery" />
      </div>
      <button-add to="/new/operations-type">
        Agregar tipo de operación
      </button-add>
    </template>
    <DataTable
      :items="itemsDisplay"
      :columns="columns"
      :options="options"
      :modelValue="itemsDisplay"
      @action="action"
    />
  </card-data>
</template>
