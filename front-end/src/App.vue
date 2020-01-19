<template>
    <router-view></router-view>
</template>

<style>
    * {
        margin: 0;
        padding: 0;
    }
    html,
    body {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    a {
        text-decoration: none;
    }
    a:visited {
        color: blue
    }
    .slide-fade-enter-active {
        transition: all .1s ease;
    }
    .slide-fade-leave-active {
        transition: all .1s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter,
    .slide-fade-leave-to {
        transform: translateX(10px);
        opacity: 0;
    }
    ::-webkit-scrollbar-track {
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb {
        border-radius: 10px;
        background: rgb(122, 153, 217);
    }
    /* ::-webkit-scrollbar {
        width: 0;
        height: 0;
    } */
    .container {
        width: 100%;
        height: 100%;
    }
    .main-menu {
        height: 100%;
    }
    .title {
        width: 100%;
        height: 80px;
    }
    .title p {
        color: white;
        text-align: center;
        line-height: 80px;
        font-size: 1.2em;
        cursor: pointer;
    }
    .el-container {
        width: 100%;
        height: 100%;
    }
    .el-pagination {
        text-align: right;
    }
    .el-card {
        height: fit-content;
    }
    .el-drawer {
        padding: 30px;
    }
</style>