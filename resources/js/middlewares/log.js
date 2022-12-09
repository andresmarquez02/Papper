export default function log({ next, router }) {
    if (localStorage.getItem('logueado') == "No") {
        router.push({ name: 'principal' })
        return router.push({ name: 'papper_login' });
    }
    return next();
}