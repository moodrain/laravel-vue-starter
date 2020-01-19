import Vue from 'vue'
import Router from 'vue-router'
import Admin from './views/Admin.vue'
import Dashboard from './views/Dashboard.vue'
import ClipboardDemo from './views/ClipboardDemo.vue'
import TagTable from './views/tag/Table.vue'
import TagForm from './views/tag/Form.vue'
import More from './views/More.vue'


Vue.use(Router)

export default new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            component: Admin,
            props: route => {
                return {
                    'menuActive': route.path
                }
            },
            children: [
                {
                    path: '',
                    component: Dashboard,
                }, {
                    path: 'tag/table',
                    component: TagTable,
                }, {
                    path: 'tag/form',
                    component: TagForm,
                }, {
                    path: 'clipboard-demo',
                    component: ClipboardDemo,
                }, {
                    path: 'more',
                    component: More,
                }
            ]
        }
    ]
})
