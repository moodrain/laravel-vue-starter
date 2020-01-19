<template>
    <el-card>
        <div class="title-div" style="font-size: 20px">{{ title }}</div>
        <div class="user-div">
            <el-dropdown trigger="click" :hide-on-click="false">
                <span class="el-dropdown-link"><el-button  icon="el-icon-user" circle></el-button></span>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item disabled>{{ user.name ? user.name : 'not login' }}</el-dropdown-item>
                    <el-dropdown-item divided><p @click="logout">logout</p></el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
    </el-card>
</template>

<script>
    export default {
        props: ['title'],
        data() {
            return {
                user: {
                    id: null,
                    name: null,
                }
            }
        },
        created() {
            this.$get('profile', rs => {
                this.user.id = rs.id
                this.user.name = rs.name
            }, msg => {
                this.$noty(msg)
                setTimeout(() => {
                    window.location.href = '/login'
                }, 2000)
            })
        },
        methods: {
            logout() {
                this.$post('logout', () => {
                    window.location.href = '/login'
                }, () => {
                    window.location.href = '/login'
                })
            }
        }
    }
</script>

<style scoped>
    .title-div {
        display: inline-block;
    }
    .user-div {
        float: right;
        margin-top: -5px;
        margin-right: 5px;
    }
</style>