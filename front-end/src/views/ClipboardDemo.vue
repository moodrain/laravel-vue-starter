<template>
    <el-card>
        <p>{{ copyText }}</p>
        <el-divider></el-divider>
        <el-button ref="copyButton" :data-clipboard-text="copyText">copy</el-button>
    </div>
    </el-card>
</template>

<script>
    import clipboard from 'clipboard'
    export default {
        data() {
            return {
                copyText: 'before 3 seconds'
            }
        },
        mounted() {
            this.$emit('setTitle', 'Clipboard Demo')
            new clipboard(this.$refs.copyButton.$el)
            setTimeout(() => {
                this.copyText = 'after 3 seconds'
            }, 3000)
        }
    }
</script>