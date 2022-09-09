<template>
    <div class="row">
        <div class="search-wrapper panel-heading col-sm-12">
<!--            <input class="form-control" @input="getTextSearch($event)" type="text" placeholder="Search" />-->
            <input class="form-control"  type="text" placeholder="Search" v-model="search_data" />
        </div>
    </div>
    <div id="table_clients" class="scrollable">
        <table id="client_table" class="table  table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th class="th-sm">ФИО</th>
                <th class="th-sm">Пол</th>
                <th class="th-sm">Телефон</th>
                <th class="th-sm">Адрес</th>
            </tr>
            </thead>

            <tbody slot="body" class="" >
                <tr v-for="client in searchRow" :key="client.id" @click="SelectedRowClientClick(client.id)" :class="{'table-success': (client.id == selectedClient)}">
                    <td>{{ client.fio }}</td>
                    <td>{{ client.gender }}</td>
                    <td>{{ client.phone }}</td>
                    <td>{{ client.address }}
                             <input class="hidden" type="hidden" name="id" value={{client.id}}>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>


<script>

export default {
    name: "Clients",
    data() {
        return {
            clients: [],
            cars: [],
            search_data: '',
            selectedClient: null
        }
    },

    created() {
        axios.get('/api/view_autopark/get_clients').then(response => {
            this.clients = response.data;
        });
    },
    computed:
    {
        searchRow() {
            return this.clients.filter(client => {
                const SearchData = this.search_data.toLowerCase();
                return client.fio.toLowerCase().includes(SearchData) ||
                    client.gender.toLowerCase().includes(SearchData)  || client.phone.includes(SearchData) ||
                    client.address.toLowerCase().includes(SearchData);
            });
        }
    },
    methods: {
        SelectedRowClientClick: function (id)
        {
            this.selectedClient = id;
            this.$emit("ClientSelected", id);
        }

    },

    }
</script>

<style scoped>
    .scrollable {
        overflow-y: scroll;
        max-height: 220px;
    }
</style>
