export default function log({ next, router }) {
    if (localStorage.getItem('authenticate') == "false") {
        router.push({ name: 'index' })
        return router.push({ name: 'login' });
    }
    return next();
}
