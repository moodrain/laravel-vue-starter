import axios from 'axios'
import qs from 'qs'

axios.defaults.baseURL = process.env.VUE_APP_API
axios.defaults.headers['Accept'] = 'application/json'

let defaultErrHandler
let setDefaultErrHandler = handler => {
    defaultErrHandler = handler
}


let handleRs = (rs, ok, err, url, method) => {
    if(rs && rs.code === 0) {
        ok && ok(rs.data, rs.msg)
    } else {
        if(err) {
            err(rs.msg, rs.data)
        } else if(defaultErrHandler) {
            defaultErrHandler(rs.msg, rs.data)
        }
    }
}
let req = (method, url, dataOrOk, okOrErr, err) => {
    let data, ok
    let config = {method, url}
    if(typeof dataOrOk === 'function') {
        data = null
        ok = dataOrOk
        err = okOrErr
    } else {
        data = dataOrOk
        ok = okOrErr
    }
    method == 'get' && data ? (config.url += '?' + qs.stringify(data, { encode: false })) : config.data = data
    axios(config).then(rs => {
        handleRs(rs.data, ok, err, url, method)
    })
}
let get = (url, dataOrOk, okOrErr, err) => {
    req('get', url, dataOrOk, okOrErr, err)
}
let post = (url, dataOrOk, okOrErr, err) => {
    req('post', url, dataOrOk, okOrErr, err)
}
let put = (url, dataOrOk, okOrErr, err) => {
    req('put', url, dataOrOk, okOrErr, err)
}
let patch = (url, dataOrOk, okOrErr, err) => {
    req('put', url, dataOrOk, okOrErr, err)
}
let del = (url, dataOrOk, okOrErr, err) => {
    req('delete', url, dataOrOk, okOrErr, err)
}

export default {
    req, get, post, put, patch, del, setDefaultErrHandler,
}
