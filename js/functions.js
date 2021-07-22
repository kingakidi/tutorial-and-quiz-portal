function _(x) {
    return document.getElementById(x)
}
function success(x) {
    return `<span class='text-success'>${x}</span>`
}
function info(x) {
    return `<span class='text-info'>${x}</span>`
}
function error(x) {
    return `<span class='text-danger'>${x}</span>`
}

function clean(x) {
    return x.value.length
}

