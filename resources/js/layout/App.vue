<template>
<div id="wrapper">

        <sidebar></sidebar>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <navbar></navbar>

                <!-- Begin Page Content -->
                <router-view></router-view>
                
                <!-- /.container-fluid -->

            </div>

            <app-footer></app-footer>

        </div>

    </div>
</template>
<script>
    import Navbar from './Navbar'
    import Sidebar from './Sidebar'
    import AppFooter from './Footer'

    export default {
        name:'app',
        components: {
            Navbar,
            Sidebar,
            AppFooter
        }
    };

</script>