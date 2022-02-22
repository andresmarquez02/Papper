export default function log({ next, router }) {
    if (localStorage.getItem('logueado') == "No") {
        return router.push({ name: 'papper_login' });
    }
    return next();
}
