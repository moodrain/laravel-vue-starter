<template>
    <el-container>
        <el-card>
            <el-form label-width="60px" :model="form" :rules="rules" ref="form" style="width: 500px;" v-loading="loading">
                <el-form-item label="Name" prop="name">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="Weight" prop="weight">
                    <el-input v-model="form.weight"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button @click="submit">Submit</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </el-container>

</template>

<script>
    export default {
        data() {
            return {
                loading: false,
                form: {
                    name: null,
                    weight: null,
                },
                rules: {
                    name: [{required: true}],
                    weight: [{required: true}],
                }
            }
        },
        created() {
            this.$emit('setTitle', 'Tab Form')
        },
        methods: {
            submit() {
                let pass = true
                this.$refs['form'].validate((valid) => {
                    if(! valid) {
                        pass = false
                    }
                })
                if(! pass) {
                    return
                }
                this.loading = true
                this.$post('tag', this.form, () => {
                    this.form.name = null
                    this.form.weight = null
                    this.$notify({
                        type: 'success',
                        message: 'success',
                    })
                    this.loading = false
                }, msg => {
                    this.$noty(msg)
                    this.loading = false
                })
            }
        },
    }
</script>