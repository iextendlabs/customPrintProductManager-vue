<template>
<div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Products</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="d-sm-inline-block form-inline">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for..."
                                    aria-label="Search" aria-describedby="basic-addon2" v-model="search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" v-on:click="searchProduct">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                            <div style="float:right;">
                                <router-link :to="{name:'productAdd'}" class="btn btn-primary">Create</router-link>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"  style="text-align: center;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>SKU</th>
                                            <th>Drive Link</th>
                                            <th>Artcut File</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="products.length>0">
                                        <tr v-for="(product,index) in products" :key="index">
                                            <td>{{ ++index}}</td>
                                            <td>
                                                <img :src="'/productimage/'+product.image" alt="image" height="90px" width="90px" style="border-radius: 100%; vertical-align: middle;"/>
                                            </td>
                                            <td>{{ product.name }}</td>
                                            <td>{{ product.sku }}</td>
                                            <td>
                                                <a :href="product.driveLink" target="_blank">Click</a>
                                            </td>
                                            <th><button type="button" v-on:click="download(product.artcutFile)" class="btn btn-success"><i class="fas fa-download fa-1x text-gray-300"></i></button></th>
                                            <td>
                                                <button type="button" v-on:click="editProduct(product.id)" class="btn btn-success">Edit</button>
                                                <button type="button" v-on:click="deleteProduct(product.id)" class="btn btn-danger">Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="7" align="center"> No result </td>
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
            products:[],
            api:'http://127.0.0.1:8000/api/product',
            search:'',
            image:'/productimage/no-image.png'
        }
    },
    mounted() {
        this.getProducts();
    },
    methods:{
        async getProducts(){
            await this.axios.get(this.api).then(response=>{
                this.products = response.data
            }).catch(error=>{
                console.log(error)
                this.products = []
            })
        },

        deleteProduct(id){
            if(confirm("Are you sure to delete this product?")){
                this.axios.delete(this.api+'/'+id).then(response=>{
                    this.getProducts()
                }).catch(error=>{
                    console.log(error)
                })
            }
        },

        editProduct(id) {
                this.$router.push({
                    name: "productEdit",

                    params: {
                        id: id
                    }
                });
        },

        searchProduct(){
            var searchItem = this.search.toLowerCase();
            axios
                    .get(this.api+'?search=' + searchItem)
                    .then(response => {
                        this.products = response.data
                    })
                    .catch(error => {
                        console.log(error.response);
                    });
        },

        download(file){
            window.open(`/download/${file}`, "_blank");
        }
    }
    };

</script>