<template>
<div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Orders</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div style="float:right;">
                                <router-link :to="{name:'orderAdd'}" class="btn btn-primary">Create</router-link>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="text-align: center;">
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
                                        <tr v-for="(order,index) in orders" :key="index" >
                                            <td>{{ ++index}}</td>
                                            <td>
                                                <img :src="'/orderimage/'+order.image" alt="image" height="90px" width="90px" style="border-radius: 100%; vertical-align: middle;"/>
                                            </td>
                                            <td v-if="order.status == 0">Padding</td>
                                            <td v-else>Delivered</td> 
                                            <td>{{ order.created_at.substring(0, 10) }}</td>
                                            <td v-if="order.checked == 1">
                                                <button type="button" @click="viewOrder(order.id)" class="btn btn-success">View</button>
                                                <button type="button" @click="deleteOrder(order.id)" class="btn btn-danger">Delete</button>
                                            </td>
                                            <td v-else class="test">
                                                <button type="button" @click="viewOrder(order.id)" class="btn btn-success">View</button>
                                                <button type="button" @click="deleteOrder(order.id)" class="btn btn-danger">Delete</button>
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
            api:'http://127.0.0.1:8000/api/order',
            search:'',
            image:'/no-image.png'
        }
    },
    mounted() {
        this.getOrders();
    },
    methods:{
        async getOrders(){
            await this.axios.get(this.api).then(response=>{
                this.orders = response.data
            }).catch(error=>{
                console.log(error)
                this.orders = []
            })
        },
        deleteOrder(id){
            if(confirm("Are you sure to delete this order?")){
                this.axios.delete(this.api+'/'+id).then(response=>{
                    this.getOrders()
                }).catch(error=>{
                    console.log(error)
                })
            }
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