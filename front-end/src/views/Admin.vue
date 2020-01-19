<template>
    <el-container>
        <m-menu :active="menuActive"></m-menu>
        <el-container>
            <el-header><m-header :title="headerTitle"></m-header></el-header>
            <el-main>
                <router-view @setTitle="setTitle"></router-view>
            </el-main>
        </el-container>
    </el-container>
</template>

<script>
    export default {
        props: ['menuActive'],
        data() {
            return {
                headerTitle: ''
            }
        },
        methods: {
            setTitle(title) {
                this.headerTitle = title
                document.title = title + ' ' + this.appName
            }
        }
    }
</script>