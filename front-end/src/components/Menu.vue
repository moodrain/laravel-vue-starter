<template>
    <el-aside width="200px">
        <el-menu class="main-menu" background-color="#545c64" text-color="#fff"
            active-text-color="#ffd04b" :router="true" :default-active="active ? active : '/'">
            <div class="title">
                <p  @click="goHome">{{ appName }}</p>
            </div>
            <el-menu-item index="/">Dashboard</el-menu-item>
            <el-submenu index="tag">
                <template slot="title">Tag</template>
                <el-menu-item index="/tag/table">Table</el-menu-item>
                <el-menu-item index="/tag/form">Form</el-menu-item>
            </el-submenu>
            <el-menu-item index="/clipboard-demo">Clipboard Demo</el-menu-item>
            <el-menu-item index="/more">More ...</el-menu-item>
        </el-menu>
    </el-aside>
</template>

<script>
    export default {
        props: ['active'],
        methods: {
            goHome() {
                this.$route.path != '/' && this.$router.push('/')
            }
        },
    }
</script>

<style>
</style>