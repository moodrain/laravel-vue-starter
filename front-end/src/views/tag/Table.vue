<template>
    <el-container>
        <el-card>
            <el-collapse>
                <el-collapse-item title="Filters">
                    <el-form :inline="true">
                        <el-form-item label="ID">
                            <el-input v-model="search.id"></el-input>
                        </el-form-item>
                        <el-form-item label="Name">
                            <el-input v-model="search.name"></el-input>
                        </el-form-item>
                        <el-form-item label="Creator">
                            <el-input v-model="search.creator"></el-input>
                        </el-form-item>
                        <br />
                        <el-form-item label="CreatedAt">
                            <el-date-picker v-model="search.createdAt" type="daterange" value-format="yyyy-MM-dd"
                                range-separator="-" start-placeholder="begin" end-placeholder="end">
                            </el-date-picker>
                        </el-form-item>
                        <el-form-item>
                            <el-button @click="submit" icon="el-icon-search"></el-button>
                            <el-button @click="clear" icon="el-icon-refresh-left"></el-button>
                        </el-form-item>
                    </el-form>
                </el-collapse-item>
            </el-collapse>
            <el-table border  v-loading="loading" :data="data" @sort-change="sortChange" max-height="590" height="590" ref="table">
                <el-table-column fixed="left" prop="id" sortable="custom" label="ID" min-width="80"></el-table-column>
                <el-table-column fixed="left" prop="name" label="Name" min-width="120"></el-table-column>
                <el-table-column prop="user.name" label="creator" min-width="200"></el-table-column>
                <el-table-column prop="click" label="click" sortable="custom" min-width="80"></el-table-column>
                <el-table-column prop="weight" label="weight" sortable="custom" min-width="100"></el-table-column>
                <el-table-column prop="createdAt" label="CreatedAt" sortable="custom" min-width="200"></el-table-column>
                <el-table-column prop="updatedAt" label="UpdatedAt" sortable="custom" min-width="200"></el-table-column>
                <el-table-column fixed="right" label="Operation" min-width="150">
                    <template slot-scope="scope">
                        <el-button @click="edit(scope)" type="default" size="mini">edit</el-button>
                        <el-button @click="remove(scope)" type="danger" size="mini">delete</el-button>
                    </template>
                </el-table-column>
            </el-table>
            <el-pagination @size-change="handleSizeChange" @current-change="handleCurrentChange" :current-page="1"
                :page-sizes="[10, 20, 50, 100]" :page-size="perPage" layout="total, sizes, jumper, prev, pager, next"
                :total="total">
            </el-pagination>
        </el-card>
        <el-drawer :visible.sync="editTagShow" direction="rtl" :show-close="false" >
            <p style="text-align: center;">Edit Tag</p>
            <el-divider></el-divider>
            <el-form label-width="60px" :model="tag" :rules="tagFormRules" ref="tagForm">
                <el-form-item label="ID">
                    <el-input readonly type="number" min="0" v-model="tag.id"></el-input>
                </el-form-item>
                <el-form-item label="Name" prop="name">
                    <el-input v-model="tag.name"></el-input>
                </el-form-item>
                <el-form-item label="Weight" prop="weight">
                    <el-input v-model="tag.weight"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button @click="updateTag">Submit</el-button>
                </el-form-item>
            </el-form>
        </el-drawer>
    </el-container>
</template>

<script>
    export default {
        data() {
            return {
                page: 1,
                perPage: 10,
                total: 0,
                data: [],
                loading: true,
                search: {
                    id: null,
                    name: null,
                    creator: null,
                    createdAt: null,
                },
                sort: {},
                editTagShow: false,
                tag: {
                    id: null,
                    name: null,
                    weight: null,
                },
                tagFormRules: {
                    name: [{required:true}],
                    weight: [{required:true}]
                }
            }
        },
        created() {
            this.$emit('setTitle', 'Tag Table')
            this.loadPage()
        },
        methods: {
            handleSizeChange(perPage) {
                this.perPage = perPage
                this.loadPage()
            },
            handleCurrentChange(page) {
                this.page = page
                this.loadPage()
            },
            sortChange({ prop, order }) {
                this.sort[prop] = order == 'ascending' ? 1 : -1
                this.loadPage()
            },
            loadPage() {
                this.loading = true
                let param = { page: this.page, perPage: this.perPage }
                param = Object.assign({}, param, { search: this.search }, { sort: this.sort })
                this.$get('tag', param, rs => {
                    this.page = rs.page
                    this.data = rs.data
                    this.total = rs.total
                    this.loading = false
                })
            },
            submit() {
                this.page = 1
                this.loadPage()
            },
            clear() {
                for (let key in this.search) {
                    this.search[key] = null
                }
                for (let key in this.sort) {
                    this.sort[key] = null
                }
                this.$refs['table'].clearSort()
            },
            remove(row) {
                this.$confirm('Confirm delete ?', 'Warning', {
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                }).then(() => {
                    this.loading = true
                    this.$delete('tag/' + row.row.id, () => {
                        this.data.splice(row.$index, 1)
                        this.loading = false
                    }, msg => {
                        this.$noty(msg)
                        this.loading = false
                    })
                }).catch(() => {})
            },
            edit({row}) {
                this.tag.id = row.id
                this.tag.name = row.name
                this.tag.weight = row.weight
                this.editTagShow = true
            },
            updateTag() {
                let pass = true
                this.$refs['tagForm'].validate((valid) => {
                    if(! valid) {
                        pass = false
                    }
                })
                if(! pass) {
                    return
                }
                const loading = this.$loading()
                this.$put('tag/' + this.tag.id, {name: this.tag.name, weight: this.tag.weight}, () => {
                    let tag = this.data.find(tag => tag.id === this.tag.id)
                    tag.name = this.tag.name
                    tag.weight = this.tag.weight
                    loading.close()
                    this.editTagShow = false
                }, msg => {
                    this.$noty(msg)
                    loading.close()
                })
            }
        }
    }
</script>