<template>
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Edit Product</h1>
                                <button type="button" v-on:click="back()" class="btn btn-info">Back</button><br><br>
                            </div>
                            <form @submit="update" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" v-model="name">
                                            <p class="errors">{{errors.name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Drive Link</label>
                                            <input type="text" class="form-control" v-model="driveLink">
                                            <p class="errors">{{errors.driveLink}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>SKU</label>
                                            <input type="text" class="form-control" v-model="sku">
                                            <p class="errors">{{errors.sku}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Daraz</label><br>
                                            <input class="ml-4" type="radio" value="1" v-model="daraz">
                                            <label>Yes</label>
                                            <input class="ml-4" type="radio" value="0" v-model="daraz">
                                            <label>No</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Decorguys</label><br>
                                            <input class="ml-4" type="radio" value="1" v-model="decorguys">
                                            <label>Yes</label>
                                            <input class="ml-4" type="radio" value="0" v-model="decorguys">
                                            <label>No</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Carstickers</label><br>
                                            <input class="ml-4" type="radio" value="1" v-model="carstickers">
                                            <label>Yes</label>
                                            <input class="ml-4" type="radio" value="0" v-model="carstickers">
                                            <label>No</label>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Image</label><br>
                                            <input type="file" name="image" @change="uploadImage"><br><br>
                                            <img :src="avatar" alt="image" height="100px" width="100px">
                                            <p class="errors">{{errors.image}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label> New Artcut File</label><br>
                                            <input type="file" name="artcutFile" @change="uploadArtcutFile">
                                            <p class="errors">{{errors.artcutFile}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>New Other Artcut File</label><br>
                                            <input type="file" name="otherArtcutFile" @change="uploadOtherArtcutFile">
                                            <p class="errors">{{errors.otherArtcutFile}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>   
</template>
<script>
export default {
    data(){
        return{
            name:'',
            driveLink:'',
            sku:'',
            daraz:'',
            decorguys:'',
            carstickers:'',
            image:'',
            artcutFile:'',
            otherArtcutFile:'',
            api:'http://127.0.0.1:8000/api/product',
            avatar:'/no-image.png',
            errors:[]
        }
    },

    mounted(){
        this.showProduct()
    },

    methods:{
        uploadImage(e){
            this.image = e.target.files[0];
            let render = new FileReader;
            render.readAsDataURL(this.image);
            render.onload = e => {
                this.avatar = e.target.result;
            }
        },

        uploadArtcutFile(e){
            this.artcutFile = e.target.files[0];
        },

        uploadOtherArtcutFile(e){
            this.otherArtcutFile = e.target.files[0];
        },

        async showProduct(){
            await this.axios.get(this.api+'/'+this.$route.params.id+'/edit').then(response=>{
                this.name = response.data.name
                this.driveLink = response.data.driveLink
                this.sku = response.data.sku
                this.daraz = response.data.daraz
                this.decorguys = response.data.decorguys
                this.carstickers = response.data.carstickers
                // this.image = response.data.image
                // this.artcutFile = response.data.artcutFile
                // this.otherArtcutFile = response.data.otherArtcutFile
                this.avatar = '/productimage/'+response.data.image
            }).catch(error=>{
                console.log(error)
            })
        },

        async update(e){
            e.preventDefault();
            let currentObj = this;
 
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
 
            let formData = new FormData();
            formData.append('name', this.name);
            formData.append('driveLink', this.driveLink);
            formData.append('sku', this.sku);
            formData.append('daraz', this.daraz);
            formData.append('decorguys', this.decorguys);
            formData.append('carstickers', this.carstickers);
            formData.append('image', this.image);
            formData.append('artcutFile', this.artcutFile);
            formData.append('otherArtcutFile', this.otherArtcutFile);
            formData.append('_method', 'PUT')

            await this.axios.post(this.api+'/'+this.$route.params.id, formData).then(response=>{
                this.$router.push({
                                    name: 'productIndex'
                                });
            }).catch(error=>{
               this.errors = error.response.data.errors
            })
        },

        back(){
            this.$router.push({
                name: 'productIndex'
            });
        }
    }
}
</script>

<style>
.errors{
    color: red;
}
</style>