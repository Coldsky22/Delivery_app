<script setup>
import {ref, onMounted, reactive, watch} from 'vue'
import {useQuasar} from 'quasar'
//определение переменных
const DEFAULT_PAGINATION = {
    sortBy: 'desc',
    descending: false,
    page: 1,
    rowsPerPage: 10,
    rowsNumber: 10
}

const deliveries = ref([])
const columns = ref([
    {
        label: 'ID',
        field: 'id'
    },
    {
        label: 'Адрес доставки',
        field: 'address',
        align: 'left'
    },
    {
        label: 'Город',
        field: 'city_id',
        format: val => `${getCityName(val)} (${val})`
    },
    {
        label: 'Дата доставки',
        field: 'delivery_date'
    },
    {
        label: 'Имя клиента',
        field: 'client_name',
        align: 'left'
    },
    {
        label: 'Телефон',
        field: 'client_phone',
        align: 'left'
    },
    {
        name: 'status',
        label: 'Статус',
        field: row => row.status,
        align: 'left'
    },
    {
        label: 'Дата создания',
        field: 'created_at',
        align: 'left',
        format: val => getDate(val)
    },
    {
        label: 'Дата изменения',
        field: 'updated_at',
        align: 'left',
        format: val => getDate(val)
    }
])
const pagination = ref(DEFAULT_PAGINATION)
const loader = ref(false)
const tableRef = ref()

const cities = ref([])
const filteredCities = ref([])

const filters = reactive({
    city: undefined,
    delivery_date: undefined
})

const $q = useQuasar()
// Отслеживание изменений в объекте фильтров
watch(filters, val => {
    pagination.value = DEFAULT_PAGINATION
    tableRef.value.requestServerInteraction()
})
// Загрузка данных при монтировании компонента
onMounted(() => {
    getCities()
    tableRef.value.requestServerInteraction()
})
// Функция для получения списка доставок
async function getDeliveries(props) {
    const { page, rowsPerPage, sortBy, descending } = props.pagination
    loader.value = true

    try {
        await axios
            .get('/api/deliveries', {
                params: {
                    page: page,
                    city_id: filters.city && filters.city.id,
                    delivery_date: filters.delivery_date
                }
            })
            .then(response => {
                if (response && response.data && response.data.data) {
                    deliveries.value = response.data.data
                }

                if (response && response.data && response.data.meta) {
                    pagination.value.rowsNumber = response.data.meta.total
                }
            })

        pagination.value.page = page
        pagination.value.rowsPerPage = rowsPerPage
        pagination.value.sortBy = sortBy
        pagination.value.descending = descending
    } catch (e) {
        notifyError(e)
    }
    loader.value = false
}
// форматирование даты
function getDate(val) {
    return val.slice(0, 10) + ', ' + val.slice(11, 19)
}
// получение списка городов
async function getCities() {
    try {
        await axios
            .get('/api/cities')
            .then(response => {
                if (response && response.data && response.data.data) {
                    cities.value = response.data.data
                }
            })
    } catch (e) {
        notifyError(e)
    }
}
// получение имени города
function getCityName(id) {
    if (cities.value.length) {
        const city = cities.value.find(item => item.id === id)

        if (city) {
            return city.name
        }
    }

    return undefined
}
//фильтрация городов
function filterFn (val, update) {
    if (val === '') {
        update(() => {
            filteredCities.value = cities.value
        })
        return
    }

    update(() => {
        const needle = val.toLowerCase()
        filteredCities.value = cities.value.filter(v => v.name.toLowerCase().indexOf(needle) > -1)
    })
}
//обновления доставки
async function updateDelivery(delivery, newData) {
    try {
        const deliveryUpdated = {...delivery, ...newData}
        await axios
            .put(`/api/deliveries/${delivery.id}`, deliveryUpdated)
            .then(response => {
                if (response && response.status === 200) {
                    const index = deliveries.value.findIndex(item => {
                        return item.id === delivery.id
                    })

                    if (index !== -1) {
                        deliveries.value.splice(index, 1, deliveryUpdated)
                    }

                    $q.notify({
                        message: 'Статус успешно обновлён',
                        color: 'positive'
                    })
                }
            })
    } catch (e) {
        notifyError(e)
    }
}
//отображение ошибок
function notifyError(error) {
    if (error && error.response && error.response.data && error.response.data.errors) {
        let errors = Object.values(error.response.data.errors)

        errors.forEach(item => {
            item.forEach(message => {
                $q.notify({
                    message: message,
                    color: 'negative'
                })
            })
        })
    }
}
</script>

<template>
    <!-- Компонент таблицы Quasar -->
    <q-table
        ref="tableRef"
        v-model:pagination="pagination"
        :columns="columns"
        :rows="deliveries"
        :loading="loader"
        row-key="id"
        @request="getDeliveries"
    >
        <template #top>
            <div class="row q-px-lg">
                <q-select
                    v-model="filters.city"
                    class="filter fix-width"
                    label="Город"
                    :disable="loader"
                    :options="filteredCities"
                    option-label="name"
                    dense
                    clearable
                    outlined
                    option-value="id"
                    :display-value="filters.city ? filters.city.name : ''"
                    use-input
                    @filter="filterFn"
                >
                    <template v-slot:no-option>
                        <q-item>
                            <q-item-section class="text-grey">
                                No results
                            </q-item-section>
                        </q-item>
                    </template>
                </q-select>
                <q-input
                    v-model="filters.delivery_date"
                    mask="####-##-##"
                    dense
                    clearable
                    outlined
                    label="Дата доставки"
                    class="filter fix-width"
                    debounce="800"
                >
                    <template #append>
                        <q-icon name="event" class="cursor-pointer">
                            <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                                <q-date
                                    v-model="filters.delivery_date"
                                    mask="YYYY-MM-DD"
                                >
                                    <div class="row items-center justify-end">
                                        <q-btn v-close-popup label="Close" color="primary" flat />
                                    </div>
                                </q-date>
                            </q-popup-proxy>
                        </q-icon>
                    </template>
                </q-input>
            </div>
        </template>

        <template #body-cell-status="props">
            <q-td :props="props">
                <q-select
                    class="fix-width"
                    outlined
                    :model-value="props.value"
                    :options="['новый', 'доставлен', 'отменён']"
                    dense
                    @update:model-value="updateDelivery(props.row, {status: $event})"
                />
            </q-td>
        </template>
    </q-table>
</template>

<style scoped lang="scss">
.filter {
    width: 300px;
}

.fix-width:deep(.row) {
    width: unset;
}
</style>
