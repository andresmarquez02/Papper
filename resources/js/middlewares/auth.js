export default function auth({ next, router }) {
    if (localStorage.getItem('logueado') == "Si") {
        return router.push({ name: 'principal' });
    }
    return next();
}