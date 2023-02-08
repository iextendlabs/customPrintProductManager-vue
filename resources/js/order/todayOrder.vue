<template>
<div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Today Orders</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <!-- <div style="float:right;">
                                <router-link :to="{name:'orderAdd'}" class="btn btn-primary">Create</router-link>
                            </div> -->
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="orders.length>0">
                                        <tr v-for="(order,index) in orders" :key="index" style="text-align: center;">
                                            <td>{{ ++index}}</td>
                                            <td>
                                                <img :src="'/orderimage/'+order.image" alt="image" height="90px" width="90px" style="border-radius: 100%; vertical-align: middle;"/>
                                            </td>
                                            <td v-if="order.status == 0">Padding</td>
                                            <td v-else>Delivered</td> 
                                            <td>{{ order.created_at.substring(0, 10) }}</td>
                                            <td v-if="order.checked == 0" class="test">
                                                <button type="button" v-on:click="viewOrder(order.id)" class="btn btn-success">View</button>
                                            </td>
                                            <td v-else>
                                                <button type="button" v-on:click="viewOrder(order.id)" class="btn btn-success">View</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5" align="center"> No result </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
</template>
<script>
    export default {
    data(){
        return{
            orders:[],
            image:'/no-image.png'
        }
    },
    mounted() {
        this.getOrders();
    },
    methods:{
        async getOrders(){
            await this.axios.get('/api/todayOrder').then(response=>{
                this.orders = response.data
            }).catch(error=>{
                console.log(error)
                this.orders = []
            })
        },
        viewOrder(id) {
            this.$router.push({
                name: "orderView",

                params: {
                    id: id
                }
            });
        },
    }
    };

</script>

<style>
.test{
    background: rgba(101, 100, 100, 0.2);
}
</style>